<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Review extends Model
{
    protected $table = 'reviews';

    protected $primaryKey = 'review_id';

    public $timestamps = false;


    protected $fillable = [
        'user_id',
        'order_item_id',
        'product_id',
        'comment',
        'status',
    ];


    protected $casts = [
        'created_at' => 'datetime',
    ];



    // Người đánh giá
    public function user(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'user_id',
            'user_id'
        );
    }



    // Sản phẩm được đánh giá
    public function product(): BelongsTo
    {
        return $this->belongsTo(
            Product::class,
            'product_id',
            'product_id'
        );
    }



    // Chi tiết đơn hàng được đánh giá
    public function orderItem(): BelongsTo
    {
        return $this->belongsTo(
            OrderItem::class,
            'order_item_id',
            'order_item_id'
        );
    }



    // Ảnh đánh giá
    public function images(): HasMany
    {
        return $this->hasMany(
            ReviewImage::class,
            'review_id',
            'review_id'
        );
    }



    // Phản hồi của admin
    public function replies(): HasMany
    {
        return $this->hasMany(
            ReviewReply::class,
            'review_id',
            'review_id'
        );
    }
}