<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleOrders extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'order_date',
        'status',
    ];

    public function orderDetails(){
        return $this->hasMany(SaleOrderDetails::class, 'sale_order_id');
    }

    public function customer(){
        return $this->belongsTo(Customers::class);
    }


    public function order_status(){

        switch ($this->status) {
            case '0':
                return array('text' => 'Pending', 'label' => 'bg-warning');
                break;
            case '1':
                return array('text' => 'Completed', 'label' => 'bg-success');
                break;
            case '2':
                return array('text' => 'Cancelled', 'label' => 'bg-danger');
                break;
            default:
                return array('text' => 'Pending', 'label' => 'badge-warning');
                break;
        }

    }

    public function order_total(){
        $order_details = SaleOrderDetails::where('sale_order_id', $this->id)->get();
        $total = 0;

        foreach ( $order_details as $od ){
            $line_total = $od->unit_price * $od->quantity;
            $total = $total + $line_total;
        }

        return $total;
    }
}
