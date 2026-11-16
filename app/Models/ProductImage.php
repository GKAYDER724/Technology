<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductImage extends Model
{
    protected $table = 'product_images';

    protected $primaryKey = 'image_id';

    public $timestamps = false;

<<<<<<< HEAD

    protected $fillable = [
        'product_id',
        'image',
        'is_primary',
    ];

=======
    protected $guarded = [];
>>>>>>> bc841f2 (Admin_quản lí sản phẩm)

    protected $casts = [
        'is_primary' => 'boolean',
    ];

<<<<<<< HEAD

    // Hình ảnh thuộc sản phẩm
    public function product(): BelongsTo
    {
        return $this->belongsTo(
            Product::class,
            'product_id',
            'product_id'
        );
    }
}
=======
    /**
     * Hình ảnh thuộc một sản phẩm.
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id', 'product_id');
    }
}
>>>>>>> bc841f2 (Admin_quản lí sản phẩm)
