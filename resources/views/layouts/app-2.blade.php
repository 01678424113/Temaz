<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="assets/production/images/favicon.ico" type="image/ico"/>

    <title> {{env('NAME_SYSTEM')}}</title>

    {{--    <base href="{{ asset('') }}">--}}
    <base href="/">

    @include('layouts.partial.style')
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,100i,300,300i,400,400i,500,500i,700,700i,900,900i&amp;subset=cyrillic,cyrillic-ext,greek,greek-ext,latin-ext,vietnamese"
          rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet"/>
    @yield('style')
</head>

<body class="nav-md">
<div class="container body">
    <div class="main_container">
        <div class="col-md-3 left_col">
            <div class="left_col scroll-view">
                @include('layouts.partial.header')
                <br/>
                <!-- sidebar menu -->
            @include('layouts.partial.sidebar')
            <!-- /sidebar menu -->
            </div>
        </div>
        <!-- top navigation -->
    @include('layouts.partial.top-nav')
    <!-- /top navigation -->

        <!-- page content -->
        <div class="right_col" role="main">
            @yield('content')
        </div>
        <!-- /page content -->

        <!-- footer content -->
    @include('layouts.partial.footer')
    <!-- /footer content -->
    </div>
</div>

@include('layouts.partial.script')
<!-- iCheck -->
<link rel="stylesheet" href="/assets/vendors/iCheck/skins/square/blue.css">
<script src="/assets/vendors/iCheck/icheck.min.js"></script>
<script type="text/javascript" language="JavaScript" src="/js/functions.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<!-- ckeditor -->
<script src="https://cdn.ckeditor.com/4.5.11/full/ckeditor.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>

@yield('script')

<script>
    $(function () {
        $(".datepicker").datepicker().attr('autocomplete', 'off');
    });
    if ($('#input_editor').length) {
        CKEDITOR.replace('input_editor');
    }
    $(document).ready(function () {
        $('.select2').select2();
    });
</script>

</body>
</html>
