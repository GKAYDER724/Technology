<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    protected $table = 'orders';

    protected $primaryKey = 'order_id';

    public $timestamps = false;


    protected $fillable = [
        'user_id',
        'order_code',
        'name',
        'phone',
        'address',
        'total_amount',
        'payment_method',
        'status',
    ];


    protected $casts = [
        'total_amount' => 'decimal:2',
    ];


    // Người đặt hàng
    public function user(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'user_id',
            'user_id'
        );
    }


    // Chi tiết đơn hàng
    public function items(): HasMany
    {
        return $this->hasMany(
            OrderItem::class,
            'order_id',
            'order_id'
        );
    }


    // Yêu cầu hủy đơn
    public function cancellation(): HasMany
    {
        return $this->hasMany(
            OrderCancellation::class,
            'order_id',
            'order_id'
        );
    }
}