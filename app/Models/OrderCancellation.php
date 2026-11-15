<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderCancellation extends Model
{
    protected $table = 'order_cancellations';

    protected $primaryKey = 'cancellation_id';

    public $timestamps = false;


    protected $fillable = [
        'order_id',
        'reason',
        'status',
        'requested_at',
        'approved_at',
        'approved_by',
    ];


    protected $casts = [
        'requested_at' => 'datetime',
        'approved_at' => 'datetime',
    ];


    // Đơn hàng bị hủy
    public function order(): BelongsTo
    {
        return $this->belongsTo(
            Order::class,
            'order_id',
            'order_id'
        );
    }


    // Người duyệt hủy
    public function approvedBy(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'approved_by',
            'user_id'
        );
    }
}