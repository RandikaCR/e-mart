@extends('layouts.emart-app')

@section('page_title')
    Order | E-Mart marketplace
@endsection

@section('content')

    <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
        <div>
            <h4 class="mb-3 mb-md-0">Order Details</h4>
        </div>
        <div class="d-flex align-items-center flex-wrap text-nowrap">
            <a href="{{ route('orders.edit', $order->id) }}" class="btn btn-primary btn-icon-text mb-2 mb-md-0" style="margin-right: 10px;">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                Edit Order
            </a>
            <a href="{{ url('orders') }}" class="btn btn-primary btn-icon-text mb-2 mb-md-0">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-list"><line x1="8" y1="6" x2="21" y2="6"></line><line x1="8" y1="12" x2="21" y2="12"></line><line x1="8" y1="18" x2="21" y2="18"></line><line x1="3" y1="6" x2="3.01" y2="6"></line><line x1="3" y1="12" x2="3.01" y2="12"></line><line x1="3" y1="18" x2="3.01" y2="18"></line></svg>
                All Orders
            </a>
        </div>
    </div>

    <div class="row" id="orderWrapper">
        <div class="col-md-8 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Order Products</h6>
                    <div class="row mb-4">
                        <div class="col-md-1 mb-2 mb-sm-0 d-flex align-items-center">
                        </div>
                        <div class="col-md-5 d-flex align-items-center">
                            <p class="text-dark">Product Name</p>
                        </div>
                        <div class="col-md-2 d-flex align-items-center justify-content-end">
                            <p class="text-dark">Unit Price</p>
                        </div>
                        <div class="col-md-2 d-flex align-items-center justify-content-center">
                            <p class="text-dark">Qunatity</p>
                        </div>
                        <div class="col-md-2 d-flex align-items-center justify-content-end">
                            <p class="text-dark">Amount</p>
                        </div>
                    </div>
                    <hr>
                    @php
                    $order_total = 0;
                    @endphp
                    @foreach( $order->orderDetails as $od )
                    <div class="row mb-4">
                        <div class="col-md-1 mb-2 mb-sm-0 d-flex align-items-center">
                            <img class="img-fluid" src="{{ asset('/storage/products/'.$od->product->image) }}" alt="">
                        </div>
                        <div class="col-md-5 d-flex align-items-center">
                            <p class="text-dark">{{ $od->product->product_name }}</p>
                        </div>
                        <div class="col-md-2 d-flex align-items-center justify-content-end">
                            <p class="text-dark">{{ number_format($od->unit_price, 2) }}</p>
                        </div>
                        <div class="col-md-2 d-flex align-items-center justify-content-center">
                            <p class="text-dark">{{ $od->quantity }}</p>
                        </div>
                        <div class="col-md-2 d-flex align-items-center justify-content-end">
                            <p class="text-dark">{{ number_format($od->unit_price * $od->quantity, 2) }}</p>
                        </div>
                    </div>

                        @php
                            $line_total = $od->unit_price * $od->quantity;
                            $order_total = $order_total + $line_total;
                        @endphp
                    @endforeach
                    <hr>
                    <div class="row mb-4">
                        <div class="col-md-10 d-flex align-items-center">
                            <p class="text-dark" style="font-weight: bold;">Total</p>
                        </div>
                        <div class="col-md-2 d-flex align-items-center justify-content-end">
                            <p class="text-dark" style="font-weight: bold;">{{ number_format($order_total, 2) }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4 grid-margin stretch-card">
            <div class="card">
                <div class="card-body" style="min-height: 600px;">
                    <h6 class="card-title">Order Details</h6>
                    <div class="row align-items-end  mb-4">
                    </div>
                    <hr>
                    <div class="row mb-3">
                        <div class="col-md-5 d-flex align-items-center mb-2 mb-sm-0">
                            <p class="text-secondary">Order Status</p>
                        </div>
                        <div class="col-md-7 d-flex align-items-center mb-2 mb-sm-0">
                            <p class="text-dark"><span class="badge {{ $order->order_status()['label'] }}">{{ $order->order_status()['text'] }}</span></p>
                        </div>
                    </div>
                    <hr>
                    <div class="row mb-3">
                        <div class="col-md-5 d-flex align-items-center mb-2 mb-sm-0">
                            <p class="text-secondary">Order Date</p>
                        </div>
                        <div class="col-md-7 d-flex align-items-center mb-2 mb-sm-0">
                            <p class="text-dark">{{ date('d-m-Y h:i A', strtotime($order->order_date)) }}</p>
                        </div>
                    </div>
                    <hr>
                    <div class="row mb-3">
                        <div class="col-md-5 d-flex align-items-center mb-2 mb-sm-0">
                            <p class="text-secondary">Customer Name</p>
                        </div>
                        <div class="col-md-7 d-flex align-items-center mb-2 mb-sm-0">
                            <p class="text-dark">{{ $order->customer->customer_name }}</p>
                        </div>
                    </div>
                    <hr>
                    <div class="row mb-3">
                        <div class="col-md-5 d-flex align-items-center mb-2 mb-sm-0">
                            <p class="text-secondary">Customer Email</p>
                        </div>
                        <div class="col-md-7 d-flex align-items-center mb-2 mb-sm-0">
                            <p class="text-dark">{{ $order->customer->email }}</p>
                        </div>
                    </div>
                    <hr>
                    <div class="row mb-3">
                        <div class="col-md-5 d-flex align-items-center mb-2 mb-sm-0">
                            <p class="text-secondary">Customer Mobile</p>
                        </div>
                        <div class="col-md-7 d-flex align-items-center mb-2 mb-sm-0">
                            <p class="text-dark">{{ $order->customer->mobile }}</p>
                        </div>
                    </div>
                    <hr>

                </div>
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
            var wrapper = $('#orderWrapper');
        });
    </script>

@endsection


