@extends('layouts.app', ['title' => 'Search Results'])

@section('page-content')

<style>
    .search-page-section{
        padding: 40px 0 60px;
    }

    .search-header{
        margin-bottom: 34px;
        border-bottom: 1px solid #e5e7eb;
        padding-bottom: 20px;
    }

    .search-header h1{
        font-size: 32px;
        font-weight: 800;
        color: #1f2937;
    }

    .search-header span{
        color: #ff6b00;
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

    .qty-row{
        display: flex;
        align-items: center;
        gap: 10px;
        margin-top: auto;
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
        flex: 1;
    }

    .empty-state-box{
        background: #fff;
        border-radius: 24px;
        box-shadow: 0 18px 40px rgba(0,0,0,0.06);
        padding: 60px 30px;
        text-align: center;
    }

    /* Dark Mode */
    .dark-mode .product-card-modern, .dark-mode .empty-state-box {
        background: #1e293b;
    }
    .dark-mode .product-title, .dark-mode .search-header h1 {
        color: #f8fafc;
    }
    .dark-mode .product-description {
        color: #94a3b8;
    }
</style>

<section class="search-page-section">
    <div class="container">

        <div class="search-header">
            <h1>Search results for <span>"{{ $query }}"</span></h1>
            <p class="text-muted">{{ $products->count() }} items found</p>
        </div>

        @if($products->isNotEmpty())
        <div class="product-grid">
            @foreach($products as $product)
            <div class="product-card-modern">
                <div class="product-image-wrap">
                    <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}">
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
                <i class="fa fa-search mb-4" style="font-size: 48px; color: #cbd5e1;"></i>
                <h3>No items found for "{{ $query }}"</h3>
                <p class="text-muted">Try searching for something else or browse our full menu.</p>
                <a href="{{ url('/menu') }}" class="btn-solid-custom mt-4 d-inline-block" style="text-decoration:none;">Browse Menu</a>
            </div>
        @endif

    </div>
</section>

@endsection
