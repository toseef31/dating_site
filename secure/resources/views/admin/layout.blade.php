<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
<!--  <link rel="stylesheet" type="text/css" href="{!! url('assets/css/bootstrap.min.css') !!}">
    <link rel="stylesheet" type="text/css" href="{!! url('assets/css/fontawesome.min.css') !!}">
    <link rel="stylesheet" type="text/css" href="{!! url('assets/css/cropper.min.css') !!}">
    <link rel="stylesheet" type="text/css" href="{!! url('assets/css/admin.css') !!}">
    <link rel="stylesheet" type="text/css" href="{!! url('assets/summernote/summernote-bs4.min.css') !!}">
    <script src="{!! url('assets/plugins/chartjs.min.js') !!}"></script>
    <script src="{!! url('assets/demo/demo.js') !!}"></script>
    <script src="{!! url('assets/js/jquery.min.js') !!}"></script>
    <script src="{!! url('assets/js/popper.min.js') !!}"></script>
    <script src="{!! url('assets/js/bootstrap.min.js') !!}"></script>
    <script src="{!! url('assets/js/cropper.min.js') !!}"></script>
    <script src="{!! url('assets/summernote/summernote-bs4.min.js') !!}"></script> -->
     <link rel="stylesheet" type="text/css" href="http://localhost/dating/assets/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="http://localhost/dating/assets/css/fontawesome.min.css">
    <link rel="stylesheet" type="text/css" href="http://localhost/dating/assets/css/cropper.min.css">
    <link rel="stylesheet" type="text/css" href="http://localhost/dating/assets/css/admin.css">
    <link rel="stylesheet" type="text/css" href="http://localhost/dating/assets/summernote/summernote-bs4.min.css">
    <script src="http://localhost/dating/assets/plugins/chartjs.min.js"></script>
    <script src="http://localhost/dating/assets/demo/demo.js"></script>
    <script src="http://localhost/dating/assets/js/jquery.min.js"></script>
    <script src="http://localhost/dating/assets/js/popper.min.js"></script>
    <script src="http://localhost/dating/assets/js/bootstrap.min.js"></script>
    <script src="http://localhost/dating/assets/js/cropper.min.js"></script>
    <script src="http://localhost/dating/assets/summernote/summernote-bs4.min.js"></script>
    @yield('title')
</head>
<body>
<div class="wrapper">
    <div id="sidebar">
        <div class="admin">
            <?php
            $adminavatar = (!empty(auth()->user()->avatar))?url(auth()->user()->avatar):url('assets/images/'.auth()->user()->gender.'.jpg');
            ?>
            <img src="{!! $adminavatar !!}">
            &#64;{!! auth()->user()->username !!}
        </div>
        <ul class="list-unstyled components">
            <li<?php echo Illuminate\Support\Facades\Route::is('adminhome')?' class="active"':'';?>><a href="{!! route('adminhome') !!}"><i class="fas fa-home"></i> Dashboard</a></li>
            <li<?php echo Illuminate\Support\Facades\Route::is('adminsetting')?' class="active"':'';?>><a href="{!! route('adminsetting') !!}"><i class="fas fa-cogs"></i> Setting</a></li>
            <li<?php echo Illuminate\Support\Facades\Route::is('admininterest')?' class="active"':'';?>><a href="{!! route('admininterest') !!}"><i class="fas fa-grin-hearts"></i> Interests</a></li>
            <li<?php echo Illuminate\Support\Facades\Route::is('adminad')?' class="active"':'';?>><a href="{!! route('adminusers') !!}"><i class="fas fa-ad"></i> Manage AD</a></li>
            <li<?php echo Illuminate\Support\Facades\Route::is('adminusers') || Illuminate\Support\Facades\Route::is('adminedituser')?' class="active"':'';?>><a href="{!! route('adminusers') !!}"><i class="fas fa-users"></i> Manage Users</a></li>
            <li<?php echo Illuminate\Support\Facades\Route::is('adminlanguage')?' class="active"':'';?>><a href="{!! route('adminusers') !!}"><i class="fas fa-language"></i> Manage Languages</a></li>
            <li<?php echo Illuminate\Support\Facades\Route::is('adminpages') || Illuminate\Support\Facades\Route::is('adminaddpage')?' class="active"':'';?>><a href="{!! route('adminpages') !!}"><i class="fas fa-file"></i> Pages</a></li>
        </ul>
        <ul class="list-unstyled CTAs">
            <li>
                <a href="{!! url('/') !!}" class="article"><i class="fas fa-globe"></i> Visit Website</a>
                <a href="{!! route('adminlogout') !!}" class="download d-block d-sm-none"><i class="fas fa-sign-out-alt"></i> Logout</a>
            </li>
        </ul>
    </div>
    <div id="content">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">
                <button type="button" id="sidebarCollapse" class="btn btn-info">
                    <i class="fas fa-th-list"></i>
                </button>
                <a class="btn btn-danger text-white d-none d-sm-block" href="{!! route('adminlogout') !!}"><i class="fas fa-sign-out-alt"></i> Logout</a>
            </div>
        </nav>
        <div class="container-fluid">
            @yield('content')
        </div>
    </div>
</div>
<script>
var ajax_url = '{!! route('adminajax') !!}';
</script>
<script src="{!! url('assets/js/admin.js') !!}"></script>
<script>
  $(document).ready(function() {
    // Javascript method's body can be found in assets/assets-for-demo/js/demo.js
    demo.initChartsPages();
  });
</script>
@yield('javascript')
</body>
</html>
