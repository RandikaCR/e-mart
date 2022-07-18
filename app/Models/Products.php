<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_name',
        'unit_price',
        'image',
    ];

    public function temp_cart(){
        return $this->hasMany(TempCart::class);
    }

    public function order(){
        return $this->hasMany(SaleOrders::class);
    }
}
