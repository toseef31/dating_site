<!DOCTYPE html>
<html>
<head>
    @include('partials.header')
    @yield('stylesheet')
</head>
<body>
<div class="header text-center p-2">
    <?php
        $logo = setting('website_logo');
        $logo = $logo ? url($logo) : url('assets/images/logo.png');
    ?>
    <img src="{!! $logo !!}">
</div>
@yield('content')
@include('partials.footer')
<script>
    var ajax_url = '{!! route('ajax') !!}';
</script>
<script src="{!! url('assets/js/app.js') !!}"></script>
<script src="{!! url('assets/js/socket.js') !!}"></script>
<!-- <script src="http://localhost/dating/assets/js/app.js"></script>
<script src="http://localhost/dating/assets/js/socket.js"></script> -->
@yield('javascript')
</body>
</html>
