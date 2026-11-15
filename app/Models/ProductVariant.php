<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductVariant extends Model
{
    protected $table = 'product_variants';
    protected $primaryKey = 'variant_id';
    public $timestamps = false;

    protected $fillable = [
        'product_id',
        'variant_name',
        'sku',
        'price',
        'stock',
        'status',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'stock' => 'integer',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id', 'product_id');
    }

    // Tự động đồng bộ tổng tồn kho lên sản phẩm cha mỗi khi biến thể thay đổi
    protected static function booted(): void
    {
        static::saved(function (ProductVariant $variant) {
            $variant->product?->syncTotalStock();
        });

        static::deleted(function (ProductVariant $variant) {
            $variant->product?->syncTotalStock();
        });
    }

    // Hàm hoàn kho khi user hủy đơn hàng (VD: $variant->restoreStock(3))
    public function restoreStock(int $quantity): void
    {
        $this->increment('stock', $quantity);
        // Sự kiện 'saved' hoặc gọi trực tiếp syncTotalStock() sẽ tự cộng lại tổng kho sản phẩm cha
        $this->product?->syncTotalStock();
    }
}