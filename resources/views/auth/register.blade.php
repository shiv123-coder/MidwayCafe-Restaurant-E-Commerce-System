<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MidwayCafe - Create Account</title>
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
    </style>
</head>
<body class="min-h-screen flex text-slate-800 antialiased selection:bg-brand-500 selection:text-white">

    <!-- Left Side: Image & Brand -->
    <div class="hidden lg:flex lg:w-1/2 relative bg-slate-900 overflow-hidden">
        <!-- Using a different unsplash image for register robustness -->
        <img src="{{ asset('storage/images/reservation-bg.jpg') }}" 
             onerror="this.src='https://images.unsplash.com/photo-1555396273-367ea4eb4db5?q=80&w=1974&auto=format&fit=crop';" 
             alt="Restaurant Setting" 
             class="absolute inset-0 w-full h-full object-cover opacity-60 scale-105 transform transition-transform duration-10000 hover:scale-100">
        <div class="absolute inset-0 bg-gradient-to-t from-slate-900 via-slate-900/40 to-transparent"></div>
        
        <div class="relative z-10 flex flex-col justify-between p-12 h-full w-full">
            <div class="fade-in-up">
                <a href="/" class="inline-block text-3xl font-bold text-white tracking-tight">
                    Midway<span class="text-brand-500">Cafe</span>.
                </a>
            </div>
            
            <div class="mb-12 fade-in-up delay-200">
                <h1 class="text-5xl font-bold text-white mb-6 leading-tight">Start Your <br>Culinary Journey.</h1>
                <p class="text-lg text-slate-300 max-w-md leading-relaxed mb-8">
                    Create an account to unlock exclusive table reservations, faster checkout, and member-only dining offers.
                </p>
                
                <div class="flex items-center gap-4 text-sm font-medium text-slate-300">
                    <div class="p-3 bg-white/10 backdrop-blur-sm rounded-xl border border-white/20">
                        <svg class="w-6 h-6 text-brand-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    </div>
                    <p>Instant registration. Start exploring in seconds.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Right Side: Form -->
    <div class="w-full lg:w-1/2 flex items-center justify-center p-6 sm:p-12 lg:p-20 bg-white lg:glass-panel relative z-10 overflow-y-auto max-h-screen">
        <div class="w-full max-w-md fade-in-up delay-100 py-8">
            
            <!-- Mobile Brand -->
            <div class="lg:hidden text-center mb-8">
                <a href="/" class="inline-block text-3xl font-bold text-slate-900 tracking-tight">
                    Midway<span class="text-brand-500">Cafe</span>.
                </a>
            </div>

            <div class="mb-8 text-center lg:text-left">
                <h2 class="text-3xl font-bold text-slate-900 mb-2 tracking-tight">Create an account</h2>
                <p class="text-slate-500">Fill in your details to get started.</p>
            </div>

            @if(Session::has('wrong'))
                <div class="mb-6 p-4 rounded-xl bg-red-50 border border-red-100 text-red-600 text-sm font-medium flex justify-between items-center">
                    <span><strong>Oops!</strong> {{ Session::get('wrong') }}</span>
                    <button type="button" onclick="this.parentElement.style.display='none';" class="text-red-400 hover:text-red-600 text-lg leading-none">&times;</button>
                </div>
            @endif
            @if(Session::has('success'))
                <div class="mb-6 p-4 rounded-xl bg-green-50 border border-green-100 text-green-700 text-sm font-medium flex justify-between items-center">
                    <span><strong>Success!</strong> {{ Session::get('success') }}</span>
                    <button type="button" onclick="this.parentElement.style.display='none';" class="text-green-400 hover:text-green-600 text-lg leading-none">&times;</button>
                </div>
            @endif

            <x-jet-validation-errors class="mb-6 p-4 rounded-xl bg-red-50 border border-red-100 text-red-600 text-sm font-medium" />

            <form method="POST" action="{{ route('register/confirm') }}" class="space-y-5">
                @csrf
                
                <div>
                    <label for="name" class="block text-sm font-semibold text-slate-700 mb-1.5">Full Name</label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" 
                        class="block w-full px-4 py-2.5 border border-slate-200 rounded-xl text-slate-900 bg-slate-50 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:bg-white focus:border-transparent transition-all sm:text-sm" placeholder="John Doe">
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label for="email" class="block text-sm font-semibold text-slate-700 mb-1.5">Email</label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required 
                            class="block w-full px-4 py-2.5 border border-slate-200 rounded-xl text-slate-900 bg-slate-50 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:bg-white focus:border-transparent transition-all sm:text-sm" placeholder="you@example.com">
                    </div>
                    <div>
                        <label for="phone" class="block text-sm font-semibold text-slate-700 mb-1.5">Phone Number</label>
                        <input type="number" id="phone" name="phone" value="{{ old('phone') }}" required 
                            class="block w-full px-4 py-2.5 border border-slate-200 rounded-xl text-slate-900 bg-slate-50 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:bg-white focus:border-transparent transition-all sm:text-sm" placeholder="1234567890">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label for="reg-password" class="block text-sm font-semibold text-slate-700 mb-1.5">Password</label>
                        <div class="relative">
                            <input type="password" id="reg-password" name="password" required autocomplete="new-password" 
                                class="block w-full pl-4 pr-10 py-2.5 border border-slate-200 rounded-xl text-slate-900 bg-slate-50 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:bg-white focus:border-transparent transition-all sm:text-sm" placeholder="••••••••">
                            <button type="button" class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-brand-500 transition-colors" onclick="togglePwd('reg-password')">
                                <svg id="eye-o-reg-password" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                <svg id="eye-c-reg-password" class="h-4 w-4 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                </svg>
                            </button>
                        </div>
                    </div>
                    <div>
                        <label for="reg-confirm" class="block text-sm font-semibold text-slate-700 mb-1.5">Confirm</label>
                        <div class="relative">
                            <input type="password" id="reg-confirm" name="password_confirmation" required autocomplete="new-password" 
                                class="block w-full pl-4 pr-10 py-2.5 border border-slate-200 rounded-xl text-slate-900 bg-slate-50 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:bg-white focus:border-transparent transition-all sm:text-sm" placeholder="••••••••">
                            <button type="button" class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-brand-500 transition-colors" onclick="togglePwd('reg-confirm')">
                                <svg id="eye-o-reg-confirm" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                <svg id="eye-c-reg-confirm" class="h-4 w-4 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="pt-2">
                    <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-xl shadow-sm text-sm font-semibold text-white bg-brand-600 hover:bg-brand-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-500 transition-all active:scale-[0.98]">
                        Create Account
                    </button>
                </div>
            </form>

            <div class="mt-8 text-center text-sm">
                <p class="text-slate-500">
                    Already registered? 
                    <a href="{{ route('login') }}" class="font-semibold text-brand-600 hover:text-brand-500 transition-colors">Log in instead</a>
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
