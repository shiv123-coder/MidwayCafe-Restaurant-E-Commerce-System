<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\ApproveMail;
use Illuminate\Support\Facades\Cache;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;

class OrderController extends Controller
{
    /* ---------------------------
        INCOMPLETE ORDERS
    ----------------------------*/
    public function incomplete()
    {
        $orders = Order::with('user')
            ->where('status', 'Pending')
            ->latest()
            ->paginate(10);

        return view('admin.pages.incomplete-orders', compact('orders'));
    }

    /* ---------------------------
        COMPLETE ORDERS
    ----------------------------*/
    public function complete()
    {
        $orders = Order::with('user')
            ->where('status', 'Delivered')
            ->latest()
            ->paginate(10);

        return view('admin.pages.complete_orders', compact('orders'));
    }

    /* ---------------------------
        PROCESS ORDERS
    ----------------------------*/
    public function process()
    {
        $orders = Order::with('user')
            ->where('status', 'Processed')
            ->latest()
            ->paginate(10);

        return view('admin.pages.process_order', compact('orders'));
    }

    /* ---------------------------
        CANCEL LIST
    ----------------------------*/
    public function cancel_list()
    {
        $orders = Order::with('user')
            ->where('status', 'Cancelled')
            ->latest()
            ->paginate(10);

        return view('admin.pages.cancel_order', compact('orders'));
    }

    /* ---------------------------
        ORDER DETAILS (OPTIMIZED)
    ----------------------------*/
    public function details($id)
    {
        $order = Order::with(['user', 'items.product'])
            ->where('invoice_no', $id)
            ->first();

        if (!$order) {
            return back()->with('wrong', 'Order not found');
        }

        $products = $order->items;
        $total_price = $order->total_amount;

        // Calculate base price without discounts/charges for display if needed
        $base_subtotal = $products->sum('subtotal');

        $coupon_code = $order->coupon_id;
        $coupon_percentage = $coupon_code
            ? DB::table('coupons')->where('code', $coupon_code)->value('percentage')
            : 0;

        $discount_price = floor(($base_subtotal * $coupon_percentage) / 100);

        $extra_charge = Cache::remember('charges_all', 3600, function () {
            return DB::table('charges')->get();
        });

        $total_extra_charge = Cache::remember('charges_sum', 3600, function () {
            return DB::table('charges')->sum('price');
        });

        $without_discount_price = $base_subtotal + $total_extra_charge;

        return view('admin.pages.invoice_details', compact(
            'order',
            'total_price',
            'extra_charge',
            'total_extra_charge',
            'discount_price',
            'without_discount_price',
            'products'
        ));
    }

    /* ---------------------------
        APPROVE ORDER
    ----------------------------*/
    public function approve(Request $request, $id)
    {
        $time_set_up = date("F j, Y, G:i:sa", strtotime($request->time));

        $order = Order::where('invoice_no', $id)->first();

        if (!$order) {
            return back()->with('wrong', 'Order not found');
        }

        $user = $order->user;

        if ($user) {
            Mail::to($user->email)->send(new ApproveMail([
                'title' => 'Mail from RMS Admin',
                'body' => "Your order approved. Invoice: $id. Delivery: $time_set_up"
            ]));
        }

        $order->update([
            'status' => 'Processed',
            'delivery_time' => $time_set_up
        ]);

        session()->flash('success', 'Order approved successfully!');
        return back();
    }

    /* ---------------------------
        CANCEL ORDER
    ----------------------------*/
    public function cancel($id)
    {
        $order = Order::where('invoice_no', $id)->first();

        if (!$order) {
            return back()->with('wrong', 'Order not found');
        }

        $user = $order->user;

        $body = ($order->pay_method == "Online Payment" || $order->pay_method == "Demo Payment")
            ? "Refund will be processed. Invoice: $id"
            : "Order cancelled. Invoice: $id";

        if ($user) {
            Mail::to($user->email)->send(new ApproveMail([
                'title' => 'Mail from RMS Admin',
                'body' => $body
            ]));
        }

        $order->update(['status' => 'Cancelled']);

        session()->flash('success', 'Order cancelled successfully!');
        return back();
    }

    /* ---------------------------
        MARK COMPLETE
    ----------------------------*/
    public function mark_complete($id)
    {
        $order = Order::where('invoice_no', $id)->first();

        if (!$order) {
            return back()->with('wrong', 'Order not found.');
        }

        $order->update(['status' => 'Delivered']);

        session()->flash('success', 'Order delivered successfully!');
        return back();
    }

    public function location()
    {
        return view('admin.pages.order-location');
    }

    public function edit_location(Request $request)
    {
        $id = $request->id;

        $order = Order::with('items.product')->where('invoice_no', $id)->first();

        if (!$order) {
            return back()->with('wrong', 'Invalid Invoice');
        }

        if ($order->status != "Processed") {
            return back()->with('wrong', 'Order not approved');
        }

        $products = $order->items;
        $total_price = $order->total_amount;

        return view('admin.pages.update_order_location', compact(
            'order',
            'products',
            'total_price'
        ));
    }
}
