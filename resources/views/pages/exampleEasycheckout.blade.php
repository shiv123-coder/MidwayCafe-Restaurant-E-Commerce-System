@extends('layouts.app', ['title' => 'Secure Online Payment'])

@section('page-content')

<style>
    .payment-gateway-section {
        padding: 60px 0;
        background: #f8fafc;
        min-height: 80vh;
    }

    .gateway-container {
        max-width: 900px;
        margin: 0 auto;
    }

    .gateway-card {
        background: #fff;
        border-radius: 32px;
        box-shadow: 0 25px 60px rgba(0,0,0,0.08);
        overflow: hidden;
        border: 1px solid #f1f1f1;
    }

    .gateway-header {
        background: linear-gradient(135deg, #118b50, #16a34a);
        padding: 40px;
        text-align: center;
        color: #fff;
    }

    .gateway-header h1 {
        font-size: 32px;
        font-weight: 800;
        margin-bottom: 10px;
    }

    .gateway-header p {
        opacity: 0.9;
        font-size: 16px;
    }

    .gateway-body {
        padding: 50px;
    }

    .amount-display {
        background: #f0fdf4;
        border: 2px dashed #bbf7d0;
        border-radius: 20px;
        padding: 30px;
        text-align: center;
        margin-bottom: 40px;
    }

    .amount-label {
        font-size: 14px;
        color: #166534;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 8px;
    }

    .amount-value {
        font-size: 48px;
        font-weight: 900;
        color: #118b50;
    }

    .payment-form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 30px;
    }

    .form-group {
        margin-bottom: 24px;
    }

    .form-label {
        display: block;
        font-size: 15px;
        font-weight: 700;
        color: #374151;
        margin-bottom: 10px;
    }

    .form-input {
        width: 100%;
        padding: 14px 18px;
        border: 2px solid #f1f1f1;
        border-radius: 14px;
        font-size: 15px;
        transition: 0.25s ease;
    }

    .form-input:focus {
        border-color: #16a34a;
        box-shadow: 0 0 0 4px rgba(22, 163, 74, 0.1);
        outline: none;
    }

    .pay-now-btn {
        grid-column: span 2;
        background: #118b50;
        color: #fff;
        border: none;
        padding: 20px;
        border-radius: 18px;
        font-size: 18px;
        font-weight: 800;
        cursor: pointer;
        transition: 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 12px;
        margin-top: 10px;
        box-shadow: 0 15px 30px rgba(17,139,80,0.2);
    }

    .pay-now-btn:hover {
        background: #0d6d3f;
        transform: translateY(-2px);
        box-shadow: 0 20px 40px rgba(17,139,80,0.3);
    }

    .trust-footer {
        padding: 30px;
        background: #f9fafb;
        border-top: 1px solid #f1f1f1;
        display: flex;
        justify-content: space-around;
        align-items: center;
    }

    .trust-item {
        display: flex;
        align-items: center;
        gap: 10px;
        color: #6b7280;
        font-size: 14px;
        font-weight: 600;
    }

    .trust-item i {
        color: #16a34a;
        font-size: 18px;
    }

    @media (max-width: 767px) {
        .payment-form-grid {
            grid-template-columns: 1fr;
        }
        .pay-now-btn {
            grid-column: span 1;
        }
        .gateway-body {
            padding: 30px 20px;
        }
    }
</style>

<section class="payment-gateway-section">
    <div class="container gateway-container">
        <div class="gateway-card">
            <div class="gateway-header">
                <h1>Secure Payment</h1>
                <p>Complete your transaction using SSLCommerz Secure Gateway</p>
            </div>

            <div class="gateway-body">
                <div class="amount-display">
                    <div class="amount-label">Total Amount to Pay</div>
                    <div class="amount-value">₹{{ $total }}</div>
                </div>

                <form action="{{ url('/pay') }}" method="POST" class="payment-form-grid" id="payment-form">
                    @csrf
                    <div class="form-group">
                        <label class="form-label">Full Name</label>
                        <input type="text" name="customer_name" class="form-input" value="{{ Auth::user()->name }}" required readonly>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Email Address</label>
                        <input type="email" name="customer_email" class="form-input" value="{{ Auth::user()->email }}" required readonly>
                    </div>

                    <div class="form-group" style="grid-column: span 2;">
                        <label class="form-label">Delivery Address</label>
                        <textarea name="address" class="form-input" rows="3" placeholder="Enter your full delivery address" required></textarea>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Phone Number</label>
                        <input type="text" name="customer_mobile" class="form-input" value="{{ Auth::user()->phone }}" required>
                    </div>

                    <button type="submit" class="pay-now-btn" id="sslczPayBtn" 
                            token="if you have any token validation" 
                            postdata="your post data" 
                            order="If you already have the order id" 
                            endpoint="{{ url('/pay-via-ajax') }}">
                        <i class="fa fa-lock"></i> Proceed to Pay Securely
                    </button>
                </form>
            </div>

            <div class="trust-footer">
                <div class="trust-item">
                    <i class="fa fa-shield"></i> SSL Encrypted
                </div>
                <div class="trust-item">
                    <i class="fa fa-check-circle"></i> Verified Merchant
                </div>
                <div class="trust-item">
                    <i class="fa fa-refresh"></i> Secure Processing
                </div>
            </div>
        </div>
    </div>
</section>

<!-- SSLCommerz Library -->
<script>
    (function (window, document) {
        var loader = function () {
            var script = document.createElement("script"), tag = document.getElementsByTagName("script")[0];
            script.src = "https://sandbox.sslcommerz.com/embed.min.js?" + Math.random().toString(36).substring(7);
            tag.parentNode.insertBefore(script, tag);
        };

        window.addEventListener ? window.addEventListener("load", loader, false) : window.attachEvent("onload", loader);
    })(window, document);
</script>

@endsection
