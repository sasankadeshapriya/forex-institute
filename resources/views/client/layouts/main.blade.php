<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
        <title>The Crt Crew &mdash; Dashboard</title>

        <!-- General CSS Files -->
        <link rel="stylesheet" href="{{ asset('backend/assets/modules/bootstrap/css/bootstrap.min.css') }}">

        <!-- CSS Libraries -->
        <link rel="stylesheet" href="{{ asset('backend/assets/modules/fontawesome/css/all.min.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/assets/modules/ionicons/css/ionicons.min.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/assets/modules/summernote/summernote-bs4.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/assets/modules/owlcarousel2/dist/assets/owl.carousel.min.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/assets/modules/owlcarousel2/dist/assets/owl.theme.default.min.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/assets/modules/chocolat/dist/css/chocolat.css') }}">

        <!-- Template CSS -->
        <link rel="stylesheet" href="{{ asset('backend/assets/css/style.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/assets/css/components.css') }}">

        <!-- Form Related CSS -->
        <link rel="stylesheet" href="{{ asset('backend/assets/modules/bootstrap-timepicker/css/bootstrap-timepicker.min.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/assets/modules/bootstrap-daterangepicker/daterangepicker.css') }}">

        <!-- Toastr CSS -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet" />

        @stack('styles')

        <!-- Start GA -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=UA-94034622-3"></script>

        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());

            gtag('config', 'UA-94034622-3');
        </script>
    </head>

    <body>
    <div id="app">
        <div class="main-wrapper main-wrapper-1">

            @include('client.layouts.navbar')
            @include('client.layouts.slidebar')

            @yield('content')

            @include('client.layouts.footer')

        </div>
    </div>

    <!-- General JS Scripts -->
    <script src="{{ asset('backend/assets/modules/jquery.min.js') }}"></script>
    <script src="{{ asset('backend/assets/modules/popper.js') }}"></script>
    <script src="{{ asset('backend/assets/modules/tooltip.js') }}"></script>
    <script src="{{ asset('backend/assets/modules/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('backend/assets/modules/nicescroll/jquery.nicescroll.min.js') }}"></script>
    <script src="{{ asset('backend/assets/modules/moment.min.js') }}"></script>
    <script src="{{ asset('backend/assets/js/stisla.js') }}"></script>

    <!-- JS Libraries -->
    <script src="{{ asset('backend/assets/modules/jquery.sparkline.min.js') }}"></script>
    <script src="{{ asset('backend/assets/modules/chart.min.js') }}"></script>
    <script src="{{ asset('backend/assets/modules/owlcarousel2/dist/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('backend/assets/modules/summernote/summernote-bs4.js') }}"></script>
    <script src="{{ asset('backend/assets/modules/chocolat/dist/js/jquery.chocolat.min.js') }}"></script>

    <!-- Page Specific JS File -->
    <script src="{{ asset('backend/assets/js/page/index.js') }}"></script>

    <!-- Template JS File -->
    <script src="{{ asset('backend/assets/js/scripts.js') }}"></script>
    <script src="{{ asset('backend/assets/js/custom.js') }}"></script>

    <!-- Form Related JS File -->
    <script src="{{ asset('backend/assets/js/page/forms-advanced-forms.js') }}"></script>
    <script src="{{ asset('backend/assets/modules/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
    <script src="{{ asset('backend/assets/modules/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js') }}"></script>

    <!-- Toastr JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>


    <!-- Toastr Notification -->
    @if(session('success'))
    <script>
        toastr.success("{{ session('success') }}");
    </script>
    @endif
    @if(session('error'))
    <script>
        toastr.error("{{ session('error') }}");
    </script>
    @endif

    @stack('scripts')
    </body>
</html>
