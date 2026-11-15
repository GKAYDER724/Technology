<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WarrantyRequest extends Model
{
    protected $primaryKey = 'warranty_request_id';

    protected $fillable = [
        'user_id',
        'order_item_id',
        'request_code',
        'reason',
        'status',
        'received_at',
        'result'
    ];


    public function user()
    {
        return $this->belongsTo(User::class,'user_id','user_id');
    }


    public function orderItem()
    {
        return $this->belongsTo(OrderItem::class,'order_item_id','order_item_id');
    }


    public function history()
    {
        return $this->hasMany(
            WarrantyHistory::class,
            'warranty_request_id',
            'warranty_request_id'
        );
    }


    public function card()
    {
        return $this->hasOne(
            WarrantyCard::class,
            'warranty_request_id',
            'warranty_request_id'
        );
    }
}