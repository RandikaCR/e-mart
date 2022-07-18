<!DOCTYPE html>
<html lang="en">
<head>
    @include('partials.head')
</head>
<body class="sidebar-dark">
<div class="main-wrapper">

    <!-- Sidebar -->
    @include('partials.navigation')
    <!-- Sidebar -->

    <div class="page-wrapper">

        <!-- header -->
        @include('partials.header')
        <!-- header -->

        <div class="page-content">

            @yield('content')

        </div>

        <!-- footer -->
        @include('partials.footer')
        <!-- footer -->

    </div>
</div>

@include('partials.script')

</body>
</html>
