<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WarrantyHistory extends Model
{
    protected $primaryKey = 'history_id';


    protected $fillable = [
        'warranty_request_id',
        'admin_id',
        'status',
        'note'
    ];


    public function request()
    {
        return $this->belongsTo(
            WarrantyRequest::class,
            'warranty_request_id',
            'warranty_request_id'
        );
    }


    public function admin()
    {
        return $this->belongsTo(
            User::class,
            'admin_id',
            'user_id'
        );
    }
}