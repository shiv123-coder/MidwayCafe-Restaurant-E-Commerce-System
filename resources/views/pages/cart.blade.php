@extends('layouts.app', ['title' => 'My Cart'])

@section('page-content')

@php
    $displayTotal = $total_price;
    $displayWithoutDiscount = $without_discount_price;

    if($total_price != 0){
        $displayTotal = $total_price + $total_extra_charge;
        $displayWithoutDiscount = $without_discount_price + $total_extra_charge;
    }

    Session::put('total', $total_price);
@endphp

<style>
    .cart-page-section{
        padding: 20px 0 60px;
    }

    .cart-hero{
        background: linear-gradient(135deg, #fff4ec 0%, #fffaf6 50%, #eefaf3 100%);
        border-radius: 28px;
        padding: 42px 34px;
        box-shadow: 0 20px 45px rgba(0,0,0,0.08);
        margin-bottom: 28px;
        position: relative;
        overflow: hidden;
    }

    .cart-hero::before{
        content: "";
        position: absolute;
        width: 220px;
        height: 220px;
        border-radius: 50%;
        background: rgba(255,107,0,0.08);
        top: -60px;
        right: -60px;
    }

    .cart-hero::after{
        content: "";
        position: absolute;
        width: 170px;
        height: 170px;
        border-radius: 50%;
        background: rgba(17,139,80,0.08);
        bottom: -40px;
        left: -40px;
    }

    .cart-hero-content{
        position: relative;
        z-index: 2;
    }

    .cart-badge{
        display: inline-block;
        background: #fff;
        color: #ff6b00;
        padding: 9px 16px;
        border-radius: 999px;
        font-size: 13px;
        font-weight: 700;
        box-shadow: 0 8px 18px rgba(0,0,0,0.06);
        margin-bottom: 14px;
    }

    .cart-title{
        font-size: 40px;
        font-weight: 800;
        color: #1f2937;
        margin-bottom: 10px;
        line-height: 1.15;
    }

    .cart-title span{
        color: #ff6b00;
    }

    .cart-subtitle{
        margin: 0;
        max-width: 760px;
        color: #6b7280;
        line-height: 1.8;
        font-size: 15px;
    }

    .cart-alert{
        border-radius: 18px;
        padding: 16px 18px;
        margin-bottom: 18px;
        font-weight: 600;
        box-shadow: 0 12px 24px rgba(0,0,0,0.05);
        position: relative;
    }

    .cart-alert-danger{
        background: #fff1f2;
        color: #be123c;
        border: 1px solid #fecdd3;
    }

    .cart-alert-success{
        background: #ecfdf3;
        color: #166534;
        border: 1px solid #bbf7d0;
    }

    .cart-close{
        position: absolute;
        right: 16px;
        top: 12px;
        font-size: 22px;
        font-weight: 700;
        cursor: pointer;
        line-height: 1;
    }

    .cart-main-grid{
        display: grid;
        grid-template-columns: 1.6fr 0.9fr;
        gap: 26px;
        align-items: start;
    }

    .cart-items-card,
    .cart-summary-card,
    .coupon-card{
        background: #fff;
        border-radius: 24px;
        box-shadow: 0 18px 40px rgba(0,0,0,0.06);
    }

    .cart-items-card{
        padding: 24px;
    }

    .cart-section-title{
        font-size: 24px;
        font-weight: 800;
        color: #1f2937;
        margin-bottom: 6px;
    }

    .cart-section-subtitle{
        color: #6b7280;
        font-size: 14px;
        line-height: 1.7;
        margin-bottom: 22px;
    }

    .cart-item-row{
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 18px;
        padding: 20px;
        border: 1px solid #f1f1f1;
        border-radius: 20px;
        margin-bottom: 16px;
        transition: 0.25s ease;
    }

    .cart-item-row:hover{
        box-shadow: 0 14px 26px rgba(0,0,0,0.05);
    }

    .cart-item-left{
        display: flex;
        align-items: center;
        gap: 16px;
        min-width: 0;
        flex: 1;
    }

    .cart-item-icon{
        width: 68px;
        height: 68px;
        border-radius: 18px;
        background: linear-gradient(135deg, #fff3eb, #fffaf6);
        color: #ff6b00;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 28px;
        flex-shrink: 0;
    }

    .cart-item-details{
        min-width: 0;
    }

    .cart-item-name{
        font-size: 18px;
        font-weight: 800;
        color: #1f2937;
        margin-bottom: 4px;
        line-height: 1.3;
    }

    .cart-item-meta{
        color: #6b7280;
        font-size: 13px;
        line-height: 1.6;
    }

    .cart-item-right{
        display: flex;
        align-items: center;
        gap: 18px;
        flex-wrap: wrap;
        justify-content: flex-end;
    }

    .cart-price-chip,
    .cart-qty-chip,
    .cart-subtotal-chip{
        min-width: 92px;
        text-align: center;
        border-radius: 14px;
        padding: 10px 12px;
        background: #f9fafb;
    }

    .cart-price-chip span,
    .cart-qty-chip span,
    .cart-subtotal-chip span{
        display: block;
        font-size: 11px;
        font-weight: 700;
        color: #6b7280;
        text-transform: uppercase;
        letter-spacing: 0.03em;
        margin-bottom: 3px;
    }

    .cart-price-chip strong,
    .cart-qty-chip strong,
    .cart-subtotal-chip strong{
        font-size: 15px;
        font-weight: 800;
        color: #1f2937;
    }

    .cart-subtotal-chip{
        background: #fff3eb;
    }

    .cart-subtotal-chip strong{
        color: #ff6b00;
    }

    .remove-btn-modern{
        border: none;
        width: 46px;
        height: 46px;
        border-radius: 14px;
        background: #fff1f2;
        color: #dc2626;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
        cursor: pointer;
        transition: 0.25s ease;
    }

    .remove-btn-modern:hover{
        background: #ffe4e6;
        transform: translateY(-2px);
    }

    .coupon-card{
        padding: 22px;
        margin-bottom: 22px;
    }

    .coupon-title{
        font-size: 20px;
        font-weight: 800;
        color: #1f2937;
        margin-bottom: 8px;
    }

    .coupon-subtitle{
        font-size: 14px;
        color: #6b7280;
        line-height: 1.7;
        margin-bottom: 16px;
    }

    .coupon-form{
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
    }

    .coupon-input{
        flex: 1;
        min-width: 180px;
        border: 1px solid #e5e7eb;
        border-radius: 14px;
        padding: 14px 16px;
        outline: none;
        font-size: 14px;
    }

    .coupon-input:focus{
        border-color: #ffb98f;
        box-shadow: 0 0 0 3px rgba(255,107,0,0.10);
    }

    .coupon-btn{
        border: none;
        border-radius: 14px;
        padding: 14px 18px;
        background: #111827;
        color: #fff;
        font-weight: 800;
        cursor: pointer;
        transition: 0.25s ease;
    }

    .coupon-btn:disabled{
        background: #9ca3af;
        cursor: not-allowed;
    }

    .cart-summary-card{
        padding: 24px;
        position: sticky;
        top: 110px;
    }

    .summary-title{
        font-size: 24px;
        font-weight: 800;
        color: #1f2937;
        margin-bottom: 16px;
    }

    .summary-line{
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 14px;
        padding: 12px 0;
        border-bottom: 1px solid #f1f1f1;
    }

    .summary-line:last-of-type{
        border-bottom: none;
    }

    .summary-label{
        color: #6b7280;
        font-size: 14px;
        font-weight: 600;
    }

    .summary-value{
        color: #1f2937;
        font-size: 15px;
        font-weight: 800;
    }

    .summary-value.discount{
        color: #16a34a;
    }

    .summary-total-box{
        margin-top: 18px;
        padding: 18px;
        border-radius: 18px;
        background: linear-gradient(135deg, #fff3eb, #fff9f5);
        border: 1px solid #ffe0cf;
    }

    .summary-total-label{
        font-size: 13px;
        color: #6b7280;
        font-weight: 700;
        margin-bottom: 6px;
    }

    .summary-total-value{
        font-size: 30px;
        font-weight: 900;
        color: #ff6b00;
        line-height: 1.1;
    }

    .summary-extra-note{
        font-size: 13px;
        line-height: 1.6;
        color: #6b7280;
        margin-top: 12px;
        margin-bottom: 0;
    }

    .cart-action-group{
        margin-top: 20px;
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .continue-btn-modern,
    .checkout-btn-modern{
        width: 100%;
        text-align: center;
        border: none;
        border-radius: 14px;
        padding: 15px 18px;
        font-weight: 800;
        font-size: 15px;
        transition: 0.25s ease;
    }

    .continue-btn-modern{
        background: #fff;
        color: #ff6b00 !important;
        border: 1px solid #ffd9bf;
    }

    .checkout-btn-modern{
        background: linear-gradient(135deg, #118b50, #16a34a);
        color: #fff;
        box-shadow: 0 14px 24px rgba(17,139,80,0.18);
        cursor: pointer;
    }

    .checkout-btn-modern:disabled{
        background: #9ca3af;
        box-shadow: none;
        cursor: not-allowed;
    }

    .empty-cart-card{
        background: #fff;
        border-radius: 24px;
        box-shadow: 0 18px 40px rgba(0,0,0,0.06);
        padding: 56px 30px;
        text-align: center;
    }

    .empty-cart-icon{
        width: 92px;
        height: 92px;
        border-radius: 50%;
        margin: 0 auto 18px;
        background: #fff3eb;
        color: #ff6b00;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 38px;
    }

    .empty-cart-card h3{
        font-size: 30px;
        font-weight: 800;
        color: #1f2937;
        margin-bottom: 10px;
    }

    .empty-cart-card p{
        color: #6b7280;
        font-size: 15px;
        line-height: 1.8;
        max-width: 520px;
        margin: 0 auto 24px;
    }

    @media (max-width: 1199px){
        .cart-main-grid{
            grid-template-columns: 1fr;
        }

        .cart-summary-card{
            position: static;
        }
    }

    @media (max-width: 767px){
        .cart-title{
            font-size: 30px;
        }

        .cart-hero{
            padding: 34px 22px;
        }

        .cart-item-row{
            flex-direction: column;
            align-items: stretch;
        }

        .cart-item-right{
            justify-content: flex-start;
        }

        .cart-item-left{
            align-items: flex-start;
        }

        .coupon-form{
            flex-direction: column;
        }

        .coupon-btn{
            width: 100%;
        }
    }
</style>

<section class="cart-page-section">
    <div class="container">

        <div class="cart-hero">
            <div class="cart-hero-content">
                <div class="cart-badge">Review Your Selected Items</div>
                <h1 class="cart-title">
                    Your <span>cart</span>, ready for checkout
                </h1>
                <p class="cart-subtitle">
                    Check your selected dishes, apply available coupon codes, review your final price,
                    and continue to a smooth modern checkout experience.
                </p>
            </div>
        </div>

        @if(Session::has('wrong'))
            <div class="cart-alert cart-alert-danger">
                <span class="cart-close" onclick="this.parentElement.style.display='none';">&times;</span>
                <strong>Oops!</strong> {{ Session::get('wrong') }}
            </div>
        @endif

        @if(Session::has('success'))
            <div class="cart-alert cart-alert-success">
                <span class="cart-close" onclick="this.parentElement.style.display='none';">&times;</span>
                <strong>Success!</strong> {{ Session::get('success') }}
            </div>
        @endif

        @if(count($carts) > 0)
            <div class="cart-main-grid">

                <div>
                    <div class="cart-items-card">
                        <h2 class="cart-section-title">Cart Items</h2>
                        <p class="cart-section-subtitle">
                            Review each item in your cart before proceeding. You can remove unwanted items
                            and continue shopping anytime.
                        </p>

                        @foreach($carts as $product)
                            <div class="cart-item-row">
                                <div class="cart-item-left">
                                    <div class="cart-item-icon">
                                        <i class="fa fa-cutlery"></i>
                                    </div>

                                    <div class="cart-item-details">
                                        <div class="cart-item-name">{{ $product->name }}</div>
                                        <div class="cart-item-meta">
                                            A selected menu item added to your cart for checkout.
                                        </div>
                                    </div>
                                </div>

                                <div class="cart-item-right">
                                    <div class="cart-price-chip">
                                        <span>Price</span>
                                        <strong>₹{{ $product->price }}</strong>
                                    </div>

                                    <div class="cart-qty-chip">
                                        <span>Qty</span>
                                        <strong>{{ $product->quantity }}</strong>
                                    </div>

                                    <div class="cart-subtotal-chip">
                                        <span>Subtotal</span>
                                        <strong>₹{{ $product->subtotal }}</strong>
                                    </div>

                                    <form method="post" action="{{ route('cart.destroy', $product) }}" onsubmit="return confirm('Are you sure you want to remove this item?')">
                                        @csrf
                                        <button class="remove-btn-modern" type="submit">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div>
                    <div class="coupon-card">
                        <h3 class="coupon-title">Apply Coupon</h3>
                        <p class="coupon-subtitle">
                            Have a promo code? Apply it here to enjoy additional savings on your order.
                        </p>

                        <form method="post" action="{{ route('coupon/apply') }}">
                            @csrf
                            <div class="coupon-form">
                                <input type="text" name="code" class="coupon-input" placeholder="Enter coupon code">

                                @if($total_price == 0)
                                    <button type="submit" class="coupon-btn" disabled>Apply Coupon</button>
                                @else
                                    <button type="submit" class="coupon-btn">Apply Coupon</button>
                                @endif
                            </div>
                        </form>
                    </div>

                    <div class="cart-summary-card">
                        <h3 class="summary-title">Order Summary</h3>

                        <div class="summary-line">
                            <div class="summary-label">Subtotal Before Discount</div>
                            <div class="summary-value">₹{{ $displayWithoutDiscount }}</div>
                        </div>

                        <div class="summary-line">
                            <div class="summary-label">Discount Applied</div>
                            <div class="summary-value discount">₹{{ $discount_price }}</div>
                        </div>

                        @if($total_price != 0)
                            @foreach($extra_charge as $chrage)
                                <div class="summary-line">
                                    <div class="summary-label">{{ $chrage->name }}</div>
                                    <div class="summary-value">₹{{ $chrage->price }}</div>
                                </div>
                            @endforeach
                        @endif

                        <div class="summary-total-box">
                            <div class="summary-total-label">Final Payable Amount</div>
                            <div class="summary-total-value">₹{{ $displayTotal }}</div>
                        </div>

                        <p class="summary-extra-note">
                            The final amount includes applicable charges and discounts shown above.
                        </p>

                        <div class="cart-action-group">
                            <a href="{{ url('/menu') }}" class="continue-btn-modern">
                                <i class="fa fa-angle-left"></i> Continue Shopping
                            </a>

                            <form method="post" action="{{ route('cart.checkout', $displayTotal) }}">
                                @csrf
                                @if($total_price == 0)
                                    <button class="checkout-btn-modern" type="submit" disabled>
                                        Proceed to Checkout
                                    </button>
                                @else
                                    <button class="checkout-btn-modern" type="submit">
                                        Proceed to Checkout
                                    </button>
                                @endif
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        @else
            <div class="empty-cart-card">
                <div class="empty-cart-icon">
                    <i class="fa fa-shopping-cart"></i>
                </div>
                <h3>Your cart is empty</h3>
                <p>
                    Looks like you have not added any dishes yet. Explore the menu and discover fresh,
                    tasty, and beautifully presented meals for your next order.
                </p>
                <a href="{{ url('/menu') }}" class="checkout-btn-modern" style="display:inline-block; width:auto; padding:15px 24px;">
                    Browse Menu
                </a>
            </div>
        @endif

    </div>
</section>

@endsection
