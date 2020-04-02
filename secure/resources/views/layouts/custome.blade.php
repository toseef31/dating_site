<!DOCTYPE html>
<html>
<head>
  @include('partials.header')
    @include('partials.navbar')
    @yield('meta')
    @yield('stylesheet')
</head>
<body>

@yield('content')



@yield('javascript')

</body>
</html>
