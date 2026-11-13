<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Category extends Model
{
    protected $table = 'categories';

    protected $primaryKey = 'category_id';

    public $incrementing = true; // Thêm dòng này để Filament hiểu cột khóa chính tự tăng

    protected $keyType = 'int'; // Kiểu dữ liệu của khóa chính là số nguyên

    public $timestamps = false; // Vì bảng trong DB không có created_at/updated_at

    protected $guarded = [];

    /**
     * Khai báo khóa chính cho Route/Filament binding để nhận diện đúng bản ghi.
     */
    public function getRouteKeyName(): string
    {
        return 'category_id';
    }

    /**
     * Tự động sinh slug từ tên danh mục nếu slug bị trống hoặc chưa có.
     */
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($category) {
            if (empty($category->slug)) {
                $category->slug = Str::slug($category->name);
            }
        });
    }

    // Quan hệ lấy danh mục cha
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'parent_id', 'category_id');
    }

    // Quan hệ lấy danh sách các danh mục con trực thuộc
    public function children(): HasMany
    {
        return $this->hasMany(Category::class, 'parent_id', 'category_id');
    }
}