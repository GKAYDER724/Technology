<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class ReviewReply extends Model
{

    protected $table = 'review_replies';


    protected $primaryKey = 'reply_id';


    public $timestamps = false;



    protected $fillable = [
        'review_id',
        'admin_id',
        'content',
        'created_at',
    ];



    protected $casts = [
        'created_at' => 'datetime',
    ];



    // Review được trả lời
    public function review(): BelongsTo
    {
        return $this->belongsTo(
            Review::class,
            'review_id',
            'review_id'
        );
    }



    // Admin trả lời
    public function admin(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'admin_id',
            'user_id'
        );
    }

}