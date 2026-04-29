<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MidwayCafe - Login</title>
    <link rel="shortcut icon" type="image/x-icon" href="{{ Storage::url('images/short.jpg') }}">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family: 'Outfit', sans-serif; background-color: #0f172a; color: #f8fafc; margin: 0; overflow-x: hidden; }
        .bg-animated { background: linear-gradient(-45deg, #0f172a, #1e293b, #3b0764, #7e22ce); background-size: 400% 400%; animation: gradientBG 15s ease infinite; }
        @keyframes gradientBG { 0%{background-position:0% 50%} 50%{background-position:100% 50%} 100%{background-position:0% 50%} }
        .glass-card { background:rgba(30,41,59,0.6); backdrop-filter:blur(16px); -webkit-backdrop-filter:blur(16px); border:1px solid rgba(255,255,255,0.08); box-shadow:0 25px 50px -12px rgba(0,0,0,0.5); border-radius:1.5rem; }
        .input-group { position:relative; margin-bottom:1.5rem; }
        .input-group input { width:100%; padding:1rem 3rem 1rem 1.25rem; background:rgba(15,23,42,0.5); border:1px solid rgba(255,255,255,0.1); border-radius:0.75rem; color:white; outline:none; transition:all 0.3s ease; font-size:1rem; box-sizing:border-box; }
        .input-group input:focus { border-color:#a855f7; box-shadow:0 0 0 4px rgba(168,85,247,0.15); }
        .input-group label { position:absolute; left:1.25rem; top:50%; transform:translateY(-50%); color:#94a3b8; pointer-events:none; transition:all 0.3s ease; background:transparent; padding:0 0.25rem; }
        .input-group input:focus~label, .input-group input:not(:placeholder-shown)~label { top:0; font-size:0.85rem; color:#a855f7; background:#1e293b; border-radius:4px; }
        .eye-toggle { position:absolute; right:1rem; top:50%; transform:translateY(-50%); background:none; border:none; cursor:pointer; color:#94a3b8; padding:0; display:flex; align-items:center; transition:color 0.2s; }
        .eye-toggle:hover { color:#a855f7; }
        .custom-checkbox { appearance:none; width:1.25rem; height:1.25rem; border:2px solid rgba(255,255,255,0.2); border-radius:0.25rem; background:transparent; cursor:pointer; position:relative; transition:all 0.2s ease; }
        .custom-checkbox:checked { background:#a855f7; border-color:#a855f7; }
        .custom-checkbox:checked::after { content:''; position:absolute; left:5px; top:1px; width:5px; height:10px; border:solid white; border-width:0 2px 2px 0; transform:rotate(45deg); }
        .btn-primary { background:linear-gradient(135deg,#c084fc,#9333ea); transition:all 0.3s ease; }
        .btn-primary:hover { transform:translateY(-2px); box-shadow:0 10px 25px -5px rgba(147,51,234,0.5); }
        .image-overlay { background:linear-gradient(to right,rgba(15,23,42,0.8),rgba(15,23,42,0.2)); }
    </style>
</head>
<body class="bg-animated min-h-screen flex items-center justify-center p-4 sm:p-6 lg:p-8">
    <div class="glass-card w-full max-w-6xl mx-auto flex flex-col lg:flex-row overflow-hidden max-h-[90vh]">
        <!-- Left Side: Brand -->
        <div class="hidden lg:flex w-1/2 relative">
            <img src="{{ Storage::url('images/about-video-bg.jpg') }}" alt="MidwayCafe" class="absolute inset-0 w-full h-full object-cover">
            <div class="absolute inset-0 image-overlay"></div>
            <div class="relative z-10 flex flex-col justify-between p-12 h-full">
                <div>
                    <h1 class="text-4xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-purple-400 to-pink-400">MidwayCafe</h1>
                    <p class="mt-4 text-lg text-slate-300 max-w-md leading-relaxed">Experience premium dining. Log in to manage your orders, reservations, and explore exclusive culinary delights.</p>
                </div>
                <div class="space-y-4">
                    <div class="flex items-center space-x-4 glass-card p-4 rounded-xl max-w-sm">
                        <div class="w-12 h-12 rounded-full bg-purple-500/20 flex items-center justify-center text-purple-400">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                        </div>
                        <div>
                            <h3 class="font-semibold text-white">Secure Access</h3>
                            <p class="text-sm text-slate-400">Admin &amp; User Portals</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Right Side: Login Form -->
        <div class="w-full lg:w-1/2 p-8 sm:p-12 lg:p-16 flex flex-col justify-center">
            <div class="text-center lg:text-left mb-10">
                <img src="{{ Storage::url('images/logo.png') }}" alt="Logo" class="h-16 w-auto mx-auto lg:mx-0 mb-6 lg:hidden">
                <h2 class="text-3xl font-bold text-white mb-2">Welcome Back</h2>
                <p class="text-slate-400">Sign in to your account to continue</p>
            </div>
            <x-jet-validation-errors class="mb-4 bg-red-500/10 border border-red-500/20 text-red-400 px-4 py-3 rounded-xl text-sm" />
            @if (session('status'))
                <div class="mb-4 font-medium text-sm text-green-400 bg-green-500/10 border border-green-500/20 px-4 py-3 rounded-xl">{{ session('status') }}</div>
            @endif
            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf
                <div class="input-group">
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus placeholder=" ">
                    <label for="email">Email Address</label>
                </div>
                <div class="input-group">
                    <input type="password" id="login-password" name="password" required autocomplete="current-password" placeholder=" ">
                    <label for="login-password">Password</label>
                    <button type="button" class="eye-toggle" onclick="togglePwd('login-password')" aria-label="Toggle password visibility">
                        <svg id="eye-o-login-password" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        <svg id="eye-c-login-password" class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/></svg>
                    </button>
                </div>
                <div class="flex items-center justify-between mt-6">
                    <label for="remember_me" class="flex items-center space-x-3 cursor-pointer group">
                        <input id="remember_me" type="checkbox" name="remember" class="custom-checkbox">
                        <span class="text-sm text-slate-300 group-hover:text-white transition-colors">Remember me</span>
                    </label>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-sm text-purple-400 hover:text-purple-300 transition-colors font-medium">Forgot Password?</a>
                    @endif
                </div>
                <button type="submit" class="btn-primary w-full py-4 rounded-xl text-white font-semibold flex justify-center items-center space-x-2 mt-8">
                    <span>Sign In</span>
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </button>
            </form>
            <div class="mt-8 text-center">
                <p class="text-slate-400">Don't have an account? <a href="{{ route('register') }}" class="text-purple-400 hover:text-purple-300 font-semibold transition-colors">Create an account</a></p>
            </div>
        </div>
    </div>
    <script>
        function togglePwd(id) {
            var el = document.getElementById(id);
            var isPwd = el.type === 'password';
            el.type = isPwd ? 'text' : 'password';
            document.getElementById('eye-o-' + id).classList.toggle('hidden', isPwd);
            document.getElementById('eye-c-' + id).classList.toggle('hidden', !isPwd);
        }
    </script>
</body>
</html>
