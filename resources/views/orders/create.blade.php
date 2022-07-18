@extends('layouts.emart-app')

@section('page_title')
    POS | E-Mart marketplace
@endsection

@section('content')

    <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
        <div>
            <h4 class="mb-3 mb-md-0">Create New Order</h4>
        </div>
        <div class="d-flex align-items-center flex-wrap text-nowrap">
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
                    <h6 class="card-title">All Products</h6>
                    <div class="row align-items-end mb-4">
                        <div class="col-md-6 mb-2 mb-sm-0">
                            <label for="filterProducts" class="form-label">Search Product</label>
                            <input type="text" class="form-control form-control-lg" id="filterProducts" name="search" placeholder="Product ID, Product Name, etc...">
                        </div>
                        <div class="col-md-6">
                            <a href="{{ url('orders/create') }}" class="btn btn-secondary me-2">Clear</a>
                        </div>
                    </div>
                    <hr>

                    <div class="row mb-3" id="products-area">
                        @foreach( $products as $pro )
                        <div class="col-12 col-sm-3 mb-4">
                            <div class="card">
                                <a href="javascript:void(0);" data-id="{{ $pro->id }}" class="add-this">
                                    <img src="{{ asset('storage/products/'.$pro->image) }}" class="card-img-top" alt="...">
                                </a>
                                <div class="card-body">
                                    <h5 class="card-title text-center">{{ $pro->product_name }}</h5>
                                    <p class="card-text mb-2 text-center">{{ number_format($pro->unit_price, 2) }}</p>
                                    <a href="javascript:void(0);" data-id="{{ $pro->id }}" class="btn btn-primary w-100 add-this">Add</a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4 grid-margin stretch-card">
            <form class="forms-sample" method="POST"  action="{{ route('orders.store') }}" enctype="multipart/form-data">
                @csrf
                @if($errors->any())
                    @foreach ($errors->all() as $error)
                        <div class="alert alert-danger">
                            {{$error}}
                        </div>
                    @endforeach
                @endif
                <div class="card">
                    <div class="card-body" style="min-height: 600px;">
                        <h6 class="card-title">Order Details</h6>
                        <div class="row align-items-end  mb-4">
                            <div class="col-md-12">
                                <label class="form-label">Select Customer</label>
                                <select class="js-example-basic-single form-select" name="customer_id" data-width="100%">
                                    @foreach($customers as $cust)
                                    <option value="{{ $cust->id }}">{{ $cust->customer_name.' - '.$cust->email.' - '.$cust->mobile }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <hr>
                        <div class="row mb-3">
                            <div class="col-md-8 d-flex align-items-center justify-content-between mb-2 mb-sm-0">
                                <p class="text-secondary">Order Total</p>
                                <h4 class="text-primary" id="order-total-area">{{ number_format($cart_total, 2) }}</h4>
                            </div>
                            <div class="col-md-4 d-flex justify-content-end mb-2 mb-sm-0">
                                <button type="submit" class="btn btn-primary me-2 place-order-btn" {{ ( $cart_item_count == 0 ) ? 'disabled' : '' }} >Place Order</button>
                            </div>
                        </div>
                        <hr>
                        <div class="row mb-3">
                            <div class="col-md-6 text-center">
                                <p class="text-dark" style="font-size: 0.8rem;">Product Name</p>
                            </div>
                            <div class="col-md-3 text-center">
                                <p class="text-dark" style="font-size: 0.8rem;">Quantity</p>
                            </div>
                            <div class="col-md-3 text-center">
                                <p class="text-dark" style="font-size: 0.8rem;">Amount</p>
                            </div>
                        </div>
                        <hr>
                        <div id="items-list">
                            @foreach($cart_items as $c)
                            <div class="row mb-3">
                                <div class="col-md-2">
                                    <img src="{{ asset('storage/products/'. $c->product->image) }}" class="w-100" alt="">
                                </div>
                                <div class="col-md-3 d-flex align-items-center">
                                    <p class="text-secondary">{{ $c->product->product_name }}</p>
                                </div>
                                <div class="col-md-3 d-flex align-items-center">
                                    <input type="number" name="quantity" class="form-control text-center mb-2 mb-sm-0 update-this" data-id="{{ $c->product->id }}" value="{{ $c->quantity }}" min="1">
                                </div>
                                <div class="col-md-3 d-flex align-items-end flex-column justify-content-center">
                                    <p class="text-primary" style="font-size: 1rem;">{{ number_format($c->product->unit_price * $c->quantity, 2) }}</p>
                                    <p class="text-secondary" style="font-size: 0.7rem;">{{ number_format($c->product->unit_price, 2) }} x {{ $c->quantity }}</p>
                                </div>
                                <div class="col-md-1 d-flex align-items-center justify-content-end">
                                    <a href="javascript:void(0);" data-id="{{ $c->id }}" class="text-danger delete-cart-item"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg></a>
                                </div>
                            </div>
                            @endforeach
                        </div>

                    </div>
                    <div class="card-footer d-flex justify-content-end">
                    </div>
                </div>
            </form>
        </div>
    </div> <!-- row -->


@endsection

@section('style')

@endsection

@section('custom_style')
@endsection

@section('script')
    <script src="{{ asset('assets/vendors/select2/select2.min.js') }}"></script>
    <script src="{{ asset('assets/js/select2.js') }}"></script>

@endsection

@section('custom_script')

    <script>
        $(document).ready(function () {
            var wrapper = $('#orderWrapper');

            $(wrapper).on('click', '.add-this', function (e) {
                e.preventDefault();

                var id = $(this).data('id');

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });


                $.ajax({
                    url: "{{ url('/orders/add-this-to-cart') }}",
                    type: "POST",
                    data: {"id":id},
                    success: function (data) {
                        $('#order-total-area').html(data.total);
                        $('#items-list').html(data.items);

                        $('.place-order-btn').removeAttr('disabled');

                        $.toast({
                            heading: 'Success!',
                            text: 'Cart updated!',
                            position: 'top-right',
                            loaderBg: '#ff6849',
                            icon: 'success',
                            hideAfter: 3500,
                            stack: 6
                        });
                    }
                });
            });

            $(wrapper).on('keyup change', '.update-this', function (e) {
                e.preventDefault();

                var id = $(this).data('id');
                var qty = $(this).val();

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });


                $.ajax({
                    url: "{{ url('/orders/update-this-to-cart') }}",
                    type: "POST",
                    data: {"id":id, "quantity":qty},
                    success: function (data) {
                        $('#order-total-area').html(data.total);
                        $('#items-list').html(data.items);

                        if( data.cart_item_count == 0 ){
                            $('.place-order-btn').attr('disabled');
                        }else{
                            $('.place-order-btn').removeAttr('disabled');
                        }

                        $.toast({
                            heading: 'Success!',
                            text: 'Cart updated!',
                            position: 'top-right',
                            loaderBg: '#ff6849',
                            icon: 'success',
                            hideAfter: 3500,
                            stack: 6
                        });
                    }
                });
            });

            $(wrapper).on('click', '.delete-cart-item', function (e) {
                e.preventDefault();

                var id = $(this).data('id');

                const custDeleteBtns = Swal.mixin({
                    customClass: {
                        confirmButton: 'btn btn-success',
                        cancelButton: 'btn btn-danger me-2'
                    },
                    buttonsStyling: false,
                });

                custDeleteBtns.fire({
                    title: 'Are you sure?',
                    text: "You want to delete this Item?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonClass: 'me-2',
                    confirmButtonText: 'Yes, Delete!',
                    cancelButtonText: 'No, cancel!',
                    reverseButtons: true
                }).then((result) => {
                    if (result.value) {

                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });

                        $.ajax({
                            url: "{{ url('/orders/delete-this-cart-item') }}",
                            method: 'post',
                            data: {
                                id: id
                            },
                            success: function(data){
                                custDeleteBtns.fire(
                                    'Deleted!',
                                    'Cart Item has been deleted!',
                                    'success'
                                );
                                setTimeout(function () {
                                    //location.reload();
                                    window.location.href = "{{ url('orders/create') }}";
                                }, 1000);
                            }
                        });

                    } else if (
                        // Read more about handling dismissals
                        result.dismiss === Swal.DismissReason.cancel
                    ) {
                        custDeleteBtns.fire(
                            'Cancelled',
                            'Cart Item not deleted!',
                            'error'
                        );
                    }
                });

            });


            $(wrapper).on('keyup change', '#filterProducts', function (e) {
                e.preventDefault();

                var keyword = $(this).val();

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });


                $.ajax({
                    url: "{{ url('/orders/products-filter') }}",
                    type: "POST",
                    data: {"keyword":keyword},
                    success: function (data) {
                        $('#products-area').html(data.products);
                    }
                });


            });


        });
    </script>

@endsection


