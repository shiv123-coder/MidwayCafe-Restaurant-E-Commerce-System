@extends('layouts.app', ['title' => 'Menu'])

@section('page-content')

<style>
    .menu-page-section{
        padding: 20px 0 60px;
    }

    .menu-hero{
        background: linear-gradient(135deg, #fff4ec 0%, #fffaf6 50%, #eefaf3 100%);
        border-radius: 28px;
        padding: 50px 36px;
        box-shadow: 0 20px 45px rgba(0,0,0,0.08);
        margin-bottom: 36px;
        position: relative;
        overflow: hidden;
    }

    .menu-hero::before{
        content: "";
        position: absolute;
        width: 240px;
        height: 240px;
        border-radius: 50%;
        background: rgba(255,107,0,0.08);
        top: -60px;
        right: -60px;
    }

    .menu-hero::after{
        content: "";
        position: absolute;
        width: 180px;
        height: 180px;
        border-radius: 50%;
        background: rgba(17,139,80,0.08);
        bottom: -50px;
        left: -50px;
    }

    .menu-hero-content{
        position: relative;
        z-index: 2;
    }

    .menu-badge{
        display: inline-block;
        background: #fff;
        color: #ff6b00;
        padding: 9px 16px;
        border-radius: 999px;
        font-size: 13px;
        font-weight: 700;
        box-shadow: 0 8px 18px rgba(0,0,0,0.06);
        margin-bottom: 16px;
    }

    .menu-title{
        font-size: 42px;
        line-height: 1.15;
        font-weight: 800;
        color: #1f2937;
        margin-bottom: 12px;
    }

    .menu-title span{
        color: #ff6b00;
    }

    .menu-subtitle{
        max-width: 760px;
        font-size: 15px;
        line-height: 1.8;
        color: #6b7280;
        margin-bottom: 0;
    }

    .menu-top-strip{
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 18px;
        margin-bottom: 34px;
    }

    .menu-feature-box{
        background: #fff;
        border-radius: 20px;
        padding: 20px 18px;
        box-shadow: 0 14px 30px rgba(0,0,0,0.06);
        text-align: center;
        transition: 0.25s ease;
    }

    .menu-feature-box:hover{
        transform: translateY(-4px);
    }

    .menu-feature-box i{
        width: 52px;
        height: 52px;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: #fff3eb;
        color: #ff6b00;
        font-size: 22px;
        margin-bottom: 12px;
    }

    .menu-feature-box h4{
        font-size: 18px;
        font-weight: 800;
        color: #1f2937;
        margin-bottom: 6px;
    }

    .menu-feature-box p{
        margin: 0;
        font-size: 13px;
        color: #6b7280;
        line-height: 1.6;
    }

    .product-grid{
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 26px;
    }

    .product-card-modern{
        background: #fff;
        border-radius: 24px;
        overflow: hidden;
        box-shadow: 0 18px 40px rgba(0,0,0,0.06);
        transition: 0.3s ease;
        display: flex;
        flex-direction: column;
        height: 100%;
    }

    .product-card-modern:hover{
        transform: translateY(-6px);
        box-shadow: 0 24px 46px rgba(0,0,0,0.10);
    }

    .product-image-wrap{
        position: relative;
        height: 250px;
        overflow: hidden;
    }

    .product-image-wrap img{
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: 0.35s ease;
    }

    .product-card-modern:hover .product-image-wrap img{
        transform: scale(1.06);
    }

    .product-badge{
        position: absolute;
        top: 16px;
        left: 16px;
        background: rgba(255,255,255,0.95);
        color: #ff6b00;
        padding: 8px 14px;
        border-radius: 999px;
        font-size: 12px;
        font-weight: 800;
        box-shadow: 0 10px 22px rgba(0,0,0,0.10);
    }

    .stock-badge{
        position: absolute;
        top: 16px;
        right: 16px;
        padding: 8px 12px;
        border-radius: 999px;
        font-size: 12px;
        font-weight: 700;
        color: #fff;
    }

    .stock-in{ background: #118b50; }
    .stock-out{ background: #dc2626; }

    .product-body{
        padding: 22px;
        display: flex;
        flex-direction: column;
        flex: 1;
    }

    .product-title{
        font-size: 22px;
        font-weight: 800;
        color: #1f2937;
        margin-bottom: 8px;
    }

    .product-price{
        font-size: 24px;
        font-weight: 800;
        color: #ff6b00;
        margin-bottom: 10px;
    }

    .product-description{
        font-size: 14px;
        color: #6b7280;
        line-height: 1.8;
        margin-bottom: 16px;
        min-height: 72px;
    }

    .product-rating-wrap{
        margin-bottom: 14px;
        display: flex;
        align-items: center;
        gap: 4px;
        color: #f59e0b;
    }

    .rating-text{
        margin-left: 6px;
        color: #6b7280;
        font-size: 13px;
        font-weight: 700;
    }

    .quantity-label{
        display: block;
        font-size: 13px;
        font-weight: 700;
        color: #4b5563;
        margin-bottom: 8px;
    }

    .product-actions{
        margin-top: auto;
    }

    .qty-row{
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .qty-input-modern{
        width: 78px;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        padding: 10px 12px;
        text-align: center;
        font-weight: 600;
    }

    .add-cart-btn-modern{
        border: none;
        border-radius: 12px;
        padding: 12px 18px;
        background: linear-gradient(135deg, #ff6b00, #ff8743);
        color: #fff;
        font-weight: 800;
        cursor: pointer;
    }

    .empty-state-box{
        background: #fff;
        border-radius: 24px;
        box-shadow: 0 18px 40px rgba(0,0,0,0.06);
        padding: 50px 30px;
        text-align: center;
    }

    /* ================= DARK MODE ================= */

    .dark .menu-hero{
        background: linear-gradient(135deg, #1f1f1f, #141414, #101010);
    }

    .dark .menu-title,
    .dark .product-title,
    .dark .menu-feature-box h4,
    .dark .empty-state-box h3{
        color: #f3f4f6;
    }

    .dark .menu-subtitle,
    .dark .menu-feature-box p,
    .dark .product-description,
    .dark .rating-text,
    .dark .empty-state-box p{
        color: #a1a1aa;
    }

    .dark .menu-feature-box,
    .dark .product-card-modern,
    .dark .empty-state-box{
        background: #1e1e1e;
    }

    .dark .product-price{
        color: #ff9a4d;
    }

    .dark .qty-input-modern{
        background: #111;
        color: #fff;
        border: 1px solid #333;
    }

    .dark .menu-feature-box i{
        background: #2a2a2a;
    }
</style>

<section class="menu-page-section">
    <div class="container">

        <div class="menu-hero">
            <div class="menu-hero-content">
                <div class="menu-badge">Explore Fresh Meals & Bestsellers</div>

                <h1 class="menu-title">
                    Discover our <span>full menu</span>
                </h1>

                <p class="menu-subtitle">
                    Browse premium dishes and favourites crafted for a modern food experience.
                </p>
            </div>
        </div>

        @if($products->isNotEmpty())
        <div class="product-grid">
            @foreach($products as $product)
            <div class="product-card-modern">

                <div class="product-image-wrap">
                    <img src="{{ Storage::url($product->image) }}" alt="">
                </div>

                <div class="product-body">
                    <h2 class="product-title">{{ $product->name }}</h2>
                    <div class="product-price">₹{{ $product->price }}</div>

                    <p class="product-description">{{ $product->description }}</p>

                    <form method="post" action="{{ route('cart.store', $product) }}">
                        @csrf

                        <div class="qty-row">
                            <input type="number" name="number" class="qty-input-modern" value="1" min="1">

                            <button class="add-cart-btn-modern" type="submit">
                                Add to Cart
                            </button>
                        </div>
                    </form>
                </div>

            </div>
            @endforeach
        </div>
        @else
            <div class="empty-state-box">
                <h3>No items available</h3>
                <p>Please check back later.</p>
            </div>
        @endif

    </div>
</section>

@endsection
