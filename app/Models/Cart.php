<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cart extends Model
{
    protected $table = 'carts';

    protected $primaryKey = 'cart_id';

    public $timestamps = true;


    protected $fillable = [
        'user_id',
    ];


    protected $casts = [
        'user_id' => 'integer',
    ];


    // Giỏ hàng thuộc về User
    public function user(): BelongsTo
{
    return $this->belongsTo(
        User::class,
        'user_id',
        'user_id'
    );
}


    // Một giỏ hàng có nhiều sản phẩm
    public function items(): HasMany
    {
        return $this->hasMany(
            CartItem::class,
            'cart_id',
            'cart_id'
        );
    }
}