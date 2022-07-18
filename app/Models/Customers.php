<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customers extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_name',
        'email',
        'mobile',
    ];

    public function order(){
        return $this->hasMany(SaleOrders::class);
    }
}
