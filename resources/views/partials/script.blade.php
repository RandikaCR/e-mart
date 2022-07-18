<!-- core:js -->
<script src="{{ asset('assets/vendors/core/core.js') }}"></script>
<!-- endinject -->

<script src="{{ asset('assets/vendors/sweetalert2/sweetalert2.min.js') }}"></script>
<script src="{{ asset('assets/vendors/jquery-toast-plugin-master/dist/jquery.toast.min.js') }}"></script>
<script src="{{ asset('assets/vendors/croppie/croppie.min.js') }}"></script>


<!-- inject:js -->
<script src="{{ asset('assets/vendors/feather-icons/feather.min.js') }}"></script>
<script src="{{ asset('assets/js/template.js') }}"></script>
<!-- endinject -->

<script src="{{ asset('assets/js/sweet-alert.js') }}"></script>

<script>
    $( document).ready( function() {

        $('.logout').on('click', function (e) {
            e.preventDefault();

            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger me-2'
                },
                buttonsStyling: false,
            });

            swalWithBootstrapButtons.fire({
                title: 'Are you sure?',
                text: "Your session will be cleared!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonClass: 'me-2',
                confirmButtonText: 'Yes, Log out!',
                cancelButtonText: 'No, cancel!',
                reverseButtons: true
            }).then((result) => {
                if (result.value) {

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    setTimeout(function () {
                        $.ajax({
                            url: "{{ url('/user/logout') }}",
                            method: 'post',
                            data: {
                                id: '1'
                            },
                            success: function(data){
                                swalWithBootstrapButtons.fire(
                                    'Logged Out!',
                                    'You have been successfully logged out!',
                                    'success'
                                );
                                setTimeout(function () {
                                    //location.reload();
                                    window.location.replace("{{ url('/login') }}");
                                }, 1000);
                            }
                        });
                    }, 1000);

                } else if (
                    // Read more about handling dismissals
                    result.dismiss === Swal.DismissReason.cancel
                ) {
                    swalWithBootstrapButtons.fire(
                        'Cancelled',
                        'Your session still on live',
                        'error'
                    );
                }
            });

        });

    });
</script>

@if(session()->has('success'))
    <script>
        $.toast({
            heading: 'Success!',
            text: '{{ session()->get('success') }}',
            position: 'top-right',
            loaderBg: '#ff6849',
            icon: 'success',
            hideAfter: 3500,
            stack: 6
        });
    </script>
@endif

@if(session()->has('error'))
    <script>
        $.toast({
            heading: 'Error!',
            text: '{{ session()->get('error') }}',
            position: 'top-right',
            loaderBg: '#ff6849',
            icon: 'error',
            hideAfter: 3500

        });
    </script>
@endif

<!-- Custom js for this page -->
@yield('script')
<!-- End custom js for this page -->

@yield('custom_script')


