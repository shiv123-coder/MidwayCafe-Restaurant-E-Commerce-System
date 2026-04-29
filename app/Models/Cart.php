<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id', 'user_id', 'name', 'price', 'quantity', 'subtotal',
        'product_order', 'shipping_address', 'invoice_no', 'pay_method',
        'delivery_time', 'purchase_date', 'coupon_id', 'image',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'price' => 'decimal:2',
        'subtotal' => 'decimal:2',
        'purchase_date' => 'date',
    ];

    /**
     * Get the user that owns the cart item.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the product for this cart item.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
