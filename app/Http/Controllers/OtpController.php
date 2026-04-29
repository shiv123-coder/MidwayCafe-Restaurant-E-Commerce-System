<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Otp;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\OtpMail;
use Illuminate\Support\Facades\Session;

class OtpController extends Controller
{
    public function showVerifyForm()
    {
        if (!Session::has('otp_email')) {
            return redirect()->route('login');
        }
        return view('auth.otp-verify');
    }

    public function verify(Request $request)
    {
        $request->validate([
            'otp' => 'required|numeric|digits:6',
        ]);

        $email = Session::get('otp_email');
        if (!$email) {
            return redirect()->route('login')->with('wrong', 'Session expired. Please login again.');
        }

        $otpRecord = Otp::where('email', $email)->latest()->first();

        if ($otpRecord && $otpRecord->otp == $request->otp) {
            // Verify within 10 minutes (600 seconds)
            if (now()->diffInSeconds($otpRecord->created_at) > 600) {
                return back()->with('wrong', 'OTP has expired. Please resend.');
            }

            // Mark User as verified
            $user = User::where('email', $email)->first();
            if ($user) {
                $user->is_verified = true;
                $user->email_verified_at = now();
                $user->save();
                
                // Clear Otp records for user
                Otp::where('email', $email)->delete();

                Session::forget('otp_email');
                Auth::login($user);

                return redirect('/redirects')->with('success', 'Email verified successfully!');
            }
        }

        return back()->with('wrong', 'Invalid OTP entered.');
    }

    public function resend()
    {
        $email = Session::get('otp_email');
        if (!$email) {
            return redirect()->route('login')->with('wrong', 'Session expired. Please login again.');
        }
        
        $user = User::where('email', $email)->first();
        if ($user && $user->is_verified) {
            Session::forget('otp_email');
            return redirect()->route('login')->with('success', 'Account already verified. You can log in.');
        }
        
        $lastOtp = Otp::where('email', $email)->latest()->first();
        if ($lastOtp && now()->diffInSeconds($lastOtp->created_at) < 60) {
            return back()->with('wrong', 'Please wait before requesting a new OTP.');
        }

        $otpCode = random_int(100000, 999999);
        Otp::create([
            'email' => $email,
            'otp' => $otpCode
        ]);

        try {
            Mail::to($email)->send(new OtpMail($otpCode));
            return back()->with('success', 'A new OTP has been sent to your email.');
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('OTP resend failed: ' . $e->getMessage());
            return back()->with('wrong', 'Failed to send OTP email. Please try again later.');
        }
    }
}
