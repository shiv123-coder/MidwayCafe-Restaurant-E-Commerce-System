@extends('layouts.app', ['title' => 'Checkout'])

@section('page-content')

<style>
    .checkout-page-section{
        padding: 20px 0 60px;
    }

    .checkout-hero{
        background: linear-gradient(135deg, #fff4ec 0%, #fffaf6 50%, #eefaf3 100%);
        border-radius: 28px;
        padding: 42px 34px;
        box-shadow: 0 20px 45px rgba(0,0,0,0.08);
        margin-bottom: 30px;
        position: relative;
        overflow: hidden;
    }

    .checkout-hero::before{
        content: "";
        position: absolute;
        width: 220px;
        height: 220px;
        border-radius: 50%;
        background: rgba(255,107,0,0.08);
        top: -60px;
        right: -60px;
    }

    .checkout-hero::after{
        content: "";
        position: absolute;
        width: 180px;
        height: 180px;
        border-radius: 50%;
        background: rgba(17,139,80,0.08);
        bottom: -50px;
        left: -50px;
    }

    .checkout-hero-content{
        position: relative;
        z-index: 2;
    }

    .checkout-badge{
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

    .checkout-title{
        font-size: 40px;
        font-weight: 800;
        color: #1f2937;
        margin-bottom: 10px;
        line-height: 1.15;
    }

    .checkout-title span{
        color: #ff6b00;
    }

    .checkout-subtitle{
        margin: 0;
        max-width: 760px;
        color: #6b7280;
        line-height: 1.8;
        font-size: 15px;
    }

    .checkout-main-grid{
        display: grid;
        grid-template-columns: 1.2fr 0.8fr;
        gap: 26px;
        align-items: start;
    }

    .payment-method-card,
    .order-summary-card,
    .trust-info-card{
        background: #fff;
        border-radius: 24px;
        box-shadow: 0 18px 40px rgba(0,0,0,0.06);
    }

    .payment-method-card{
        padding: 28px;
    }

    .section-title{
        font-size: 26px;
        font-weight: 800;
        color: #1f2937;
        margin-bottom: 8px;
    }

    .section-subtitle{
        color: #6b7280;
        font-size: 14px;
        line-height: 1.8;
        margin-bottom: 24px;
    }

    .payment-option{
        position: relative;
        margin-bottom: 18px;
    }

    .payment-option input[type="radio"]{
        position: absolute;
        opacity: 0;
        pointer-events: none;
    }

    .payment-option label{
        display: block;
        border: 2px solid #f1f1f1;
        border-radius: 22px;
        padding: 22px 22px 22px 74px;
        background: #fff;
        cursor: pointer;
        transition: 0.25s ease;
        position: relative;
        min-height: 110px;
    }

    .payment-option label:hover{
        border-color: #ffd8bf;
        box-shadow: 0 14px 26px rgba(0,0,0,0.05);
    }

    .payment-option label::before{
        content: "";
        position: absolute;
        left: 24px;
        top: 50%;
        transform: translateY(-50%);
        width: 28px;
        height: 28px;
        border-radius: 50%;
        border: 2px solid #d1d5db;
        background: #fff;
        transition: 0.25s ease;
    }

    .payment-option input[type="radio"]:checked + label{
        border-color: #ffb98f;
        background: linear-gradient(135deg, #fff8f3, #ffffff);
        box-shadow: 0 16px 30px rgba(255,107,0,0.08);
    }

    .payment-option input[type="radio"]:checked + label::before{
        border-color: #ff6b00;
        background: radial-gradient(circle, #ff6b00 40%, #fff 42%);
    }

    .payment-icon{
        width: 54px;
        height: 54px;
        border-radius: 16px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        margin-bottom: 10px;
    }

    .icon-cod{
        background: #fff3eb;
        color: #ff6b00;
    }

    .icon-online{
        background: #eefaf3;
        color: #118b50;
    }

    .payment-heading{
        font-size: 22px;
        font-weight: 800;
        color: #1f2937;
        margin-bottom: 6px;
    }

    .payment-desc{
        font-size: 14px;
        line-height: 1.8;
        color: #6b7280;
        margin-bottom: 0;
    }

    .payment-action-box{
        margin-top: 22px;
    }

    .action-panel{
        background: #f9fafb;
        border: 1px solid #f1f1f1;
        border-radius: 20px;
        padding: 20px;
    }

    .action-title{
        font-size: 18px;
        font-weight: 800;
        color: #1f2937;
        margin-bottom: 8px;
    }

    .action-desc{
        font-size: 14px;
        color: #6b7280;
        line-height: 1.7;
        margin-bottom: 16px;
    }

    .primary-checkout-btn,
    .secondary-checkout-btn{
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: none;
        border-radius: 14px;
        padding: 14px 20px;
        font-size: 15px;
        font-weight: 800;
        transition: 0.25s ease;
        text-decoration: none !important;
        cursor: pointer;
    }

    .primary-checkout-btn{
        background: linear-gradient(135deg, #118b50, #16a34a);
        color: #fff;
        box-shadow: 0 14px 24px rgba(17,139,80,0.18);
    }

    .secondary-checkout-btn{
        background: linear-gradient(135deg, #ff6b00, #ff8743);
        color: #fff;
        box-shadow: 0 14px 24px rgba(255,107,0,0.18);
    }

    .primary-checkout-btn:hover,
    .secondary-checkout-btn:hover{
        transform: translateY(-2px);
        color: #fff;
    }

    .order-summary-card{
        padding: 24px;
        margin-bottom: 22px;
        position: sticky;
        top: 110px;
    }

    .summary-title{
        font-size: 24px;
        font-weight: 800;
        color: #1f2937;
        margin-bottom: 16px;
    }

    .summary-box{
        background: linear-gradient(135deg, #fff3eb, #fff9f5);
        border: 1px solid #ffe0cf;
        border-radius: 20px;
        padding: 22px;
        margin-bottom: 18px;
    }

    .summary-small-label{
        font-size: 13px;
        color: #6b7280;
        font-weight: 700;
        margin-bottom: 6px;
    }

    .summary-price{
        font-size: 34px;
        line-height: 1.1;
        font-weight: 900;
        color: #ff6b00;
        margin-bottom: 6px;
    }

    .summary-text{
        margin: 0;
        color: #6b7280;
        font-size: 14px;
        line-height: 1.7;
    }

    .mini-trust-line{
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 12px 0;
        border-bottom: 1px solid #f1f1f1;
    }

    .mini-trust-line:last-child{
        border-bottom: none;
    }

    .mini-trust-line i{
        width: 38px;
        height: 38px;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: #fff3eb;
        color: #ff6b00;
        font-size: 16px;
    }

    .mini-trust-line span{
        font-size: 14px;
        color: #374151;
        font-weight: 600;
    }

    .trust-info-card{
        padding: 24px;
    }

    .trust-info-title{
        font-size: 22px;
        font-weight: 800;
        color: #1f2937;
        margin-bottom: 14px;
    }

    .trust-info-text{
        color: #6b7280;
        font-size: 14px;
        line-height: 1.8;
        margin-bottom: 0;
    }

    .login-note{
        margin-top: 14px;
        font-size: 14px;
        color: #6b7280;
    }

    @media (max-width: 1199px){
        .checkout-main-grid{
            grid-template-columns: 1fr;
        }

        .order-summary-card{
            position: static;
        }
    }

    @media (max-width: 767px){
        .checkout-title{
            font-size: 30px;
        }

        .checkout-hero{
            padding: 34px 22px;
        }

        .payment-option label{
            padding: 20px 18px 20px 64px;
        }
    }
</style>

<section class="checkout-page-section" ng-app="">
    <div class="container">

        <div class="checkout-hero">
            <div class="checkout-hero-content">
                <div class="checkout-badge">Final Step Before Placing Your Order</div>
                <h1 class="checkout-title">
                    Choose your <span>payment method</span>
                </h1>
                <p class="checkout-subtitle">
                    Complete your order securely by selecting the payment option that works best for you.
                    Pay on delivery or continue with online payment using UPI or card.
                </p>
            </div>
        </div>

        <div class="checkout-main-grid">

            <div class="payment-method-card">
                <h2 class="section-title">Select Payment Option</h2>
                <p class="section-subtitle">
                    Choose one of the available payment methods below to continue with your order.
                </p>

                <div class="payment-option">
                    <input ng-model="myVar" type="radio" id="cod" name="payment_method" value="cod">
                    <label for="cod">
                        <div class="payment-icon icon-cod">
                            <i class="fa fa-money"></i>
                        </div>
                        <div class="payment-heading">Cash on Delivery (COD)</div>
                        <p class="payment-desc">
                            Pay in cash when your order is delivered to your doorstep. This is simple,
                            trusted, and convenient for customers who prefer offline payment.
                        </p>
                    </label>
                </div>

                <div class="payment-option">
                    <input ng-model="myVar" type="radio" id="online" name="payment_method" value="online">
                    <label for="online">
                        <div class="payment-icon icon-online">
                            <i class="fa fa-credit-card"></i>
                        </div>
                        <div class="payment-heading">Pay with UPI / Card</div>
                        <p class="payment-desc">
                            Continue to the secure online payment gateway and complete your payment
                            using UPI, debit card, credit card, or other supported methods.
                        </p>
                    </label>
                </div>

                <div class="payment-action-box">
                    <div ng-switch="myVar">
                        @if (Auth::check())

                            <div ng-switch-when="cod" class="action-panel">
                                <div class="action-title">Place Order with COD</div>
                                <p class="action-desc">
                                    Your order will be confirmed now, and you can pay in cash when it arrives.
                                </p>

                                <form method="post" action="{{ route('mails.shipped', $total) }}">
                                    @csrf
                                    <button class="primary-checkout-btn" type="submit">
                                        Place Order with Cash on Delivery
                                    </button>
                                </form>
                            </div>

                            <div ng-switch-when="online" class="action-panel">
                                @php
                                    Session::put('total', $total);
                                @endphp

                                <div class="action-title">Continue with Online Payment</div>
                                <p class="action-desc">
                                    You will now be redirected to the secure payment page to complete your transaction safely.
                                </p>

                                <form method="POST" action="/pay">
                                    @csrf
                                    <div style="margin-bottom: 20px;">
                                        <label for="address" style="font-weight: 700; display: block; margin-bottom: 8px; color: #374151;">Delivery Address</label>
                                        <textarea name="address" id="address" class="form-control" placeholder="Enter your full delivery address" required style="border-radius: 12px; border: 1px solid #d1d5db; width: 100%; padding: 12px; min-height: 80px;"></textarea>
                                    </div>
                                    <button type="submit" class="secondary-checkout-btn" style="width: 100%;">
                                        Pay Online Securely (Demo)
                                    </button>
                                </form>
                            </div>

                        @else

                            <div ng-switch-when="cod" class="action-panel">
                                <div class="action-title">Login Required</div>
                                <p class="action-desc">
                                    Please log in first before placing your order with Cash on Delivery.
                                </p>
                                <a href="/login" class="primary-checkout-btn">
                                    Login to Continue
                                </a>
                            </div>

                            <div ng-switch-when="online" class="action-panel">
                                <div class="action-title">Login Required</div>
                                <p class="action-desc">
                                    Please log in first before continuing to secure online payment.
                                </p>
                                <a href="/login" class="secondary-checkout-btn">
                                    Login to Continue
                                </a>
                            </div>

                        @endif
                    </div>

                    <p class="login-note">
                        Select a payment method above to reveal the next action.
                    </p>
                </div>
            </div>

            <div>
                <div class="order-summary-card">
                    <h3 class="summary-title">Order Summary</h3>

                    <div class="summary-box">
                        <div class="summary-small-label">Total Amount Payable</div>
                        <div class="summary-price">₹{{ $total }}</div>
                        <p class="summary-text">
                            This is your final order amount based on the items currently selected in your cart.
                        </p>
                    </div>

                    <div class="mini-trust-line">
                        <i class="fa fa-shield"></i>
                        <span>Secure payment experience</span>
                    </div>

                    <div class="mini-trust-line">
                        <i class="fa fa-check-circle"></i>
                        <span>Simple and safe COD option</span>
                    </div>

                    <div class="mini-trust-line">
                        <i class="fa fa-bolt"></i>
                        <span>Fast checkout flow</span>
                    </div>
                </div>

                <div class="trust-info-card">
                    <h4 class="trust-info-title">Why this checkout feels better</h4>
                    <p class="trust-info-text">
                        This page is designed to make the last step of ordering easier, cleaner, and more trustworthy.
                        You can quickly understand the total amount, choose your preferred payment style,
                        and move forward without confusion.
                    </p>
                </div>
            </div>

        </div>
    </div>
</section>

@endsection
