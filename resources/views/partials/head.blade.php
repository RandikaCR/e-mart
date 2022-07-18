<meta charset="UTF-8">
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<meta name="description" content="emart marketplace">
<meta name="author" content="Randika De Aliws">
<meta name="keywords" content="">

<title>@yield('page_title')</title>
<link rel="shortcut icon" href="{{ asset('assets/images/favicon.png') }}" />
<!-- Fonts -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">
<!-- End fonts -->


<!-- core:css -->
<link rel="stylesheet" href="{{ asset('assets/vendors/core/core.css') }}">
<!-- endinject -->

<link rel="stylesheet" href="{{ asset('assets/vendors/sweetalert2/sweetalert2.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/vendors/jquery-toast-plugin-master/dist/jquery.toast.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/vendors/croppie/croppie.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/vendors/select2/select2.min.css') }}">

<!-- inject:css -->
<link rel="stylesheet" href="{{ asset('assets/fonts/feather-font/css/iconfont.css') }}">
<link rel="stylesheet" href="{{ asset('assets/vendors/flag-icon-css/css/flag-icon.min.css') }}">
<!-- endinject -->

<!-- Layout styles -->
<link rel="stylesheet" href="{{ asset('assets/css/demo1/style.css') }}">
<!-- End layout styles -->

<!-- Plugin css for this page -->
@yield('style')
<!-- End plugin css for this page -->



@yield('custom_style')
