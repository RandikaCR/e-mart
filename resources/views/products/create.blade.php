@extends('layouts.emart-app')

@section('page_title')
    Products | E-Mart marketplace
@endsection

@section('content')

    <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
        <div>
            <h4 class="mb-3 mb-md-0">
                @if(isset($product))
                    Edit Product {{ $product->product_name }}
                @else
                    Add New Product
                @endif
            </h4>
        </div>
        <div class="d-flex align-items-center flex-wrap text-nowrap">
            <a href="{{ url('products') }}" class="btn btn-primary btn-icon-text mb-2 mb-md-0">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-list"><line x1="8" y1="6" x2="21" y2="6"></line><line x1="8" y1="12" x2="21" y2="12"></line><line x1="8" y1="18" x2="21" y2="18"></line><line x1="3" y1="6" x2="3.01" y2="6"></line><line x1="3" y1="12" x2="3.01" y2="12"></line><line x1="3" y1="18" x2="3.01" y2="18"></line></svg>
                All Customers
            </a>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-5 grid-margin stretch-card">
            <div class="card">
                <form class="forms-sample" method="POST"  action="{{ isset($product) ? route('products.update', $product->id ) : route('products.store') }}" enctype="multipart/form-data">
                    @csrf
                    @if(isset($product))
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
                            <label for="name" class="col-sm-3 col-form-label">Product Name</label>
                            <div class="col-sm-9">
                                <input type="text" name="product_name" class="form-control" id="name" value="{{ isset($product) ? $product->product_name : '' }}" placeholder="Enter here...">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="price" class="col-sm-3 col-form-label">Unit Price</label>
                            <div class="col-sm-9">
                                <input type="text" name="unit_price" class="form-control" id="price" autocomplete="off" placeholder="Enter here..."value="{{ isset($product) ? $product->unit_price : '' }}" >
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="d-block">Product Image</label>
                                    <label class="file">
                                        <input type="file" accept="image/*" class="btn btn-primary btn-sm" id="thumb_image" >
                                    </label>
                                </div>
                                <div class="row mt-4" style="">
                                    <div class="col-12" id="uploaded_thumb">
                                        <div id="thumb_image_demo" style=""></div>
                                        <input id="images-input-area" type="hidden" name="image"  value="{{ ( isset($product) ) ? $product->image : '' }}">
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <p class="text-success" id="image-status"></p>
                                    </div>
                                    <div class="col-md-4 text-right">
                                        <span class="btn btn-primary btn-sm thumb_crop">Apply</span>
                                    </div>
                                </div>

                            </div>
                            <div class="col-md-6 d-flex">
                                <div class="row" id="uploaded_image">
                                    @if(isset($product))
                                        <div class="col-md-12 mb-20 d-flex align-items-center justify-content-center">
                                            <div class="d-flex align-items-center justify-content-center">
                                                <img class="img-fluid img-bordered" src="{{ url('storage/products/'.$product->image) }}">
                                            </div>
                                        </div>
                                    @endif
                                </div>

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
            $image_thumb = $('#thumb_image_demo').croppie({
                enableExif: true,
                viewport: {
                    width:240,
                    height:240,
                    type:'square' //circle
                },
                boundary:{
                    width:300,
                    height:300
                }
            });

            $('#thumb_image').on('change', function(){
                var reader = new FileReader();
                reader.onload = function (event) {
                    $image_thumb.croppie('bind', {
                        url: event.target.result
                    });
                };
                reader.readAsDataURL(this.files[0]);
                $('#uploaded_thumb').show();
            });


            $('.thumb_crop').click(function(event){


                $image_thumb.croppie('result', {
                    type: 'canvas',
                    /*size: 'original'*/
                    size: {
                        width: 800,
                        height: 800
                    }
                }).then(function(response){

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    $.ajax({
                        url: "{{ url('/products/upload-product-image/') }}",
                        type: "POST",
                        data: {"image":response},
                        success: function (data) {
                            $('#images-input-area').val(data.filename);
                            $('#image-status').html(data.status);
                            var img = '<div class="col-md-12 mb-20"><div class="d-flex align-items-center justify-content-center"><img class="img-fluid img-bordered" src="{{ url( '/storage/products' ) }}/'+data.filename+'" ></div></div>';
                            $('#uploaded_image').append(img);
                        }
                    });

                })
            });
        });
    </script>


@endsection


