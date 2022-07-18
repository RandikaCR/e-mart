<?php

namespace App\Http\Controllers;

use App\Models\Customers;
use App\Models\Products;
use App\Models\SaleOrders;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $today_start = date('Y-m-d 00:00:00', time());
        $today_end = date('Y-m-d 23:59:59', time());

        $orders = SaleOrders::whereBetween('order_date', [$today_start, $today_end])->get();

        $orders_today = $orders->count();
        $orders_today_amount = 0;
        foreach ( $orders as $o ){
            $orders_today_amount = $orders_today_amount + $o->order_total();
        }

        $all_orders = SaleOrders::where('id', '!=', 'null')->get()->count();
        $all_products = Products::where('id', '!=', 'null')->get()->count();
        $all_customers = Customers::where('id', '!=', 'null')->get()->count();



        $recent_customers = Customers::OrderBy('id', 'DESC')->take(5)->get();
        $recent_orders = SaleOrders::OrderBy('id', 'DESC')->take(5)->get();


        $monthly_sales = array();
        for ($i=1; $i < 13; $i++) {
            $m_start = date('Y-'.$i.'-01 00:00:00', time());
            $m_end = date('Y-'.$i.'-t 23:59:59', time());
            $mo = SaleOrders::whereBetween('order_date', [$m_start, $m_end])->count();

            array_push($monthly_sales, $mo);
        }


        return view('index',[
            'orders_today'=> $orders_today,
            'orders_today_amount'=> $orders_today_amount,
            'all_orders'=> $all_orders,
            'all_products'=> $all_products,
            'all_customers'=> $all_customers,
            'monthly_sales'=> $monthly_sales,
            'recent_customers'=> $recent_customers,
            'recent_orders'=> $recent_orders,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
