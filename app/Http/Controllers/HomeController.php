<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;
use PDF;

class HomeController extends Controller
{
    public function index()
    {
        $menu = Cache::remember('home_menu', 3600, function () {
            return \App\Models\Product::withAvg('ratings as avg_rating', 'star_value')
                ->where('category', 'regular')
                ->limit(10)
                ->get();
        });

        $breakfast = Cache::remember('home_breakfast', 3600, function () {
            return \App\Models\Product::withAvg('ratings as avg_rating', 'star_value')
                ->where('session', 0)
                ->limit(6)
                ->get();
        });

        $lunch = Cache::remember('home_lunch', 3600, function () {
            return \App\Models\Product::withAvg('ratings as avg_rating', 'star_value')
                ->where('session', 1)
                ->limit(6)
                ->get();
        });

        $dinner = Cache::remember('home_dinner', 3600, function () {
            return \App\Models\Product::withAvg('ratings as avg_rating', 'star_value')
                ->where('session', 2)
                ->limit(6)
                ->get();
        });

        $chefs = Cache::remember('home_chefs', 3600, function () {
            return DB::table('chefs')->limit(6)->get();
        });
        $about_us = Cache::remember('home_about_us', 3600, function () {
            return DB::table('about_us')->limit(1)->get();
        });
        $banners = Cache::remember('home_banners', 3600, function () {
            return DB::table('banners')->limit(5)->get();
        });

        $cart_amount = Auth::check()
            ? DB::table('carts')
                ->where('user_id', Auth::id())
                ->where('product_order', 'no')
                ->count()
            : 0;

        return view('pages.home', compact(
            'menu',
            'breakfast',
            'lunch',
            'dinner',
            'chefs',
            'about_us',
            'banners',
            'cart_amount'
        ));
    }

    public function redirects()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $usertype = Auth::user()->usertype;

        if ($usertype == '1' || $usertype == '3') {
            return redirect()->route('admin.dashboard');
        }

        return redirect('/');
    }

    // 🔥🔥🔥 FIXED FUNCTION
    public function reservation_confirm(Request $req)
    {
        // ✅ VALIDATION
        $req->validate([
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'no_guest' => 'required|integer',
            'date' => 'required',
            'time' => 'required'
        ]);

        // ✅ DATE FORMAT FIX
        try {
            $formattedDate = Carbon::createFromFormat('d/m/Y', $req->date)->format('Y-m-d');
        } catch (\Exception $e) {
            return back()->withErrors(['date' => 'Invalid date format. Use DD/MM/YYYY']);
        }

        // ✅ SAVE TO DB
        DB::table('reservations')->insert([
            'name' => $req->name,
            'email' => $req->email,
            'phone' => $req->phone,
            'no_guest' => $req->no_guest,
            'date' => $formattedDate,
            'time' => $req->time,
            'message' => $req->message,
        ]);

        // ✅ CORRECT MAIL DATA (FIXED)
        $mailData = [
            'name' => $req->name,
            'email' => $req->email,
            'phone' => $req->phone,
            'no_guest' => $req->no_guest,
            'date' => $formattedDate,
            'time' => $req->time,
            'message' => $req->message,
        ];

        // ✅ GENERATE PDF
        $pdf = PDF::loadView('mails.reserve-mail', $mailData);

        // ✅ SEND MAIL
        Mail::send('mails.reserve-mail', $mailData, function ($message) use ($req, $pdf) {
            $message->to($req->email)
                ->subject("Reservation Confirmation")
                ->attachData($pdf->output(), "Reservation.pdf");
        });

        return view('pages.reserve-order');
    }

    public function rate($id)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $already_rate = DB::table('rates')
            ->where('product_id', $id)
            ->where('user_id', Auth::id())
            ->count();

        $find_rate = DB::table('rates')
            ->where('product_id', $id)
            ->where('user_id', Auth::id())
            ->value('star_value');

        $products = DB::table('products')->where('id', $id)->first();

        $total_rate = DB::table('rates')->where('product_id', $id)->sum('star_value');
        $total_voter = DB::table('rates')->where('product_id', $id)->count();

        $per_rate = $total_voter > 0 ? number_format($total_rate / $total_voter, 1) : 0;

        return view($already_rate > 0 ? 'pages.rate_view' : 'pages.rate', compact(
            'products',
            'find_rate',
            'already_rate',
            'total_rate',
            'total_voter',
            'per_rate'
        ));
    }

    public function store_rate($value)
    {
        $product_id = Session::get('product_id');
        $user_id = Auth::id();

        DB::updateOrInsert(
            [
                'product_id' => $product_id,
                'user_id' => $user_id
            ],
            [
                'star_value' => $value
            ]
        );

        return view('pages.place-rate');
    }

    public function delete_rate()
    {
        DB::table('rates')
            ->where('product_id', Session::get('product_id'))
            ->where('user_id', Auth::id())
            ->delete();

        return view('pages.delete_rate_confirm');
    }

    public function edit_rate($id)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $find_rate = DB::table('rates')
            ->where('product_id', $id)
            ->where('user_id', Auth::id())
            ->value('star_value');

        $products = DB::table('products')->where('id', $id)->first();

        $total_rate = DB::table('rates')->where('product_id', $id)->sum('star_value');
        $total_voter = DB::table('rates')->where('product_id', $id)->count();

        $per_rate = $total_voter > 0 ? number_format($total_rate / $total_voter, 1) : 0;

        return view('pages.rate', compact(
            'products',
            'find_rate',
            'total_rate',
            'total_voter',
            'per_rate'
        ));
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'phone' => 'required',
            'password' => 'required|confirmed'
        ]);

        $user = \App\Models\User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'usertype' => '0',
            'is_verified' => 0
        ]);

        $otpCode = random_int(100000, 999999);

        \App\Models\Otp::create([
            'email' => $request->email,
            'otp' => $otpCode
        ]);

        try {
            Mail::to($request->email)->send(new \App\Mail\OtpMail($otpCode));
        } catch (\Exception $e) {
            \Log::error('OTP send failed: ' . $e->getMessage());
        }

        Session::put('otp_email', $request->email);

        return redirect()->route('otp.verify')
            ->with('success', 'OTP sent to your email');
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $escapedQuery = addcslashes($query, '%_');

        $products = \App\Models\Product::withAvg('ratings as avg_rating', 'star_value')
            ->where('name', 'ILIKE', "%{$escapedQuery}%")
            ->orWhere('description', 'ILIKE', "%{$escapedQuery}%")
            ->get();

        return view('pages.search', compact('products', 'query'));
    }

    public function profile()
    {
        $user = Auth::user();
        return view('pages.profile', compact('user'));
    }

    public function profile_update(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'required',
        ]);

        DB::table('users')->where('id', $user->id)->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
        ]);

        return back()->with('success', 'Profile updated successfully!');
    }
}
