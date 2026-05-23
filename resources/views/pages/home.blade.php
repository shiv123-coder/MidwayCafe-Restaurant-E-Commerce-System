@extends('layouts.app', ['title' => 'Home'])
@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/home.css') }}">
@endpush

@section('page-content')

@php
    $heroBanner = $banners->first();
@endphp

<div class="home-hero-wrap">
    <div class="hero-card premium-hero-bg">
        <div class="hero-overlay"></div>
        <div class="row no-gutters align-items-stretch position-relative" style="z-index: 2;">
            <div class="col-lg-5">
                <div class="hero-left glassmorphism-card">
                    <div class="hero-badge dark-badge">
                        <i class="fas fa-star text-warning"></i>
                        Loved by foodies for fresh taste & quick service
                    </div>

                    <h1 class="hero-title text-white">
                        Craving something
                        <span class="text-primary-accent">delicious</span>
                        today?
                    </h1>

                    <p class="hero-subtitle text-light-muted">
                        Discover rich flavours, quick bites, filling combos, sweet treats, and
                        comforting meals — all crafted for a modern Indian food experience that feels
                        fresh, premium, and easy to order.
                    </p>

                    <div class="hero-cta-group">
                        <a href="{{ route('menu') }}" class="hero-btn-primary shadow-glow">
                            Explore Full Menu
                        </a>
                        <a href="#reservation" class="hero-btn-secondary glass-btn">
                            Reserve a Table
                        </a>
                    </div>

                    <div class="hero-trust-row">
                        <div class="hero-trust-pill glass-pill"><i class="fas fa-motorcycle"></i> Fast Delivery</div>
                        <div class="hero-trust-pill glass-pill"><i class="fas fa-leaf"></i> Fresh Ingredients</div>
                        <div class="hero-trust-pill glass-pill"><i class="fas fa-mobile-alt"></i> Easy Ordering</div>
                    </div>
                </div>
            </div>

            <div class="col-lg-7">
                <div class="hero-slider-wrap">
                    <div class="main-banner header-text">
                        <div class="Modern-Slider rounded-modern-slider">
                            @foreach($banners as $banner)
                                <div class="item">
                                    <div class="img-fill">
                                        <img src="{{ Storage::url($banner->banner) }}" onerror="this.src='https://images.unsplash.com/photo-1504674900247-0877df9cc836?q=80&w=2070&auto=format&fit=crop'" alt="Banner">
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="hero-floating-box glass-float">
                        <h6 class="text-white">Today’s Popular Picks</h6>
                        <p class="text-light-muted">
                            Browse chef-crafted dishes, combo meals, and best-rated specials curated
                            for breakfast, lunch, and dinner.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<section class="section-block" id="about">
    <div class="container">
        @foreach($about_us as $a_us)
            <div class="row align-items-center">
                <div class="col-lg-6 mb-4 mb-lg-0">
                    <div class="about-card">
                        <div class="custom-heading">
                            <span class="eyebrow">About Us</span>
                            <h2>{{ $a_us->title }}</h2>
                            <p>{{ $a_us->description }}</p>
                        </div>

                        <div class="row about-gallery">
                            <div class="col-4">
                                <img src="{{ asset('storage/' . $a_us->image1) }}" onerror="this.src='https://images.unsplash.com/photo-1414235077428-338989a2e8c0?q=80&w=2070&auto=format&fit=crop'" alt="About Image 1">
                            </div>
                            <div class="col-4">
                                <img src="{{ asset('storage/' . $a_us->image2) }}" onerror="this.src='https://images.unsplash.com/photo-1555396273-367ea4eb4db5?q=80&w=2070&auto=format&fit=crop'" alt="About Image 2">
                            </div>
                            <div class="col-4">
                                <img src="{{ asset('storage/' . $a_us->image3) }}" onerror="this.src='https://images.unsplash.com/photo-1504674900247-0877df9cc836?q=80&w=2070&auto=format&fit=crop'" alt="About Image 3">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="video-thumb-wrap">
                        <img src="{{ asset('storage/images/about-video-bg.jpg') }}" onerror="this.src='https://images.unsplash.com/photo-1514933651103-005eec06c04b?q=80&w=1974&auto=format&fit=crop'" alt="Video Thumbnail">
                        <a rel="nofollow" href="{{ $a_us->youtube_link }}" target="_blank" class="play-btn-modern">
                            <i class="fa fa-play"></i>
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</section>

<section class="section-block" id="offers">
    <div class="container">
        <div class="text-center custom-heading">
            <span class="eyebrow">Weekly Specials</span>
            <h2>Best Meal Offers for Every Part of the Day</h2>
            <p>
                Start your morning right, enjoy a satisfying lunch, or end your day with
                rich dinner flavours. Explore handpicked weekly specials across all meal categories.
            </p>
        </div>

        <div class="offer-tabs-shell">
            <div id="tabs">
                <div class="heading-tabs">
                    <ul class="offer-tab-list">
                        <li>
                            <a href="#tabs-1">
                                <i class="fas fa-coffee" style="font-size: 20px;"></i>
                                Breakfast
                            </a>
                        </li>
                        <li>
                            <a href="#tabs-2">
                                <i class="fas fa-hamburger" style="font-size: 20px;"></i>
                                Lunch
                            </a>
                        </li>
                        <li>
                            <a href="#tabs-3">
                                <i class="fas fa-utensils" style="font-size: 20px;"></i>
                                Dinner
                            </a>
                        </li>
                    </ul>
                </div>

                <section class="tabs-content">
                    <article id="tabs-1">
                        <div class="offer-grid">
                            @foreach($breakfast as $item)
                                @php
                                    $rating = number_format($item->avg_rating ?? 0, 1);
                                    $whole = floor($rating);
                                    $fraction = $rating - $whole;
                                @endphp

                                <div class="offer-item-card">
                                    <div class="offer-item-image">
                                        <img src="{{ asset('storage/' . $item->image) }}" onerror="this.src='https://images.unsplash.com/photo-1546069901-ba9599a7e63c?q=80&w=2000&auto=format&fit=crop'" alt="{{ $item->name }}">
                                    </div>
                                    <div class="offer-item-content">
                                        <h4>{{ $item->name }}</h4>
                                        <p>{{ $item->description }}</p>
                                        <div class="offer-price">₹{{ $item->price }}</div>

                                        <div class="rating-line">
                                            @for($i = 1; $i <= $whole; $i++)
                                                <i class="fa fa-star"></i>
                                            @endfor

                                            @if($fraction != 0)
                                                <i class="fa fa-star-half"></i>
                                            @endif

                                            <span class="rating-text">({{ $rating }})</span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </article>

                    <article id="tabs-2">
                        <div class="offer-grid">
                            @foreach($lunch as $item)
                                @php
                                    $rating = number_format($item->avg_rating ?? 0, 1);
                                    $whole = floor($rating);
                                    $fraction = $rating - $whole;
                                @endphp

                                <div class="offer-item-card">
                                    <div class="offer-item-image">
                                        <img src="{{ asset('storage/' . $item->image) }}" onerror="this.src='https://images.unsplash.com/photo-1546069901-ba9599a7e63c?q=80&w=2000&auto=format&fit=crop'" alt="{{ $item->name }}">
                                    </div>
                                    <div class="offer-item-content">
                                        <h4>{{ $item->name }}</h4>
                                        <p>{{ $item->description }}</p>
                                        <div class="offer-price">₹{{ $item->price }}</div>

                                        <div class="rating-line">
                                            @for($i = 1; $i <= $whole; $i++)
                                                <i class="fa fa-star"></i>
                                            @endfor

                                            @if($fraction != 0)
                                                <i class="fa fa-star-half"></i>
                                            @endif

                                            <span class="rating-text">({{ $rating }})</span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </article>

                    <article id="tabs-3">
                        <div class="offer-grid">
                            @foreach($dinner as $item)
                                @php
                                    $rating = number_format($item->avg_rating ?? 0, 1);
                                    $whole = floor($rating);
                                    $fraction = $rating - $whole;
                                @endphp

                                <div class="offer-item-card">
                                    <div class="offer-item-image">
                                        <img src="{{ asset('storage/' . $item->image) }}" onerror="this.src='https://images.unsplash.com/photo-1546069901-ba9599a7e63c?q=80&w=2000&auto=format&fit=crop'" alt="{{ $item->name }}">
                                    </div>
                                    <div class="offer-item-content">
                                        <h4>{{ $item->name }}</h4>
                                        <p>{{ $item->description }}</p>
                                        <div class="offer-price">₹{{ $item->price }}</div>

                                        <div class="rating-line">
                                            @for($i = 1; $i <= $whole; $i++)
                                                <i class="fa fa-star"></i>
                                            @endfor

                                            @if($fraction != 0)
                                                <i class="fa fa-star-half"></i>
                                            @endif

                                            <span class="rating-text">({{ $rating }})</span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </article>
                </section>

                <div class="browse-all-wrap">
                    <a href="{{ route('menu') }}" class="browse-all-btn">
                        Browse Full Menu
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section-block menu-showcase-section" id="menu">
    <div class="container">
        <div class="custom-heading text-center">
            <span class="eyebrow">Featured Menu</span>
            <h2>Top Picks Loved by Our Customers</h2>
            <p>
                Discover a rotating showcase of best-rated dishes, signature meals, and
                customer favourites that bring flavour, comfort, and value together.
            </p>
        </div>

        <div class="menu-item-carousel">
            <div class="owl-menu-item owl-carousel">
                @foreach($menu as $product)
                    @php
                        $rating = number_format($product->avg_rating ?? 0, 1);
                        $whole = floor($rating);
                        $fraction = $rating - $whole;
                    @endphp

                    <div class="item p-2">
                        <div class="featured-product-card">
                            <div class="featured-product-image" style="background-image:url('{{ asset('storage/' . $product->image) }}');">
                                <div class="featured-badge">Featured Dish</div>

                                @if($product->available != "Stock")
                                    <div class="stock-badge">Out of Stock</div>
                                @endif
                            </div>

                            <div class="featured-product-body">
                                <h3 class="featured-product-title">{{ $product->name }}</h3>
                                <p class="featured-product-desc">{{ $product->description }}</p>

                                <div class="rating-line">
                                    @for($i = 1; $i <= $whole; $i++)
                                        <i class="fa fa-star"></i>
                                    @endfor

                                    @if($fraction != 0)
                                        <i class="fa fa-star-half"></i>
                                    @endif

                                    <span class="rating-text">({{ $rating }})</span>
                                </div>

                                <div class="featured-product-bottom mt-3">
                                    <div class="featured-price">₹{{ $product->price }}</div>
                                </div>

                                <a href="/rate/{{ $product->id }}" class="rate-link">Rate this dish</a>

                                <div class="featured-actions">
                                    <form method="post" action="{{ route('cart.store', $product->id) }}">
                                        @csrf
                                        <label class="d-block mb-2 font-weight-bold text-muted">Quantity</label>
                                        <input type="number" name="number" class="qty-box" value="1" min="1">

                                        @if($product->available == "Stock")
                                            <button type="submit" class="cart-btn-modern">
                                                Add to Cart
                                            </button>
                                        @else
                                            <button type="submit" class="cart-btn-modern" disabled>
                                                Currently Unavailable
                                            </button>
                                        @endif
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

<section class="section-block" id="chefs">
    <div class="container">
        <div class="text-center custom-heading">
            <span class="eyebrow">Our Chefs</span>
            <h2>Passionate Experts Behind Every Great Plate</h2>
            <p>
                Meet the people who bring flavour, care, and consistency to every dish
                with premium ingredients and a love for food.
            </p>
        </div>

        <div class="row">
            @foreach($chefs as $chef)
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="chef-card">
                        <div class="chef-thumb">
                            <img src="{{ asset('storage/' . $chef->image) }}" onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($chef->name) }}&background=111827&color=fff&size=512'" alt="{{ $chef->name }}">

                            <div class="chef-overlay">
                                <ul class="chef-socials">
                                    <li>
                                        <a href="{{ $chef->facebook_link }}" target="_blank">
                                            <i class="fa fa-facebook"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ $chef->twitter_link }}" target="_blank">
                                            <i class="fa fa-twitter"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ $chef->instragram_link }}" target="_blank">
                                            <i class="fa fa-instagram"></i>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="chef-body">
                            <h4>{{ $chef->name }}</h4>
                            <span>{{ $chef->job_title }}</span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<section class="section-block" id="reservation">
    <div class="container">
        <div class="row">
            <div class="col-lg-5 mb-4 mb-lg-0">
                <div class="contact-side-card">
                    <div class="custom-heading">
                        <span class="eyebrow">Contact & Reservation</span>
                        <h2>Reserve Your Table or Reach Out Anytime</h2>
                        <p>
                            Whether you want to book a dining experience, ask a quick question,
                            or connect with our team, we are always here to help.
                        </p>
                    </div>

                    <div class="contact-highlight-box">
                        <p class="mb-0">
                            Enjoy a warm and modern dining experience with fresh meals,
                            smooth reservations, and responsive support from our team.
                        </p>
                    </div>

                    <div class="row mt-4">
                        <div class="col-md-6 mb-3">
                            <div class="contact-info-card">
                                <i class="fa fa-phone"></i>
                                <h4>Phone Numbers</h4>
                                <p class="mb-1"><a href="tel:+919876543210">+91 9876543210</a></p>
                                <p class="mb-0"><a href="tel:+919123456789">+91 9123456789</a></p>
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <div class="contact-info-card">
                                <i class="fa fa-envelope"></i>
                                <h4>Email Us</h4>
                                <p class="mb-1">
                                    <a href="mailto:contact@midwaydine.com">contact@midwaydine.com</a>
                                </p>
                                <p class="mb-0">
                                    <a href="mailto:support@midwaydine.com">support@midwaydine.com</a>
                                </p>
                            </div>
                        </div>
                    </div>

                    <p class="mini-note">
                        You can reserve for breakfast, lunch, or dinner and include any special request in the message box.
                    </p>
                </div>
            </div>

            <div class="col-lg-7">
                <div class="reservation-form-card">
                    <h4>Book Your Reservation</h4>

                    <form id="contact" action="/reserve/confirm" method="post">
                        @csrf

                        <div class="row">
                            <div class="col-lg-6 col-sm-12 mb-3">
                                <input name="name" type="text" id="name" placeholder="Your Name*" required>
                            </div>

                            <div class="col-lg-6 col-sm-12 mb-3">
                                <input name="email" type="email" id="email" placeholder="Your Email Address*" required>
                            </div>

                            <div class="col-lg-6 col-sm-12 mb-3">
                                <input name="phone" type="text" id="phone" placeholder="Phone Number*" required>
                            </div>

                            <div class="col-lg-6 col-sm-12 mb-3">
                                <select name="no_guest" id="number-guests" required>
                                    <option value="">Number of Guests</option>
                                    <option value="1">1 Guest</option>
                                    <option value="2">2 Guests</option>
                                    <option value="3">3 Guests</option>
                                    <option value="4">4 Guests</option>
                                    <option value="5">5 Guests</option>
                                    <option value="6">6 Guests</option>
                                    <option value="7">7 Guests</option>
                                    <option value="8">8 Guests</option>
                                    <option value="9">9 Guests</option>
                                    <option value="10">10 Guests</option>
                                    <option value="11">11 Guests</option>
                                    <option value="12">12 Guests</option>
                                </select>
                            </div>

                            <div class="col-lg-6 col-sm-12 mb-3">
                                <input name="date" id="date" type="text" placeholder="Reservation Date (dd/mm/yyyy)">
                            </div>

                            <div class="col-lg-6 col-sm-12 mb-3">
                                <select name="time" id="time" required>
                                    <option value="">Select Time Slot</option>
                                    <option value="Breakfast">Breakfast</option>
                                    <option value="Lunch">Lunch</option>
                                    <option value="Dinner">Dinner</option>
                                </select>
                            </div>

                            <div class="col-lg-12 mb-3">
                                <textarea name="message" rows="6" id="message" placeholder="Message / Special Request" required></textarea>
                            </div>

                            <div class="col-lg-12">
                                <button type="submit" id="form-submit" class="reservation-submit-btn">
                                    Confirm Reservation
                                </button>
                            </div>
                        </div>
                    </form>

                    <p class="mini-note">
                        Please make sure your phone number and email are correct so we can confirm your booking smoothly.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
