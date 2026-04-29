<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTP Verification</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f3f4f6; }
    </style>
</head>
<body class="flex items-center justify-center min-h-screen">

<div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-md">
    <h2 class="text-2xl font-bold text-gray-800 text-center mb-6">Verify Your Account</h2>
    <p class="text-gray-600 text-center mb-4">We sent a 6-digit OTP to your email address: <strong>{{ Session::get('otp_email') }}</strong></p>

    @if(Session::has('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded mb-4 text-center text-sm">
            {{ Session::get('success') }}
        </div>
    @endif
    @if(Session::has('wrong'))
        <div class="bg-red-100 text-red-700 p-3 rounded mb-4 text-center text-sm">
            {{ Session::get('wrong') }}
        </div>
    @endif

    <form action="{{ route('otp.verify.submit') }}" method="POST">
        @csrf
        <div class="mb-5">
            <label for="otp" class="block text-sm font-medium text-gray-700 mb-2">Enter OTP</label>
            <input type="text" name="otp" id="otp" maxlength="6" pattern="\d{6}" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500 text-center text-xl tracking-widest outline-none transition duration-200" required placeholder="XXXXXX">
        </div>
        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition duration-200">
            Verify Now
        </button>
    </form>

    <p class="text-gray-500 text-sm text-center mt-6">
        Didn't receive the code? 
        <a href="{{ route('otp.resend') }}" class="text-blue-600 hover:underline">Resend OTP</a>
    </p>
</div>

</body>
</html>
