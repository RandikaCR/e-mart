<?php

namespace App\Http\Controllers;

use App\Models\Customers;
use App\Models\Products;
use App\Models\SaleOrderDetails;
use App\Models\SaleOrders;
use App\Models\TempCart;
use Illuminate\Http\Request;

class OrdersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = SaleOrders::orderBy('id', 'DESC')->paginate(20);

        return view('orders.index',['orders'=> $orders]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

        $temp_id = $request->session()->get('temp_session_id');

        if ( !$request->session()->has('temp_session_id') ) {
            $temp_no = rand(1,99999).time();
            $request->session()->put('temp_session_id', $temp_no);
        }


        $products = Products::where('id', '!=', 'null')->take(20)->get();
        $customers = Customers::OrderBy('customer_name', 'ASC')->get();
        $cart_items = TempCart::where('session_id', $temp_id)->get();
        $cart_item_count = $cart_items->count();

        $cart_total = 0;
        foreach ($cart_items as $c){
            $line_amount = $c->product->unit_price * $c->quantity;
            $cart_total = $cart_total + $line_amount;
        }


        return view('orders.create',[
            'products' => $products,
            'customers' => $customers,
            'cart_items' => $cart_items,
            'cart_total' => $cart_total,
            'cart_item_count' => $cart_item_count,
            ]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $temp_id = $request->session()->get('temp_session_id');

        $validatedData = $request->validate([
            'customer_id' => ['required'],
        ]);


        $order = SaleOrders::create([
            'customer_id' => $request->customer_id,
            'order_date' => date('Y-m-d H:i:s', time()),
            'status' => 0,
        ]);

        $cart_items = TempCart::where('session_id', $temp_id)->get();
        foreach ( $cart_items as $c ){
            $order_details = SaleOrderDetails::create([
                'sale_order_id' => $order->id,
                'product_id' => $c->product_id,
                'quantity' => $c->quantity,
                'unit_price' => $c->product->unit_price,
            ]);

            //clear cart item
            $c->delete();
        }

        //clear session id
        $request->session()->forget('temp_session_id');

        //flash message
        session()->flash('success', 'New Order Created!');

        return redirect( route('orders.index') );


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $order = SaleOrders::find($id);

        return view('orders.show',['order'=> $order]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $order = SaleOrders::find($id);

        $products = Products::where('id', '!=', 'null')->take(20)->get();
        $customers = Customers::OrderBy('customer_name', 'ASC')->get();

        $order_products = SaleOrderDetails::where('sale_order_id', $id)->get();

        $cart_total = 0;
        foreach ($order_products as $c){
            $line_amount = $c->product->unit_price * $c->quantity;
            $cart_total = $cart_total + $line_amount;
        }

        $cart_item_count = $order_products->count();

        return view('orders.update',[
            'order' => $order,
            'products' => $products,
            'customers' => $customers,
            'cart_items' => $order_products,
            'cart_total' => $cart_total,
            'cart_item_count' => $cart_item_count,
        ]);
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
        $order = SaleOrders::find($id);

        $validatedData = $request->validate([
            'customer_id' => ['required'],
            'status' => ['required'],
        ]);

        $data = $request->only([
            'customer_id',
            'status',
        ]);


        //Update attributes
        $order->update($data);

        //flash message
        session()->flash('success', 'Order Updated!');

        return redirect( route('orders.index') );
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


    public function productsFilter(Request $request)
    {
        if($request->ajax()){

            $search = $request->keyword;

            if ( strlen(trim($search)) > 2 ){
                $products = Products::where( function($q) {
                    $search = $_POST['keyword'];
                    $q->where('id','=',$search)
                        ->orWhere('product_name', 'like', '%' . $search . '%')
                        ->orWhere('unit_price', 'like', '%' . $search . '%');
                })
                    ->orderBy('product_name','ASC')
                    ->take(20)
                    ->get();

            }else{
                $products = Products::where('id', '!=', 'null')->take(20)->get();
            }


            $products_list = '';
            foreach ($products as $p ){

                $product_id = $p->id;
                $product_name = $p->product_name;
                $unit_price = number_format($p->unit_price, 2);
                $image = asset('storage/products/'.$p->image);

                $products_list .= '<div class="col-12 col-sm-3 mb-4">
                            <div class="card">
                                <a href="javascript:void(0);" data-id="'.$product_id.'" class="add-this">
                                    <img src="'.$image.'" class="card-img-top" alt="...">
                                </a>
                                <div class="card-body">
                                    <h5 class="card-title text-center">'.$product_name.'</h5>
                                    <p class="card-text mb-2 text-center">'.$unit_price.'</p>
                                    <a href="javascript:void(0);" data-id="'.$product_id.'" class="btn btn-primary w-100 add-this">Add</a>
                                </div>
                            </div>
                        </div>';

            }

            return response()->json([
                'products'=> $products_list,
            ]);

        }
    }


    public function addToCart(Request $request)
    {
        if($request->ajax()){

            $this_product_id = $request->id;
            $temp_id = $request->session()->get('temp_session_id');


            $carts = TempCart::where('session_id', $temp_id)->where('product_id', $this_product_id)->get();

            if ( $carts->count() > 0 ){
                foreach ( $carts as $item ){

                    $qty = $item->quantity + 1;
                    $tc = TempCart::find($item->id);
                    $data['quantity'] = $qty;
                    $tc->update($data);

                }
            }else{
                $new = TempCart::create([
                    'session_id' => $temp_id,
                    'product_id' => $this_product_id,
                    'quantity' => 1,
                ]);
            }



            $items = '';
            $total = 0;

            $cart_items = TempCart::where('session_id', $temp_id)->get();
            foreach ( $cart_items as $c ){

                $item_id = $c->id;
                $item_product_id = $c->product->id;
                $img = asset('storage/products/'. $c->product->image);
                $product_name = $c->product->product_name;
                $unit_price = $c->product->unit_price;
                $quantity = $c->quantity;
                $line_amount = $unit_price * $quantity;

                $total = $total + $line_amount;

                $unit_price = number_format($unit_price, 2);
                $line_amount = number_format($line_amount, 2);

                $items .= '<div class="row mb-3">
                                <div class="col-md-2">
                                    <img src="'.$img.'" class="w-100" alt="">
                                </div>
                                <div class="col-md-3 d-flex align-items-center">
                                    <p class="text-secondary">'.$product_name.'</p>
                                </div>
                                <div class="col-md-3 d-flex align-items-center">
                                    <input type="number" name="quantity" class="form-control text-center mb-2 mb-sm-0 update-this" data-id="'.$item_product_id.'" value="'.$quantity.'" min="1">
                                </div>
                                <div class="col-md-3 d-flex align-items-end flex-column justify-content-center">
                                    <p class="text-primary" style="font-size: 1rem;">'.$line_amount.'</p>
                                    <p class="text-secondary" style="font-size: 0.7rem;">'.$unit_price.' x '.$quantity.'</p>
                                </div>
                                <div class="col-md-1 d-flex align-items-center justify-content-end">
                                    <a href="javascript:void(0);" data-id="'.$item_id.'" class="text-danger delete-cart-item"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg></a>
                                </div>
                            </div>';
            }

            $cart_item_count = $cart_items->count();

            return response()->json([
                'items'=> $items,
                'cart_item_count' => $cart_item_count,
                'total'=> number_format($total, 2),
            ]);

        }
    }


    public function updateCart(Request $request)
    {
        if($request->ajax()){

            $this_product_id = $request->id;
            $this_product_qty = $request->quantity;
            $temp_id = $request->session()->get('temp_session_id');


            $item = TempCart::where('session_id', $temp_id)->where('product_id', $this_product_id)->first();
            $tc = TempCart::find($item->id);
            $data['quantity'] = $this_product_qty;
            $tc->update($data);



            $items = '';
            $total = 0;

            $cart_items = TempCart::where('session_id', $temp_id)->get();
            foreach ( $cart_items as $c ){

                $item_id = $c->id;
                $item_product_id = $c->product->id;
                $img = asset('storage/products/'. $c->product->image);
                $product_name = $c->product->product_name;
                $unit_price = $c->product->unit_price;
                $quantity = $c->quantity;
                $line_amount = $unit_price * $quantity;

                $total = $total + $line_amount;

                $unit_price = number_format($unit_price, 2);
                $line_amount = number_format($line_amount, 2);

                $items .= '<div class="row mb-3">
                                <div class="col-md-2">
                                    <img src="'.$img.'" class="w-100" alt="">
                                </div>
                                <div class="col-md-3 d-flex align-items-center">
                                    <p class="text-secondary">'.$product_name.'</p>
                                </div>
                                <div class="col-md-3 d-flex align-items-center">
                                    <input type="number" name="quantity" class="form-control text-center mb-2 mb-sm-0 update-this" data-id="'.$item_product_id.'" value="'.$quantity.'" min="1">
                                </div>
                                <div class="col-md-3 d-flex align-items-end flex-column justify-content-center">
                                    <p class="text-primary" style="font-size: 1rem;">'.$line_amount.'</p>
                                    <p class="text-secondary" style="font-size: 0.7rem;">'.$unit_price.' x '.$quantity.'</p>
                                </div>
                                <div class="col-md-1 d-flex align-items-center justify-content-end">
                                    <a href="javascript:void(0);" data-id="'.$item_id.'" class="text-danger delete-cart-item"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg></a>
                                </div>
                            </div>';
            }


            $cart_item_count = $cart_items->count();
            return response()->json([
                'cart_item_count' => $cart_item_count,
                'items'=> $items,
                'total'=> number_format($total, 2),
            ]);

        }
    }


    public function deleteCartItem(Request $request)
    {
        if($request->ajax()){

            $item = TempCart::find($request->id);
            $item->delete();

            return response()->json([
                'success'=> 'Cart Item Deleted!',
            ]);

        }
    }


    public function delete(Request $request)
    {
        if($request->ajax()){

            $order = SaleOrders::find($request->id);
            $order->delete();

            $order_details = SaleOrderDetails::where('sale_order_id', $request->id)->get();
            foreach ( $order_details as $od ){
                $od->delete($od->id);
            }

            return response()->json([
                'success'=> 'Customer Deleted!',
            ]);

        }
    }



    public function addToOrder(Request $request)
    {
        if($request->ajax()){

            $temp_id = $request->id;
            $order_id = $request->order_id;

            $carts = SaleOrderDetails::where('sale_order_id', $order_id)->where('product_id', $temp_id)->get();

            if ( $carts->count() > 0 ){
                foreach ( $carts as $item ){

                    $qty = $item->quantity + 1;
                    $tc = SaleOrderDetails::find($item->id);
                    $data['quantity'] = $qty;
                    $tc->update($data);

                }
            }else{

                $prod = Products::find($temp_id);

                $new = SaleOrderDetails::create([
                    'sale_order_id' => $order_id,
                    'product_id' => $temp_id,
                    'quantity' => 1,
                    'unit_price' => $prod->unit_price,
                ]);
            }



            $items = '';
            $total = 0;

            $cart_items = SaleOrderDetails::where('sale_order_id', $order_id)->get();
            foreach ( $cart_items as $c ){

                $item_id = $c->id;
                $item_product_id = $c->product->id;
                $img = asset('storage/products/'. $c->product->image);
                $product_name = $c->product->product_name;
                $unit_price = $c->product->unit_price;
                $quantity = $c->quantity;
                $line_amount = $unit_price * $quantity;

                $total = $total + $line_amount;

                $unit_price = number_format($unit_price, 2);
                $line_amount = number_format($line_amount, 2);

                $items .= '<div class="row mb-3">
                                <div class="col-md-2">
                                    <img src="'.$img.'" class="w-100" alt="">
                                </div>
                                <div class="col-md-3 d-flex align-items-center">
                                    <p class="text-secondary">'.$product_name.'</p>
                                </div>
                                <div class="col-md-3 d-flex align-items-center">
                                    <input type="number" name="quantity" class="form-control text-center mb-2 mb-sm-0 update-this" data-id="'.$item_product_id.'" value="'.$quantity.'" min="1">
                                </div>
                                <div class="col-md-3 d-flex align-items-end flex-column justify-content-center">
                                    <p class="text-primary" style="font-size: 1rem;">'.$line_amount.'</p>
                                    <p class="text-secondary" style="font-size: 0.7rem;">'.$unit_price.' x '.$quantity.'</p>
                                </div>
                                <div class="col-md-1 d-flex align-items-center justify-content-end">
                                    <a href="javascript:void(0);" data-id="'.$item_id.'" class="text-danger delete-cart-item"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg></a>
                                </div>
                            </div>';
            }

            $cart_item_count = $cart_items->count();

            return response()->json([
                'items'=> $items,
                'cart_item_count' => $cart_item_count,
                'total'=> number_format($total, 2),
            ]);

        }
    }


    public function updateOrder(Request $request)
    {
        if($request->ajax()){

            $this_product_id = $request->id;
            $this_product_qty = $request->quantity;
            $temp_id = $request->order_id;


            $temp_items = SaleOrderDetails::where('sale_order_id', $temp_id)->where('product_id', $this_product_id)->get();
            foreach ( $temp_items as $item ){
                $data['quantity'] = $this_product_qty;
                $item->update($data);
            }


            $items = '';
            $total = 0;

            $cart_items = SaleOrderDetails::where('sale_order_id', $temp_id)->get();
            foreach ( $cart_items as $c ){

                $item_id = $c->id;
                $item_product_id = $c->product->id;
                $img = asset('storage/products/'. $c->product->image);
                $product_name = $c->product->product_name;
                $unit_price = $c->product->unit_price;
                $quantity = $c->quantity;
                $line_amount = $unit_price * $quantity;

                $total = $total + $line_amount;

                $unit_price = number_format($unit_price, 2);
                $line_amount = number_format($line_amount, 2);

                $items .= '<div class="row mb-3">
                                <div class="col-md-2">
                                    <img src="'.$img.'" class="w-100" alt="">
                                </div>
                                <div class="col-md-3 d-flex align-items-center">
                                    <p class="text-secondary">'.$product_name.'</p>
                                </div>
                                <div class="col-md-3 d-flex align-items-center">
                                    <input type="number" name="quantity" class="form-control text-center mb-2 mb-sm-0 update-this" data-id="'.$item_product_id.'" value="'.$quantity.'" min="1">
                                </div>
                                <div class="col-md-3 d-flex align-items-end flex-column justify-content-center">
                                    <p class="text-primary" style="font-size: 1rem;">'.$line_amount.'</p>
                                    <p class="text-secondary" style="font-size: 0.7rem;">'.$unit_price.' x '.$quantity.'</p>
                                </div>
                                <div class="col-md-1 d-flex align-items-center justify-content-end">
                                    <a href="javascript:void(0);" data-id="'.$item_id.'" class="text-danger delete-cart-item"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg></a>
                                </div>
                            </div>';
            }


            $cart_item_count = $cart_items->count();
            return response()->json([
                'cart_item_count' => $cart_item_count,
                'items'=> $items,
                'total'=> number_format($total, 2),
            ]);

        }
    }


    public function deleteOrderItem(Request $request)
    {
        if($request->ajax()){

            $item = TempCart::find($request->id);
            $item->delete();

            return response()->json([
                'success'=> 'Cart Item Deleted!',
            ]);

        }
    }
}
