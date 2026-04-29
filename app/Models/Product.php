<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'price', 'description', 'image',
        'category', 'session', 'available',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'price' => 'decimal:2',
        'metadata' => 'array', // JSONB column
    ];

    /**
     * Get the ratings for this product.
     */
    public function ratings()
    {
        return $this->hasMany(Rate::class, 'product_id');
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}
