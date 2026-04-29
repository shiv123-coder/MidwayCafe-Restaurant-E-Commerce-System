@extends('layouts.app', ['title' => 'Reservation Confirmed'])

@section('page-content')
<div class="reservation-success-wrap" style="text-align: center; padding: 60px 0;">
    <div class="card shadow-sm" style="background: white; padding: 60px; border-radius: 15px; display: inline-block; border: none;">
        <div style="border-radius:200px; height:200px; width:200px; background: #F8FAF5; margin:0 auto; display: flex; align-items: center; justify-content: center;">
            <i class="fa fa-check" style="color: #9ABC66; font-size: 80px;"></i>
        </div>
        <h1 style="color: #88B04B; font-weight: 900; font-size: 40px; margin-top: 20px;">Success</h1> 
        <p style="color: #404F5E; font-size: 20px; margin-top: 10px;">
            Your reservation has been placed successfully!<br/>
            We have sent a confirmation email to your address.
        </p>
        <div class="mt-4">
            <a href="{{ url('/') }}" class="btn btn-success px-4 py-2" style="border-radius: 30px; background-color: #88B04B; border: none;">Back to Home</a>
        </div>
    </div>
</div>
@endsection
