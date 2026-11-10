<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    protected $table = 'categories';

    protected $primaryKey = 'category_id';

    public $timestamps = false; // Vì bảng trong DB không có created_at/updated_at

    protected $guarded = [];

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