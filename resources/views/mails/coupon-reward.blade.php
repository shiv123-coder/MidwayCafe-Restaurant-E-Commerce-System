<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f4f7;
            color: #51545e;
            margin: 0;
            padding: 0;
            width: 100% !important;
        }
        .wrapper {
            width: 100%;
            background-color: #f4f4f7;
            padding: 40px 0;
        }
        .content {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 10px rgba(0,0,0,0.05);
        }
        .header {
            background: linear-gradient(135deg, #ff6b00, #ff8743);
            padding: 40px;
            text-align: center;
            color: #ffffff;
        }
        .header h1 {
            margin: 0;
            font-size: 28px;
            font-weight: 800;
        }
        .body {
            padding: 40px;
            line-height: 1.6;
        }
        .coupon-box {
            background-color: #fff8f3;
            border: 2px dashed #ffb98f;
            border-radius: 16px;
            padding: 30px;
            text-align: center;
            margin: 30px 0;
        }
        .coupon-code {
            font-size: 36px;
            font-weight: 900;
            color: #ff6b00;
            letter-spacing: 2px;
            margin: 10px 0;
        }
        .discount-text {
            font-size: 18px;
            font-weight: 700;
            color: #374151;
        }
        .footer {
            padding: 30px;
            text-align: center;
            font-size: 13px;
            color: #b0adc5;
            background-color: #f9fafb;
        }
        .btn {
            display: inline-block;
            padding: 14px 28px;
            background-color: #ff6b00;
            color: #ffffff !important;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 700;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="content">
            <div class="header">
                <h1>Loyalty Reward!</h1>
            </div>
            <div class="body">
                <p>Hi <strong>{{ $name }}</strong>,</p>
                <p>Congratulations! You have completed 4 orders with us. To show our appreciation for your loyalty, we've generated a special discount coupon just for you.</p>
                
                <div class="coupon-box">
                    <div class="discount-text">YOU GET</div>
                    <div class="coupon-code">{{ $percentage }}% OFF</div>
                    <div class="discount-text">ON YOUR NEXT ORDER</div>
                    <p style="margin-top: 15px; font-size: 14px; color: #6b7280;">Use code: <strong>{{ $code }}</strong></p>
                </div>

                <p>This coupon is valid for the next 30 days. Simply enter the code at checkout to enjoy your discount.</p>
                
                <div style="text-align: center;">
                    <a href="{{ url('/') }}" class="btn">Order Now</a>
                </div>
            </div>
            <div class="footer">
                <p>&copy; {{ date('Y') }} Restaurant Management System. All rights reserved.</p>
                <p>If you have any questions, feel free to contact our support team.</p>
            </div>
        </div>
    </div>
</body>
</html>
