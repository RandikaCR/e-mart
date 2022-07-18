<?php

namespace App\Http\Controllers;

use App\Models\Products;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Products::orderBy('id', 'ASC')->paginate(20);

        if ( isset($_GET['search']) ){

            $search = $_GET['search'];

            $products = Products::where( function($q) {
                $search = $_GET['search'];
                $q->where('id','=',$search)
                    ->orWhere('product_name', 'like', '%' . $search . '%')
                    ->orWhere('unit_price', 'like', '%' . $search . '%');
            })
                ->orderBy('product_name','ASC')
                ->paginate(20);

            $products->appends(['search' => $search]);
        }


        return view('products.index',['products'=> $products]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('products.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'product_name' => ['required'],
            'unit_price' => ['required'],
        ]);


        $customer = Products::create([
            'product_name' => $request->product_name,
            'unit_price' => $request->unit_price,
            'image' => $request->image,
        ]);


        //flash message
        session()->flash('success', 'New Product Created!');

        return redirect( route('products.index') );
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
    public function edit(Products $product)
    {
        return view('products.create', ['product' => $product]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Products $product)
    {
        $validatedData = $request->validate([
            'product_name' => ['required'],
            'unit_price' => ['required'],
        ]);

        $data = $request->only([
            'product_name',
            'unit_price',
            'image',
        ]);


        //Update attributes
        $product->update($data);

        //flash message
        session()->flash('success', 'Product Updated!');

        return redirect( route('products.index') );
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


    public function delete(Request $request)
    {
        if($request->ajax()){

            $customer = Products::find($request->id);
            $customer->delete();

            return response()->json([
                'success'=> 'Customer Deleted!',
            ]);

        }
    }


    public function productImageUpload(Request $request)
    {
        if($request->ajax()){

            $image_data = $request->image;
            $image_array_1 = explode(";", $image_data);
            $image_array_2 = explode(",", $image_array_1[1]);
            $data = base64_decode($image_array_2[1]);
            $image_name = time() . '_temp.png';
            $upload_path = public_path('storage/products/' . $image_name);
            file_put_contents($upload_path, $data);

            if ( file_exists($upload_path)) {

                $file_name = time() . '.jpg';
                $file_name_with_path = public_path('storage/products/' . $file_name);
                $image = imagecreatefrompng($upload_path);
                imagejpeg($image, $file_name_with_path, 80);
                imagedestroy($image);

                unlink($upload_path);
                $status = 'Image Uploaded!';
            }


            return response()->json([
                'filename' =>  $file_name,
                'status' =>  $status
            ]);

        }
    }
}
