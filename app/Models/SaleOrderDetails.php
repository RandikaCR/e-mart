<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleOrderDetails extends Model
{
    use HasFactory;

    protected $fillable = [
        'sale_order_id',
        'product_id',
        'quantity',
        'unit_price',
    ];

    public function order(){
        return $this->belongsTo(SaleOrders::class);
    }

    public function product(){
        return $this->belongsTo(Products::class);
    }
}
