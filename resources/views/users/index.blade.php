@extends('layouts.emart-app')

@section('page_title')
    All Users | E-Mart marketplace
@endsection

@section('content')

    <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
        <div>
            <h4 class="mb-3 mb-md-0">Users</h4>
        </div>
        <div class="d-flex align-items-center flex-wrap text-nowrap">
            {{--<a href="{{ route('users.create') }}" class="btn btn-primary btn-icon-text mb-2 mb-md-0">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                Add New User
            </a>--}}
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
                                <th>Username</th>
                                <th class="text-center">User Type</th>
                                <th class="text-center">Email Address</th>
                                <th class="text-center">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($users as $user)
                            <tr>
                                <td style="vertical-align: middle;">{{ $user->id }}</td>
                                <td style="vertical-align: middle;"><a href="{{ route('users.edit', $user->id) }}">{{ $user->username }}</a></td>
                                <td class="text-center" style="vertical-align: middle;">{{ $user->user_type->user_type }}</td>
                                <td class="text-center" style="vertical-align: middle;">{{ $user->email }}</td>
                                <td class="d-flex justify-content-end" style="vertical-align: middle;">
                                    @if( Auth::user()->id == $user->id )
                                    <a href="javascript:void(0);" class="btn btn-primary btn-icon btn-sm user-edit-warining">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                                    </a>
                                    @else
                                        <a href="{{ route('users.edit', $user->id) }}" class="btn btn-primary btn-icon btn-sm">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                                        </a>
                                    @endif
                                    @if( Auth::user()->id != $user->id )
                                    <a href="javascript:void(0);" class="btn btn-danger btn-icon btn-sm delete" data-id="{{ $user->id }}" style="margin-left: 10px;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                                    </a>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{--Paginaiton--}}
                    {!! $users->links('vendor.pagination.backend') !!}
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
                    text: "You want to delete this User?",
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
                            url: "{{ url('/users/delete') }}",
                            method: 'post',
                            data: {
                                id: id
                            },
                            success: function(data){
                                custDeleteBtns.fire(
                                    'Deleted!',
                                    'User has been deleted!',
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
                            'User not deleted!',
                            'error'
                        );
                    }
                });

            });


            $('.user-edit-warining').on('click', function (e) {
                e.preventDefault();

                const custDeleteBtns = Swal.mixin({
                    customClass: {
                        confirmButton: 'btn btn-success',
                        cancelButton: 'btn btn-danger me-2'
                    },
                    buttonsStyling: false,
                });

                custDeleteBtns.fire(
                    'Error',
                    'Unable to edit your own account!',
                    'error'
                );


            });
        });
    </script>

@endsection


