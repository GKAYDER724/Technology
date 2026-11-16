<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
<<<<<<< HEAD
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
=======
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
>>>>>>> bc841f2 (Admin_quản lí sản phẩm)

class Category extends Model
{
    protected $table = 'categories';

    protected $primaryKey = 'category_id';

<<<<<<< HEAD
    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = true;


    protected $fillable = [
        'name',
        'status',
        'parent_id',
    ];


    public function getRouteKeyName(): string
    {
        return 'category_id';
    }


    /**
     * Danh mục cha
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(
            Category::class,
            'parent_id',
            'category_id'
        );
    }


    /**
     * Danh mục con
     */
    public function children(): HasMany
    {
        return $this->hasMany(
            Category::class,
            'parent_id',
            'category_id'
        );
    }


    /**
     * Sản phẩm thuộc danh mục
     */
    public function products(): HasMany
    {
        return $this->hasMany(
            Product::class,
            'category_id',
            'category_id'
        );
    }
}
=======
    protected $guarded = [];

    /**
     * Danh mục có nhiều sản phẩm.
     */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'category_id', 'category_id');
    }

    /**
     * Danh mục có thể thuộc một danh mục cha.
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'parent_id', 'category_id');
    }

    /**
     * Danh mục có thể có nhiều danh mục con.
     */
    public function children(): HasMany
    {
        return $this->hasMany(Category::class, 'parent_id', 'category_id');
    }
}
>>>>>>> bc841f2 (Admin_quản lí sản phẩm)
