<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Product extends Model
{
    protected $table = 'products';

    protected $primaryKey = 'product_id';

    public $timestamps = true;

    protected $fillable = [
        'category_id',
        'name',
        'description',
        'base_price',
        'sale_price',
        'stock',
        'status',
    ];

    protected $casts = [
        'base_price' => 'decimal:2',
        'sale_price' => 'decimal:2',
        'stock' => 'integer',
    ];


    // Sản phẩm thuộc danh mục
    public function category(): BelongsTo
    {
        return $this->belongsTo(
            Category::class,
            'category_id',
            'category_id'
        );
    }


    // Danh sách hình ảnh sản phẩm
    public function images(): HasMany
    {
        return $this->hasMany(
            ProductImage::class,
            'product_id',
            'product_id'
        );
    }


    // Lấy ảnh đại diện chính
    public function primaryImage(): HasOne
    {
        return $this->hasOne(
            ProductImage::class,
            'product_id',
            'product_id'
        )->where('is_primary', 1);
    }


    // Danh sách biến thể sản phẩm
    public function variants(): HasMany
    {
        return $this->hasMany(
            ProductVariant::class,
            'product_id',
            'product_id'
        );
    }


    // Đồng bộ tổng tồn kho từ biến thể
    public function syncTotalStock(): void
    {
        if ($this->variants()->exists()) {

            $totalStock = $this->variants()->sum('stock');

            $this->updateQuietly([
                'stock' => $totalStock
            ]);
        }
    }


    // Hoàn kho sản phẩm
    public function restoreStock(int $quantity): void
    {
        $this->increment('stock', $quantity);
    }
}