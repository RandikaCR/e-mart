@extends('layouts.emart-app')

@section('page_title')
    All Customers | E-Mart marketplace
@endsection

@section('content')

    <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
        <div>
            <h4 class="mb-3 mb-md-0">Customers</h4>
        </div>
        <div class="d-flex align-items-center flex-wrap text-nowrap">
            <a href="{{ route('customers.create') }}" class="btn btn-primary btn-icon-text mb-2 mb-md-0">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                Add New Customer
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <form>
                        <div class="row align-items-end">
                            <div class="col-md-6">
                                <label for="colFormLabelLg" class="form-label">Search</label>
                                <input type="text" class="form-control form-control-lg" id="colFormLabelLg" name="search" placeholder="Name, email, mobile etc...">
                            </div>
                            <div class="col-md-6">
                                <button type="submit" class="btn btn-primary me-2">Search</button>
                                <a href="{{ url('customers') }}" class="btn btn-secondary me-2">Clear</a>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Customer Name</th>
                                <th class="text-center">Email Address</th>
                                <th class="text-center">Mobile</th>
                                <th class="text-center">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($customers as $customer)
                            <tr>
                                <td style="vertical-align: middle;">{{ $customer->id }}</td>
                                <td style="vertical-align: middle;"><a href="{{ route('customers.edit', $customer->id) }}">{{ $customer->customer_name }}</a></td>
                                <td class="text-center" style="vertical-align: middle;">{{ $customer->email }}</td>
                                <td class="text-center" style="vertical-align: middle;">{{ $customer->mobile }}</td>
                                <td class="d-flex justify-content-end" style="vertical-align: middle;">
                                    <a href="{{ route('customers.edit', $customer->id) }}" class="btn btn-primary btn-icon btn-sm" style="margin-right: 10px;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                                    </a>
                                    <a href="javascript:void(0);" class="btn btn-danger btn-icon btn-sm delete" data-id="{{ $customer->id }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{--Paginaiton--}}
                    {!! $customers->links('vendor.pagination.backend') !!}
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
            $('.delete').on('click', function (e) {
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
                    text: "You want to delete this Customer?",
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
                            url: "{{ url('/customers/delete') }}",
                            method: 'post',
                            data: {
                                id: id
                            },
                            success: function(data){
                                custDeleteBtns.fire(
                                    'Deleted!',
                                    'Customer has been deleted!',
                                    'success'
                                );
                                setTimeout(function () {
                                    location.reload();
                                }, 1000);
                            }
                        });

                    } else if (
                        // Read more about handling dismissals
                        result.dismiss === Swal.DismissReason.cancel
                    ) {
                        custDeleteBtns.fire(
                            'Cancelled',
                            'Customer not deleted!',
                            'error'
                        );
                    }
                });

            });
        });
    </script>

@endsection


