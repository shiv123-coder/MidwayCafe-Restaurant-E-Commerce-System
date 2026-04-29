@extends('layouts.app', ['title' => 'Rating Success'])

@section('page-content')
<div class="rating-success-wrap" style="text-align: center; padding: 60px 0;">
    <div class="card shadow-sm" style="background: white; padding: 60px; border-radius: 15px; display: inline-block; border: none;">
        <div style="border-radius:200px; height:200px; width:200px; background: #F8FAF5; margin:0 auto; display: flex; align-items: center; justify-content: center;">
            <i class="fa fa-star" style="color: #ffc107; font-size: 80px;"></i>
        </div>
        <h1 style="color: #88B04B; font-weight: 900; font-size: 40px; margin-top: 20px;">Success</h1> 
        <p style="color: #404F5E; font-size: 20px; margin-top: 10px;">
            Thank you!<br/>
            We have received your rating for the dish.
        </p>
        <div class="mt-4">
            <a href="{{ url('/') }}" class="btn btn-success px-4 py-2" style="border-radius: 30px; background-color: #88B04B; border: none;">Back to Home</a>
        </div>
    </div>
</div>
@endsection
