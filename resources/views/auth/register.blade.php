<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MidwayCafe - Create Account</title>
    <link rel="shortcut icon" type="image/x-icon" href="{{ Storage::url('images/short.jpg') }}">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family:'Outfit',sans-serif; background-color:#0f172a; color:#f8fafc; margin:0; overflow-x:hidden; }
        .bg-animated { background:linear-gradient(-45deg,#0f172a,#1e293b,#3b0764,#7e22ce); background-size:400% 400%; animation:gradientBG 15s ease infinite; }
        @keyframes gradientBG { 0%{background-position:0% 50%} 50%{background-position:100% 50%} 100%{background-position:0% 50%} }
        .glass-card { background:rgba(30,41,59,0.6); backdrop-filter:blur(16px); -webkit-backdrop-filter:blur(16px); border:1px solid rgba(255,255,255,0.08); box-shadow:0 25px 50px -12px rgba(0,0,0,0.5); border-radius:1.5rem; }
        .input-group { position:relative; margin-bottom:1.5rem; }
        .input-group input { width:100%; padding:1rem 3rem 1rem 1.25rem; background:rgba(15,23,42,0.5); border:1px solid rgba(255,255,255,0.1); border-radius:0.75rem; color:white; outline:none; transition:all 0.3s ease; font-size:1rem; box-sizing:border-box; }
        .input-group input:focus { border-color:#ec4899; box-shadow:0 0 0 4px rgba(236,72,153,0.15); }
        .input-group label { position:absolute; left:1.25rem; top:50%; transform:translateY(-50%); color:#94a3b8; pointer-events:none; transition:all 0.3s ease; background:transparent; padding:0 0.25rem; }
        .input-group input:focus~label, .input-group input:not(:placeholder-shown)~label { top:0; font-size:0.85rem; color:#ec4899; background:#1e293b; border-radius:4px; }
        .eye-toggle { position:absolute; right:1rem; top:50%; transform:translateY(-50%); background:none; border:none; cursor:pointer; color:#94a3b8; padding:0; display:flex; align-items:center; transition:color 0.2s; }
        .eye-toggle:hover { color:#ec4899; }
        .btn-primary { background:linear-gradient(135deg,#f472b6,#db2777); transition:all 0.3s ease; }
        .btn-primary:hover { transform:translateY(-2px); box-shadow:0 10px 25px -5px rgba(219,39,119,0.5); }
        .image-overlay { background:linear-gradient(to right,rgba(15,23,42,0.8),rgba(15,23,42,0.2)); }
    </style>
</head>
<body class="bg-animated min-h-screen flex items-center justify-center p-4 sm:p-6 lg:p-8">
    <div class="glass-card w-full max-w-6xl mx-auto flex flex-col lg:flex-row overflow-hidden max-h-[95vh] overflow-y-auto lg:overflow-y-hidden">
        <!-- Left Side: Brand -->
        <div class="hidden lg:flex w-1/2 relative">
            <img src="{{ Storage::url('images/about-video-bg.jpg') }}" alt="MidwayCafe" class="absolute inset-0 w-full h-full object-cover" style="filter:hue-rotate(45deg);">
            <div class="absolute inset-0 image-overlay"></div>
            <div class="relative z-10 flex flex-col justify-between p-12 h-full">
                <div>
                    <h1 class="text-4xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-pink-400 to-rose-400">Join MidwayCafe</h1>
                    <p class="mt-4 text-lg text-slate-300 max-w-md leading-relaxed">Create your account to unlock exclusive table reservations, faster checkout, and member-only culinary offers.</p>
                </div>
                <div class="space-y-4">
                    <div class="flex items-center space-x-4 glass-card p-4 rounded-xl max-w-sm">
                        <div class="w-12 h-12 rounded-full bg-pink-500/20 flex items-center justify-center text-pink-400">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        </div>
                        <div>
                            <h3 class="font-semibold text-white">Instant Registration</h3>
                            <p class="text-sm text-slate-400">Start exploring in 60 seconds</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Right Side: Register Form -->
        <div class="w-full lg:w-1/2 p-8 sm:p-12 lg:p-16 flex flex-col justify-center overflow-y-auto">
            <div class="text-center lg:text-left mb-8">
                <img src="{{ Storage::url('images/logo.png') }}" alt="Logo" class="h-16 w-auto mx-auto lg:mx-0 mb-6 lg:hidden">
                <h2 class="text-3xl font-bold text-white mb-2">Create Account</h2>
                <p class="text-slate-400">Fill in your details to get started</p>
            </div>
            @if(Session::has('wrong'))
                <div class="mb-4 bg-red-500/10 border border-red-500/20 text-red-400 px-4 py-3 rounded-xl text-sm flex justify-between items-center">
                    <span><strong>Oops!</strong> {{ Session::get('wrong') }}</span>
                    <button onclick="this.parentElement.style.display='none';" class="text-red-400 hover:text-red-300 font-bold text-xl">&times;</button>
                </div>
            @endif
            @if(Session::has('success'))
                <div class="mb-4 bg-green-500/10 border border-green-500/20 text-green-400 px-4 py-3 rounded-xl text-sm flex justify-between items-center">
                    <span><strong>Success!</strong> {{ Session::get('success') }}</span>
                    <button onclick="this.parentElement.style.display='none';" class="text-green-400 hover:text-green-300 font-bold text-xl">&times;</button>
                </div>
            @endif
            <x-jet-validation-errors class="mb-4 bg-red-500/10 border border-red-500/20 text-red-400 px-4 py-3 rounded-xl text-sm" />
            <form method="POST" action="{{ route('register/confirm') }}" class="space-y-4">
                @csrf
                <div class="input-group">
                    <input type="text" id="name" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" placeholder=" ">
                    <label for="name">Full Name</label>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="input-group">
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required placeholder=" ">
                        <label for="email">Email Address</label>
                    </div>
                    <div class="input-group">
                        <input type="number" id="phone" name="phone" value="{{ old('phone') }}" required placeholder=" ">
                        <label for="phone">Phone Number</label>
                    </div>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="input-group">
                        <input type="password" id="reg-password" name="password" required autocomplete="new-password" placeholder=" ">
                        <label for="reg-password">Password</label>
                        <button type="button" class="eye-toggle" onclick="togglePwd('reg-password')" aria-label="Toggle password visibility">
                            <svg id="eye-o-reg-password" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            <svg id="eye-c-reg-password" class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/></svg>
                        </button>
                    </div>
                    <div class="input-group">
                        <input type="password" id="reg-confirm" name="password_confirmation" required autocomplete="new-password" placeholder=" ">
                        <label for="reg-confirm">Confirm Password</label>
                        <button type="button" class="eye-toggle" onclick="togglePwd('reg-confirm')" aria-label="Toggle confirm password visibility">
                            <svg id="eye-o-reg-confirm" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            <svg id="eye-c-reg-confirm" class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/></svg>
                        </button>
                    </div>
                </div>
                <button type="submit" class="btn-primary w-full py-4 rounded-xl text-white font-semibold flex justify-center items-center space-x-2 mt-4">
                    <span>Create Account</span>
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </button>
            </form>
            <div class="mt-8 text-center">
                <p class="text-slate-400">Already registered? <a href="{{ route('login') }}" class="text-pink-400 hover:text-pink-300 font-semibold transition-colors">Log in instead</a></p>
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
