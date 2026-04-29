<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'invoice_no',
        'total_amount',
        'status',
        'pay_method',
        'shipping_address',
        'delivery_time',
        'purchase_date',
        'coupon_id',
        'transaction_id',
        'currency',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}
