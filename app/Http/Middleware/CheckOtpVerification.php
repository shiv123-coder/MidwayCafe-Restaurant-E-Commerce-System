<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CheckOtpVerification
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && Auth::user()->is_verified == 0) {
            
            // Bypass OTP verification for admin and staff users
            if (in_array(Auth::user()->usertype, ['1', '3'])) {
                return $next($request);
            }

            $email = Auth::user()->email;
            Auth::logout();
            
            Session::put('otp_email', $email);
            
            return redirect()->route('otp.verify')->with('wrong', 'Your account is not verified. Please verify your email first.');
        }

        return $next($request);
    }
}
