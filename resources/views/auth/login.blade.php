<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MidwayCafe - Login</title>
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('storage/images/short.jpg') }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                    colors: {
                        brand: {
                            50: '#fdf4ff',
                            100: '#fae8ff',
                            500: '#d946ef',
                            600: '#c026d3',
                            900: '#701a75',
                        }
                    }
                }
            }
        }
    </script>
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f8fafc; }
        .glass-panel { background: rgba(255, 255, 255, 0.7); backdrop-filter: blur(20px); border-left: 1px solid rgba(255, 255, 255, 0.3); }
        .fade-in-up { animation: fadeInUp 0.8s ease-out forwards; opacity: 0; transform: translateY(20px); }
        @keyframes fadeInUp { to { opacity: 1; transform: translateY(0); } }
        .delay-100 { animation-delay: 100ms; }
        .delay-200 { animation-delay: 200ms; }
        .delay-300 { animation-delay: 300ms; }
    </style>
</head>
<body class="min-h-screen flex text-slate-800 antialiased selection:bg-brand-500 selection:text-white">

    <!-- Left Side: Image & Brand -->
    <div class="hidden lg:flex lg:w-1/2 relative bg-slate-900 overflow-hidden">
        <!-- Added a fallback unsplash image for robustness on Render if storage symlink is missing -->
        <img src="{{ asset('storage/images/about-video-bg.jpg') }}" 
             onerror="this.src='https://images.unsplash.com/photo-1514933651103-005eec06c04b?q=80&w=1974&auto=format&fit=crop';" 
             alt="Restaurant Ambient" 
             class="absolute inset-0 w-full h-full object-cover opacity-60 scale-105 transform transition-transform duration-10000 hover:scale-100">
        <div class="absolute inset-0 bg-gradient-to-t from-slate-900 via-slate-900/40 to-transparent"></div>
        
        <div class="relative z-10 flex flex-col justify-between p-12 h-full w-full">
            <div class="fade-in-up">
                <a href="/" class="inline-block text-3xl font-bold text-white tracking-tight">
                    Midway<span class="text-brand-500">Cafe</span>.
                </a>
            </div>
            
            <div class="mb-12 fade-in-up delay-200">
                <h1 class="text-5xl font-bold text-white mb-6 leading-tight">Savor the <br>Perfect Moment.</h1>
                <p class="text-lg text-slate-300 max-w-md leading-relaxed mb-8">
                    Log in to your account to reserve tables, explore exclusive menus, and manage your culinary journey with us.
                </p>
                
                <div class="flex items-center gap-4 text-sm font-medium text-slate-300">
                    <div class="flex -space-x-3">
                        <img class="w-10 h-10 rounded-full border-2 border-slate-900 object-cover" src="{{ asset('storage/images/chefs-01.jpg') }}" onerror="this.src='https://ui-avatars.com/api/?name=Chef&background=random&color=fff'" alt="User">
                        <img class="w-10 h-10 rounded-full border-2 border-slate-900 object-cover" src="{{ asset('storage/images/chefs-02.jpg') }}" onerror="this.src='https://ui-avatars.com/api/?name=User&background=random&color=fff'" alt="User">
                        <img class="w-10 h-10 rounded-full border-2 border-slate-900 object-cover" src="{{ asset('storage/images/chefs-03.jpg') }}" onerror="this.src='https://ui-avatars.com/api/?name=Food&background=random&color=fff'" alt="User">
                    </div>
                    <p>Join 10,000+ food lovers</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Right Side: Form -->
    <div class="w-full lg:w-1/2 flex items-center justify-center p-8 sm:p-12 lg:p-24 bg-white lg:glass-panel relative z-10">
        <div class="w-full max-w-md fade-in-up delay-100">
            
            <!-- Mobile Brand -->
            <div class="lg:hidden text-center mb-10">
                <a href="/" class="inline-block text-3xl font-bold text-slate-900 tracking-tight">
                    Midway<span class="text-brand-500">Cafe</span>.
                </a>
            </div>

            <div class="mb-10 text-center lg:text-left">
                <h2 class="text-3xl font-bold text-slate-900 mb-3 tracking-tight">Welcome back</h2>
                <p class="text-slate-500">Please enter your details to sign in.</p>
            </div>

            <!-- Errors -->
            <x-jet-validation-errors class="mb-6 p-4 rounded-xl bg-red-50 border border-red-100 text-red-600 text-sm font-medium" />
            
            @if (session('status'))
                <div class="mb-6 p-4 rounded-xl bg-green-50 border border-green-100 text-green-700 text-sm font-medium">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf
                
                <div>
                    <label for="email" class="block text-sm font-semibold text-slate-700 mb-2">Email Address</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                            </svg>
                        </div>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus 
                            class="block w-full pl-10 pr-3 py-3 border border-slate-200 rounded-xl text-slate-900 bg-slate-50 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:bg-white focus:border-transparent transition-all sm:text-sm" placeholder="you@example.com">
                    </div>
                </div>

                <div>
                    <label for="password" class="block text-sm font-semibold text-slate-700 mb-2">Password</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                        </div>
                        <input type="password" id="login-password" name="password" required autocomplete="current-password" 
                            class="block w-full pl-10 pr-10 py-3 border border-slate-200 rounded-xl text-slate-900 bg-slate-50 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:bg-white focus:border-transparent transition-all sm:text-sm" placeholder="••••••••">
                        <button type="button" class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-brand-500 transition-colors" onclick="togglePwd('login-password')">
                            <svg id="eye-o-login-password" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            <svg id="eye-c-login-password" class="h-5 w-5 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                            </svg>
                        </button>
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input id="remember_me" name="remember" type="checkbox" class="h-4 w-4 text-brand-600 focus:ring-brand-500 border-slate-300 rounded cursor-pointer transition-colors">
                        <label for="remember_me" class="ml-2 block text-sm text-slate-600 cursor-pointer">
                            Remember me
                        </label>
                    </div>

                    @if (Route::has('password.request'))
                        <div class="text-sm">
                            <a href="{{ route('password.request') }}" class="font-semibold text-brand-600 hover:text-brand-500 transition-colors">
                                Forgot password?
                            </a>
                        </div>
                    @endif
                </div>

                <div>
                    <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-xl shadow-sm text-sm font-semibold text-white bg-brand-600 hover:bg-brand-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-500 transition-all active:scale-[0.98]">
                        Sign in
                    </button>
                </div>
            </form>

            <div class="mt-8 text-center text-sm">
                <p class="text-slate-500">
                    Don't have an account? 
                    <a href="{{ route('register') }}" class="font-semibold text-brand-600 hover:text-brand-500 transition-colors">Sign up for free</a>
                </p>
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
