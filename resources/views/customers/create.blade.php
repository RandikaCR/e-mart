@extends('layouts.emart-app')

@section('page_title')
    Dashboard | E-Mart marketplace
@endsection

@section('content')

    <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
        <div>
            <h4 class="mb-3 mb-md-0">
                @if(isset($customer))
                    Edit Customer {{ $customer->customer_name }}
                @else
                    Add New Customer
                @endif
            </h4>
        </div>
        <div class="d-flex align-items-center flex-wrap text-nowrap">
            <a href="{{ url('customers') }}" class="btn btn-primary btn-icon-text mb-2 mb-md-0">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-list"><line x1="8" y1="6" x2="21" y2="6"></line><line x1="8" y1="12" x2="21" y2="12"></line><line x1="8" y1="18" x2="21" y2="18"></line><line x1="3" y1="6" x2="3.01" y2="6"></line><line x1="3" y1="12" x2="3.01" y2="12"></line><line x1="3" y1="18" x2="3.01" y2="18"></line></svg>
                All Customers
            </a>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-5 grid-margin stretch-card">
            <div class="card">
                <form class="forms-sample" method="POST"  action="{{ isset($customer) ? route('customers.update', $customer->id ) : route('customers.store') }}" enctype="multipart/form-data">
                    @csrf
                    @if(isset($customer))
                        @method('PUT')
                    @endif
                    <div class="card-body">
                        <h6 class="card-title">Customer Details</h6>
                        @if($errors->any())
                            @foreach ($errors->all() as $error)
                                <div class="alert alert-danger">
                                    {{$error}}
                                </div>
                            @endforeach
                        @endif
                        <div class="row mb-3">
                            <label for="name" class="col-sm-3 col-form-label">Customer Name</label>
                            <div class="col-sm-9">
                                <input type="text" name="customer_name" class="form-control" id="name" value="{{ isset($customer) ? $customer->customer_name : '' }}" placeholder="Enter here...">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="email" class="col-sm-3 col-form-label">Email</label>
                            <div class="col-sm-9">
                                <input type="email" name="email" class="form-control" id="email" autocomplete="off" placeholder="Enter here..."value="{{ isset($customer) ? $customer->email : '' }}" >
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="mobile" class="col-sm-3 col-form-label">Mobile</label>
                            <div class="col-sm-9">
                                <input type="text" name="mobile" class="form-control" id="mobile" placeholder="Enter here..."value="{{ isset($customer) ? $customer->mobile : '' }}" >
                            </div>
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary me-2">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div> <!-- row -->

@endsection

@section('style')

@endsection

@section('custom_style')
@endsection

@section('script')

@endsection

@section('custom_script')

    <script>
        $(document).ready(function () {

        });
    </script>

@endsection


