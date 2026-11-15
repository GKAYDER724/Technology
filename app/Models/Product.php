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
    public $timestamps = false; // Bỏ dòng này nếu bảng có created_at, updated_at

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

    // Quan hệ với Danh mục
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id', 'category_id');
    }

    // Quan hệ với Thư viện ảnh
    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class, 'product_id', 'product_id');
    }

    // Lấy nhanh ảnh đại diện chính (is_primary = 1)
    public function primaryImage(): HasOne
    {
        return $this->hasOne(ProductImage::class, 'product_id', 'product_id')
            ->where('is_primary', 1);
    }

    // Quan hệ với Các phiên bản biến thể
    public function variants(): HasMany
    {
        return $this->hasMany(ProductVariant::class, 'product_id', 'product_id');
    }

    // Tự động tính lại tổng tồn kho từ các biến thể
    public function syncTotalStock(): void
    {
        if ($this->variants()->exists()) {
            $totalStock = $this->variants()->sum('stock');
            $this->updateQuietly(['stock' => $totalStock]);
        }
    }

    // Hàm hoàn kho cho sản phẩm không có biến thể
    public function restoreStock(int $quantity): void
    {
        $this->increment('stock', $quantity);
    }
}