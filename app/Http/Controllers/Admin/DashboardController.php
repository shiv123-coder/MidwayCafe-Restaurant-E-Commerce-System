<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Use distinct count instead of groupBy()->get()->count() for PostgreSQL compatibility
        $pending_order = \App\Models\Order::where('status', 'Pending')->count();
        $processing_order = \App\Models\Order::where('status', 'Processed')->count();
        $cancel_order = \App\Models\Order::where('status', 'Cancelled')->count();
        $complete_order = \App\Models\Order::where('status', 'Delivered')->count();

        $total = \App\Models\Order::sum('total_amount');
        $cash_on_payment = \App\Models\Order::where('pay_method', 'Cash On Delivery')->sum('total_amount');
        $online_payment = $total - $cash_on_payment;

        $customer = DB::table('users')->where('usertype', '0')->count();
        $delivery_boy = DB::table('users')->where('usertype', '2')->count();
        $admin = DB::table('users')->where('usertype', '1')->count();

        // Top Rated Logic
        $top_rated = DB::table('rates')
            ->join('products', 'rates.product_id', '=', 'products.id')
            ->select('products.id', 'products.name', 'products.image', 'products.price', DB::raw('AVG(star_value) as avg_rating'), DB::raw('COUNT(rates.id) as voter_count'))
            ->groupBy('products.id', 'products.name', 'products.image', 'products.price')
            ->orderByDesc('avg_rating')
            ->limit(5)
            ->get();

        // Best Selling Logic
        $best_selling = \App\Models\OrderItem::join('products', 'order_items.product_id', '=', 'products.id')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->select('products.id', 'products.name', 'products.image', 'products.price', DB::raw('SUM(order_items.quantity) as total_sold'))
            ->where('orders.status', '!=', 'Cancelled')
            ->groupBy('products.id', 'products.name', 'products.image', 'products.price')
            ->orderByDesc('total_sold')
            ->limit(5)
            ->get();

        return view('admin.pages.dashboard', compact(
            'pending_order', 'processing_order', 'cancel_order', 'complete_order',
            'total', 'cash_on_payment', 'online_payment',
            'customer', 'delivery_boy', 'admin',
            'top_rated', 'best_selling'
        ));
    }
    public function logout(Request $request)
    {
        \Illuminate\Support\Facades\Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}
