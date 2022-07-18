<?php

namespace App\Http\Controllers;

use App\Models\Customers;
use Illuminate\Http\Request;

class CustomersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customers = Customers::orderBy('customer_name', 'ASC')->paginate(20);

        if ( isset($_GET['search']) ){

            $search = $_GET['search'];

            $customers = Customers::where( function($q) {
                $search = $_GET['search'];
                $q->where('id','=',$search)
                    ->orWhere('customer_name', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%')
                    ->orWhere('mobile', 'like', '%' . $search . '%');
            })
             ->orderBy('customer_name','ASC')
             ->paginate(20);

            $customers->appends(['search' => $search]);
        }

        return view('customers.index',['customers'=> $customers]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('customers.create');
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
            'customer_name' => ['required'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:customers'],
        ]);


        $customer = Customers::create([
            'customer_name' => $request->customer_name,
            'email' => $request->email,
            'mobile' => $request->mobile,
        ]);


        //flash message
        session()->flash('success', 'New Customer Created!');

        return redirect( route('customers.index') );
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
    public function edit(Customers $customer)
    {
        return view('customers.create', ['customer' => $customer]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Customers $customer)
    {
        $validatedData = $request->validate([
            'customer_name' => ['required'],
            'email' => 'required|email|max:255|unique:customers,email,'.$customer->id,
        ]);

        $data = $request->only([
            'customer_name',
            'email',
            'mobile',
        ]);


        //Update attributes
        $customer->update($data);

        //flash message
        session()->flash('success', 'Customer Updated!');

        return redirect( route('customers.index') );
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

            $customer = Customers::find($request->id);
            $customer->delete();

            return response()->json([
                'success'=> 'Customer Deleted!',
            ]);

        }
    }

}
