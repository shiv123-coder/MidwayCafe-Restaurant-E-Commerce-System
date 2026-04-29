<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Mail;
use QrCode;
use PDF;

class SslCommerzPaymentController extends Controller
{
    /**
     * Handle the Demo Payment Request
     */
    public function index(Request $request)
    {
        // 1. Validate Address
        if (!$request->address) {
            return back()->with('wrong', 'Please provide a delivery address.');
        }

        // 2. Generate Invoice ID
        $invoice = 'INV-' . strtoupper(substr(md5(uniqid(mt_rand(), true)), 0, 8));
        
        // Store essential data in Session
        Session::put('invoice', $invoice);
        Session::put('address', $request->address);
        Session::put('date', date('d M Y'));

        // Fetch cart items
        $carts = DB::table('carts')
            ->where('user_id', Auth::id())
            ->where('product_order', 'no')
            ->get();

        if ($carts->isEmpty()) {
            return redirect()->route('cart')->with('wrong', 'Your cart is empty.');
        }

        $total = $carts->sum('subtotal');
        $coupon_code = $carts->first()->coupon_id ?? null;
        
        $discount_price = Session::get('discount_price', 0);
        $total_extra_charge = DB::table('charges')->sum('price');
        $final_total = $total - $discount_price + $total_extra_charge;

        // 3. Store Order
        $order = \App\Models\Order::create([
            'user_id' => Auth::id(),
            'invoice_no' => $invoice,
            'total_amount' => $final_total,
            'status' => 'Paid (Demo)',
            'pay_method' => 'Demo Payment',
            'shipping_address' => $request->address,
            'purchase_date' => date("Y-m-d"),
            'coupon_id' => $coupon_code,
            'transaction_id' => $invoice,
            'currency' => 'INR',
        ]);

        // 4. Store Order Items
        foreach ($carts as $cartItem) {
            \App\Models\OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $cartItem->product_id,
                'price' => $cartItem->price,
                'quantity' => $cartItem->quantity,
                'subtotal' => $cartItem->subtotal,
            ]);
        }

        // 5. Clear Cart
        DB::table('carts')
            ->where('user_id', Auth::id())
            ->where('product_order', 'no')
            ->delete();

        // 6. Redirect to Success Route
        return redirect()->route('payment.success');
    }

    /**
     * Handle Success Logic (After Demo Bypass)
     */
    public function success()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $invoice = Session::get('invoice');
        if (!$invoice) {
            return redirect()->route('cart')->with('wrong', 'Session expired or invalid request.');
        }

        // Fetch Order and Items for Invoice
        $order = \App\Models\Order::with('items.product')->where('invoice_no', $invoice)->first();
        if (!$order) {
            return redirect()->route('cart')->with('wrong', 'Order not found.');
        }

        $products = $order->items;
        $total = $order->total_amount;

        $extra_charge = DB::table('charges')->get();
        $discount_price = Session::get('discount_price', 0);
        $without_discount_price = Session::get('without_discount_price', $total);

        // 3. Generate QR Code (SVG)
        $qrcode = base64_encode(
            QrCode::format('svg')
                ->size(150)
                ->errorCorrection('H')
                ->generate("Order Verified - Invoice: " . $invoice . " | Total: " . $total . " INR")
        );
        Session::put('qrcode', $qrcode);

        // 4. Prepare Data for PDF & Email
        $data = [
            'invoice_no' => $invoice,
            'products' => $products,
            'total' => $total,
            'date' => Session::get('date'),
            'qrcode' => $qrcode,
            'extra_charge' => $extra_charge,
            'discount_price' => $discount_price,
            'without_discount_price' => $without_discount_price,
            'title' => 'Payment Confirmation'
        ];

        // 5. Generate PDF using the mail view
        $pdf = PDF::loadView('mails.pay-confirm-mail', $data);

        // 6. Send Email with PDF Attachment
        try {
            Mail::send('mails.pay-confirm-mail', $data, function ($message) use ($data, $pdf) {
                $message->to(Auth::user()->email)
                    ->subject('Order Confirmed - Invoice #' . $data['invoice_no'])
                    ->attachData($pdf->output(), "Invoice_" . $data['invoice_no'] . ".pdf");
            });
        } catch (\Exception $e) {
            // Log error but continue to success page
            \Log::error("Mail failed: " . $e->getMessage());
        }

        // 7. Return the payConfirm view
        return view('payConfirm');
    }

    public function fail()
    {
        return view('pages.failurepay');
    }

    public function cancel()
    {
        return view('pages.failurepay');
    }
}
