<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Happyness Admin! | </title>

    <base href="{{ asset('') }}">
    <!-- jQuery -->
    <script src="assets/vendors/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap -->
    <link href="assets/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="assets/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="assets/vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- Animate.css -->
    <link href="assets/vendors/animate.css/animate.min.css" rel="stylesheet">
    <!-- Custom Theme Style -->
    <link href="assets/build/css/custom.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/build/js/bootstrap-toastr/toastr.min.css">
</head>

<body style="background: white  ">
@yield('content')
{{--<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-switch/3.3.4/js/bootstrap-switch.min.js"></script>--}}
<script src="assets/build/js/bootstrap-toastr/toastr.min.js"></script>
<script type="text/javascript">
    toastr.options = {
        closeButton: true,
        debug: false,
        positionClass: "toast-bottom-right",
        onclick: null,
        showDuration: "1000",
        hideDuration: "1000",
        timeOut: "5000",
        extendedTimeOut: "1000",
        showEasing: "swing",
        hideEasing: "linear",
        showMethod: "fadeIn",
        hideMethod: "fadeOut"
    };
    @if (Session::has('error'))
        toastr['error']('{!! Session::get("error") !!}');
    @elseif(Session::has('success'))
        toastr['success']('{!! Session::get("success") !!}');
    @elseif(Session::has('warning'))
        toastr['warning']('{!! Session::get("warning") !!}');
    @endif
</script>
</body>
</html>
