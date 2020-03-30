@extends('layouts.welcome')
@section('content')
<style>
.set-image {
width:100%;
margin:auto;
}
.btn-register {
background:#f478c4;
color:#ffffff;
}
.set-login {
margin-top:5%;
}
</style>
    <div class="welcome overflow-hidden">
        <div class="container h-100 position-relative">
            <span class="position-absolute circle-1"></span>
            <span class="position-absolute circle-2"></span>
            <div class="row h-100">
                <div class="col-md-6 pt-5 d-none d-sm-block">
                    <?php
                        $home_background = setting('home_background');
                        $home_background = $home_background ? url($home_background) : url('assets/images/couple.png');
                    ?>
                    <img class="set-image" src="{!! $home_background !!}">
                </div>
                <div class="col-md-6">
                    <div class="row" class="set-login">
                        <div class="col-md-9 mx-auto pt-5">
                            @if(session()->has('fail_login'))
                            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                <strong>Warning!</strong> {!! session()->get('fail_login') !!}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                                {{ session()->forget('fail_login') }}
                            @endif
                            @if($errors->any())
                                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                        <ul class="mb-0">
                                        @foreach($errors->all() as $error)
                                            @foreach($error as $item)
                                                <li>{!! $item !!}</li>
                                            @endforeach
                                        @endforeach
                                        </ul>
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                            @endif
                            <form method="post" class="login_form" action="">
                                {!! csrf_field() !!}
                                <div class="form-group">
                                    <label>Username</label>
                                    <input class="form-control" type="text" required name="username">
                                </div>
                                <div class="form-group">
                                    <label>Password</label>
                                    <input class="form-control" type="password" required name="password">
                                </div>
                                <div class="form-group">
                                    <button class="btn btn-primary btn-block" type="submit">Login</button>
                                </div>
                            </form>
                            <p class="text-center mt-4 mb-4"><a class="btn btn-register btn-block" href="{!! route('register') !!}">Register</a></p>
                            @if(setting('social_login'))
                            <div class="row">
                                <div class="col-md-6">
                                    <a href="{!! route('loginfacebook') !!}" class="btn btn-block btn-facebook btn-sm mb-2"><i class="fab fa-facebook-f"></i> Login with Facebook</a>
                                </div>
                                <div class="col-md-6">
                                    <a href="{!! route('logintwitter') !!}" class="btn btn-block btn-twitter btn-sm mb-2"><i class="fab fa-twitter"></i> Login with Twitter</a>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
