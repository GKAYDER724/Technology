<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CartItem extends Model
{
    protected $table = 'cart_items';


    protected $primaryKey = 'cart_item_id';


    public $timestamps = false;


    protected $fillable = [
        'cart_id',
        'product_id',
        'variant_id',
        'quantity',
        'unit_price',
    ];


    protected $casts = [
        'quantity' => 'integer',
        'unit_price' => 'decimal:2',
    ];



    // Thuộc về giỏ hàng
    public function cart(): BelongsTo
    {
        return $this->belongsTo(
            Cart::class,
            'cart_id',
            'cart_id'
        );
    }



    // Thuộc về sản phẩm
    public function product(): BelongsTo
    {
        return $this->belongsTo(
            Product::class,
            'product_id',
            'product_id'
        );
    }



    // Có thể thuộc về biến thể
    public function variant(): BelongsTo
    {
        return $this->belongsTo(
            ProductVariant::class,
            'variant_id',
            'variant_id'
        );
    }
}