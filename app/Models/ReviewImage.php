<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class ReviewImage extends Model
{

    protected $table = 'review_images';


    protected $primaryKey = 'review_image_id';


    public $timestamps = false;



    protected $fillable = [
        'review_id',
        'image',
    ];



    public function review(): BelongsTo
    {
        return $this->belongsTo(
            Review::class,
            'review_id',
            'review_id'
        );
    }

}