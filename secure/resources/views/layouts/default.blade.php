<!DOCTYPE html>
<html>
<head>
    @include('partials.header')
    @yield('stylesheet')
</head>
<body>
<div class="landing">
    <div class="container">
        @include('partials.sidebar')
        <div class="main">
            @yield('content')

        </div>
    </div>
    @include('partials.footer')
</div>
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
