<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

return new class extends Migration
{
    public function up()
    {
        // Ensure orders table has required columns
        Schema::table('orders', function (Blueprint $table) {

            if (!Schema::hasColumn('orders', 'user_id')) {
                $table->unsignedBigInteger('user_id')->nullable()->index()->after('id');
            }

            // ✅ FIX: ADD NAME COLUMN SAFETY (IMPORTANT FIX)
            if (!Schema::hasColumn('orders', 'name')) {
                $table->string('name')->nullable()->after('user_id');
            }

            if (!Schema::hasColumn('orders', 'invoice_no')) {
                $table->string('invoice_no')->nullable()->unique()->index()->after('name');
            }

            if (!Schema::hasColumn('orders', 'total_amount')) {
                $table->decimal('total_amount', 10, 2)->default(0)->nullable()->after('invoice_no');
            }

            if (!Schema::hasColumn('orders', 'status')) {
                $table->string('status')->default('Pending')->nullable()->index()->after('total_amount');
            }

            if (!Schema::hasColumn('orders', 'pay_method')) {
                $table->string('pay_method')->nullable()->after('status');
            }

            if (!Schema::hasColumn('orders', 'shipping_address')) {
                $table->string('shipping_address')->nullable()->after('pay_method');
            }

            if (!Schema::hasColumn('orders', 'delivery_time')) {
                $table->string('delivery_time')->nullable()->after('shipping_address');
            }

            if (!Schema::hasColumn('orders', 'purchase_date')) {
                $table->date('purchase_date')->nullable()->after('delivery_time');
            }

            if (!Schema::hasColumn('orders', 'coupon_id')) {
                $table->string('coupon_id')->nullable()->after('purchase_date');
            }

            if (!Schema::hasColumn('orders', 'transaction_id')) {
                $table->string('transaction_id')->nullable()->unique()->after('coupon_id');
            }

            if (!Schema::hasColumn('orders', 'currency')) {
                $table->string('currency')->default('BDT')->nullable()->after('transaction_id');
            }
        });

        // Fetch cart-based orders
        $cartOrders = DB::table('carts')
            ->where('product_order', '!=', 'no')
            ->whereNotNull('invoice_no')
            ->get();

        $groupedOrders = $cartOrders->groupBy('invoice_no');

        foreach ($groupedOrders as $invoiceNo => $items) {

            $firstItem = $items->first();

            // Prevent duplicate insert
            $exists = DB::table('orders')->where('invoice_no', $invoiceNo)->exists();
            if ($exists) continue;

            // Map status
            $mappedStatus = match ($firstItem->product_order) {
                'yes' => 'Pending',
                'approve' => 'Processed',
                'delivery' => 'Delivered',
                'cancel' => 'Cancelled',
                default => 'Pending'
            };

            $totalAmount = $items->sum('subtotal');

            // 🔥 FIX: USER NAME MUST BE INCLUDED
            $user = DB::table('users')->where('id', $firstItem->user_id)->first();
            $userName = $user->name ?? 'Guest User';

            $orderId = DB::table('orders')->insertGetId([
                'user_id' => $firstItem->user_id,
                'name' => $userName, // ✅ FIXED CRITICAL ISSUE
                'invoice_no' => $invoiceNo,
                'total_amount' => $totalAmount,
                'status' => $mappedStatus,
                'pay_method' => $firstItem->pay_method,
                'shipping_address' => $firstItem->shipping_address,
                'delivery_time' => $firstItem->delivery_time,
                'purchase_date' => $firstItem->purchase_date,
                'coupon_id' => $firstItem->coupon_id,
                'transaction_id' => $firstItem->transaction_id ?? null,
                'currency' => $firstItem->currency ?? 'BDT',
                'created_at' => $firstItem->created_at ?? now(),
                'updated_at' => $firstItem->updated_at ?? now(),
            ]);

            // Insert order items
            foreach ($items as $item) {
                DB::table('order_items')->insert([
                    'order_id' => $orderId,
                    'product_id' => $item->product_id,
                    'price' => $item->price,
                    'quantity' => $item->quantity,
                    'subtotal' => $item->subtotal,
                    'created_at' => $item->created_at ?? now(),
                    'updated_at' => $item->updated_at ?? now(),
                ]);
            }
        }
    }

    public function down()
    {
        // Safe rollback (optional)
        // DB::table('order_items')->truncate();
        // DB::table('orders')->truncate();
    }
};
