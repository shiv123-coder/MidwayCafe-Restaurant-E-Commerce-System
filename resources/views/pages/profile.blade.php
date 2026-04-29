@extends('layouts.app', ['title' => 'My Profile'])

@push('styles')
<style>
    .profile-container {
        padding: 100px 0;
        background: #f8f9fa;
    }
    .profile-card {
        background: #fff;
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        padding: 40px;
        border: none;
    }
    .profile-header {
        margin-bottom: 30px;
        border-bottom: 2px solid #eee;
        padding-bottom: 20px;
    }
    .profile-header h2 {
        color: #fb5849;
        font-weight: 700;
        margin: 0;
    }
    .form-group label {
        font-weight: 600;
        color: #444;
        margin-bottom: 8px;
    }
    .form-control {
        border-radius: 8px;
        padding: 12px 15px;
        border: 1px solid #ddd;
    }
    .form-control:focus {
        border-color: #fb5849;
        box-shadow: 0 0 0 0.2rem rgba(251, 88, 73, 0.25);
    }
    .btn-update {
        background: #fb5849;
        color: #fff;
        border: none;
        padding: 12px 30px;
        border-radius: 8px;
        font-weight: 600;
        transition: 0.3s;
        margin-top: 20px;
    }
    .btn-update:hover {
        background: #d43f33;
        color: #fff;
        transform: translateY(-2px);
    }
    .alert-success {
        border-radius: 10px;
        border: none;
        background: #d4edda;
        color: #155724;
        padding: 15px 20px;
        margin-bottom: 30px;
    }
</style>
@endpush

@section('page-content')
<div class="profile-container">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="profile-card">
                    <div class="profile-header">
                        <h2>My Profile</h2>
                        <p class="text-muted">Manage your personal information and delivery details</p>
                    </div>

                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{ route('user.profile.update') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="name">Full Name</label>
                                    <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                                    @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="email">Email Address</label>
                                    <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                                    @error('email') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="phone">Phone Number</label>
                                    <input type="text" name="phone" id="phone" class="form-control" value="{{ old('phone', $user->phone) }}" required>
                                    @error('phone') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="usertype">Account Type</label>
                                    <input type="text" class="form-control" value="{{ $user->usertype == '0' ? 'Customer' : 'Staff' }}" disabled>
                                </div>
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <label for="address">Delivery Address</label>
                            <textarea name="address" id="address" class="form-control" rows="3" placeholder="Enter your default delivery address">{{ old('address', $user->address) }}</textarea>
                            @error('address') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="text-right">
                            <button type="submit" class="btn btn-update">Update Profile</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
