<!DOCTYPE html>
<html>
<head>
  @include('partials.header')
  @include('partials.navbar')
    @yield('stylesheet')
</head>
<body>
<!-- <div class="header text-center p-2">
    <?php
    $logo = setting('website_logo');
    $logo = $logo ? url($logo) : url('assets/images/logo.png');
    ?>
    <a href="{!! route('home') !!}"><img src="{!! $logo !!}"></a>
</div> -->
@yield('content')

<script>
    var ajax_url = '{!! route('ajax') !!}';
    var socket_url = 'https://socket.myclouddate.com';
    var logged_id = {!! auth()->check() ? auth()->id() : 'false' !!};
</script>
<script src="{!! url('assets/js/app.js') !!}"></script>
<script src="{!! url('assets/js/socket.js') !!}"></script>
<!-- <script src="http://localhost/dating/assets/js/app.js"></script>
<script src="http://localhost/dating/assets/js/socket.js"></script> -->
@yield('javascript')
</body>
</html>
