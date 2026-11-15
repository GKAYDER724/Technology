<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WarrantyCard extends Model
{
    protected $primaryKey = 'warranty_card_id';


    protected $fillable = [
        'warranty_request_id',
        'product_id',
        'serial_no',
        'start_date',
        'end_date',
        'status'
    ];


    public function request()
    {
        return $this->belongsTo(
            WarrantyRequest::class,
            'warranty_request_id',
            'warranty_request_id'
        );
    }


    public function product()
    {
        return $this->belongsTo(
            Product::class,
            'product_id',
            'product_id'
        );
    }
}