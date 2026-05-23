<!DOCTYPE html>
<html lang="en">
<head>
    @php
        $enablePreloader = app()->environment('production') && !in_array(request()->getHost(), ['localhost', '127.0.0.1', '::1'], true);
    @endphp
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Midway Dine | Fresh Food Delivered Fast</title>
    <meta name="description" content="Order delicious meals online with Midway Dine. Fast delivery, easy checkout, and trusted service.">

    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('storage/images/short.jpg') }}">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/premium-style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/layout.css') }}">
    @if($enablePreloader)
        <link rel="stylesheet" href="{{ asset('assets/css/preloader.css') }}">
    @endif
    @stack('styles')

    <!-- Instant Dark Mode Script to Prevent Flash -->
    <script>
        if (localStorage.getItem('theme') === 'dark') {
            document.documentElement.classList.add('dark-mode');
        }
    </script>
</head>
<body data-app-env="{{ app()->environment() }}">
    @if($enablePreloader)
        @include('partials.preloader')
    @endif

    @php
        if(Auth::check()){
            $cart_amount = DB::table('carts')
                ->where('user_id', Auth::user()->id)
                ->where('product_order', 'no')
                ->count();
        } else {
            $cart_amount = 0;
        }
    @endphp

    <div class="top-strip">
        <div class="container">
            <div class="strip-inner">
                <div class="offer-text">
                    Fresh meals • Fast delivery • Best value combos
                </div>
                <div class="support-links">
                    <a href="{{ url('/trace-my-order') }}">Trace Order</a>
                    <a href="{{ url('/my-order') }}">My Orders</a>
                    <a href="{{ url('/#reservation') }}">Contact Us</a>
                </div>
            </div>
        </div>
    </div>

    <header class="site-header">
        <div class="container">
            <div class="main-navbar">
                <div class="navbar-flex">

                    <a href="{{ url('home') }}" class="brand-box">
                        <img src="{{ asset('storage/images/logo.png') }}" onerror="this.src='https://ui-avatars.com/api/?name=MD&background=ff6b00&color=fff&size=64&rounded=true'" alt="Midway Dine">
                        <div class="brand-meta">
                            <h1>Midway Dine</h1>
                            <p>Taste India, delivered fresh</p>
                        </div>
                    </a>

                    <div class="search-container">
                        <form action="{{ url('/search') }}" method="GET" class="search-wrapper">
                            <i class="fas fa-search search-icon"></i>
                            <input type="text" name="query" placeholder="Search biryani, pizza, combos..." value="{{ request('query') }}" aria-label="Search">
                            <button type="submit" class="search-btn"><i class="fas fa-arrow-right"></i></button>
                        </form>
                    </div>

                    <ul class="nav-links">
                        <li><a href="{{ url('/') }}">Home</a></li>
                        <li><a href="{{ url('/#about') }}">About</a></li>
                        <li><a href="{{ url('/menu') }}">Menu</a></li>
                        <li><a href="{{ url('/#chefs') }}">Chefs</a></li>
                        <li><a href="{{ url('/#reservation') }}" class="nav-cta">Book / Contact</a></li>
                    </ul>

                    <div class="auth-links">
                        <a href="{{ url('/cart') }}" class="cart-link" aria-label="Cart">
                            <i class="fas fa-shopping-cart"></i>
                            <span class="cart-badge">{{ $cart_amount }}</span>
                        </a>

                        <!-- Dark / Light Mode Toggle -->
                        <button id="theme-toggle" class="theme-toggle-btn" onclick="toggleTheme()" aria-label="Toggle dark/light mode" title="Toggle theme">
                            <span id="theme-icon">🌙</span>
                        </button>

                        @auth
                            <div class="d-inline-block">
                                @include('navigation-menu')
                            </div>
                        @else
                            <a href="{{ route('login') }}" class="btn-outline-custom">Login</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="btn-solid-custom">Register</a>
                            @endif
                        @endauth
                    </div>

                </div>
            </div>
        </div>
    </header>

    <main class="page-shell">
        <div class="container">
            @yield('page-content')
        </div>
    </main>

    <section class="trust-strip">
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-3">
                    <div class="trust-card">
                        <img src="{{ asset('storage/images/delivery.png') }}" onerror="this.src='https://ui-avatars.com/api/?name=D&background=fff3eb&color=ff6b00'" alt="Fast Delivery">
                        <h6>Fast Delivery</h6>
                        <p>Quick doorstep delivery for your favourite meals.</p>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="trust-card">
                        <img src="{{ asset('storage/images/cod.png') }}" onerror="this.src='https://ui-avatars.com/api/?name=C&background=fff3eb&color=ff6b00'" alt="Cash on Delivery">
                        <h6>Cash on Delivery</h6>
                        <p>Flexible payment options for a trusted ordering experience.</p>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="trust-card">
                        <img src="{{ asset('storage/images/order.png') }}" onerror="this.src='https://ui-avatars.com/api/?name=O&background=fff3eb&color=ff6b00'" alt="Easy Ordering">
                        <h6>Easy Ordering</h6>
                        <p>Simple steps, smooth checkout, and instant order updates.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer class="site-footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 mb-4">
                    <div class="footer-brand">
                        <img src="{{ asset('storage/images/logo.png') }}" onerror="this.src='https://ui-avatars.com/api/?name=MD&background=111827&color=fff&size=64&rounded=true'" alt="Midway Dine">
                        <h5>Midway Dine</h5>
                        <p>
                            A clean, modern Indian-style food ordering experience with better browsing,
                            faster ordering, and a more trusted checkout flow.
                        </p>
                        <ul class="social-icons">
                            <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                            <li><a href="#"><i class="fa fa-instagram"></i></a></li>
                            <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                            <li><a href="#"><i class="fa fa-linkedin"></i></a></li>
                        </ul>
                    </div>
                </div>

                <div class="col-lg-2 col-md-4 mb-4">
                    <div class="footer-links">
                        <h6>Quick Links</h6>
                        <ul>
                            <li><a href="{{ url('/') }}">Home</a></li>
                            <li><a href="{{ url('/menu') }}">Menu</a></li>
                            <li><a href="{{ url('/cart') }}">Cart</a></li>
                            <li><a href="{{ url('/my-order') }}">Orders</a></li>
                        </ul>
                    </div>
                </div>

                <div class="col-lg-3 col-md-4 mb-4">
                    <div class="footer-links">
                        <h6>Customer Support</h6>
                        <ul>
                            <li><a href="{{ url('/trace-my-order') }}">Trace Order</a></li>
                            <li><a href="{{ url('/#reservation') }}">Contact Us</a></li>
                            <li><a href="#">Delivery Info</a></li>
                            <li><a href="#">Help Center</a></li>
                        </ul>
                    </div>
                </div>

                <div class="col-lg-3 col-md-4 mb-4">
                    <div class="footer-links">
                        <h6>Why Choose Us</h6>
                        <ul>
                            <li><a href="#">Fresh Food Quality</a></li>
                            <li><a href="#">Secure Checkout</a></li>
                            <li><a href="#">Quick Delivery</a></li>
                            <li><a href="#">Trusted Ordering</a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="footer-bottom">
                <p>© {{ date('Y') }} Midway Dine. Designed for a modern Indian food ordering experience.</p>
            </div>
        </div>
    </footer>

    <script src="{{ asset('assets/js/jquery-2.1.0.min.js') }}"></script>
    <script src="{{ asset('assets/js/popper.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
    @if($enablePreloader)
        <script src="{{ asset('assets/js/preloader.js') }}"></script>
    @endif

    <script>
        // Dark / Light Mode with localStorage persistence
        (function () {
            var saved = localStorage.getItem('theme');
            if (saved === 'dark') {
                document.documentElement.classList.add('dark-mode');
            }
        })();

        function toggleTheme() {
            var isDark = document.documentElement.classList.toggle('dark-mode');
            localStorage.setItem('theme', isDark ? 'dark' : 'light');
            document.getElementById('theme-icon').textContent = isDark ? '☀️' : '🌙';
        }

        // Restore icon on load
        document.addEventListener('DOMContentLoaded', function () {
            var isDark = document.documentElement.classList.contains('dark-mode');
            var icon = document.getElementById('theme-icon');
            if (icon) icon.textContent = isDark ? '☀️' : '🌙';
        });
    </script>
</body>
</html>
