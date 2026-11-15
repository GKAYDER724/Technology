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


    // Biến thể thuộc sản phẩm
    public function product(): BelongsTo
    {
        return $this->belongsTo(
            Product::class,
            'product_id',
            'product_id'
        );
    }


    // Đồng bộ tồn kho sản phẩm cha
    protected static function booted(): void
    {
        static::saved(function (ProductVariant $variant) {

            $variant->product?->syncTotalStock();

        });


        static::deleted(function (ProductVariant $variant) {

            $variant->product?->syncTotalStock();

        });
    }


    // Hoàn kho biến thể
    public function restoreStock(int $quantity): void
    {
        $this->increment('stock', $quantity);

        $this->product?->syncTotalStock();
    }
}