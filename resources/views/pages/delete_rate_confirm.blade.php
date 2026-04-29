@extends('layouts.app', ['title' => 'Rating Deleted'])

@section('page-content')
<div class="rating-delete-wrap" style="text-align: center; padding: 60px 0;">
    <div class="card shadow-sm" style="background: white; padding: 60px; border-radius: 15px; display: inline-block; border: none;">
        <div style="border-radius:200px; height:200px; width:200px; background: #FFF5F5; margin:0 auto; display: flex; align-items: center; justify-content: center;">
            <i class="fa fa-trash-alt" style="color: #E53E3E; font-size: 80px;"></i>
        </div>
        <h1 style="color: #E53E3E; font-weight: 900; font-size: 40px; margin-top: 20px;">Deleted</h1> 
        <p style="color: #404F5E; font-size: 20px; margin-top: 10px;">
            Your rating has been removed successfully.
        </p>
        <div class="mt-4">
            <a href="{{ url('/') }}" class="btn btn-primary px-4 py-2" style="border-radius: 30px; background-color: #4A5568; border: none;">Back to Home</a>
        </div>
    </div>
</div>
@endsection
