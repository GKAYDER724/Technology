<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ChatMessage extends Model
{

    protected $primaryKey = 'chat_message_id';

    protected $fillable = [
    'user_id',
    'sender',
    'message',
    'is_read'
];
    // Tin nhắn thuộc về một User
    public function user(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'user_id',
            'user_id'
        );
    }
    
}