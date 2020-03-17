@extends('admin.layout')
@section('title')
    <title>Setting</title>
@endsection
@section('content')
    <?php
        $logo = setting('website_logo');
        $logo_second = setting('logo_second');
        $home_background = setting('home_background');
        $register_background = setting('register_background');
        $social_image = setting('social_image');
    ?>
    @if($errors->any())
        <div class="alert alert-warning alert-dismissible fade show">
            <ul>
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
    @if(session()->has('success_update'))
        <div class="alert alert-success alert-dismissible fade show">
            <strong>Success:</strong> {!! session()->get('success_update') !!}
            {!! session()->forget('success_update') !!}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    <form action="" method="post" enctype="multipart/form-data">
        {!! csrf_field() !!}
        <div class="row mb-3">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">General Setting</div>
                    <div class="card-body">
                        <div class="form-group">
                            <label>Logo</label>
                            <input type="file" name="logo" class="form-control-file">
                            @if($logo)
                                <img src="{!! url($logo) !!}" class="img-fluid">
                            @endif
                        </div>
                        <div class="form-group">
                            <label>Second Logo</label>
                            <input type="file" name="logo_second" class="form-control-file">
                            @if($logo_second)
                                <img src="{!! url($logo_second) !!}" class="img-fluid bg-secondary">
                            @endif
                        </div>
                        <div class="form-group">
                            <label>Website Name</label>
                            <input class="form-control" type="text" name="website_title" value="{!! setting('website_title') !!}">
                        </div>
                        <div class="form-group">
                            <label>Website Tagline</label>
                            <input class="form-control" type="text" name="website_tagline" value="{!! setting('website_tagline') !!}">
                        </div>
                        <div class="form-group">
                            <label>Website Description</label>
                            <input class="form-control" type="text" name="website_description" value="{!! setting('website_description') !!}">
                        </div>
                        <div class="form-group">
                            <label>Website Keywords</label>
                            <input class="form-control" type="text" name="website_keywords" value="{!! setting('website_keywords') !!}">
                        </div>
                        <div class="form-group">
                            <label>Social Default Image</label>
                            <input type="file" name="social_image" class="form-control-file">
                            @if($social_image)
                                <img src="{!! url($social_image) !!}" class="img-thumbnail w-50">
                            @endif
                        </div>
                        <div class="form-group">
                            <label>Analytics Code</label>
                            <textarea name="analytics_code" class="form-control">{!! setting('analytics_code') !!}</textarea>
                            <p class="helper"><i class="flaticon-info"></i> Paste your (Google or other system) analytics code.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">Users Setting</div>
                    <div class="card-body">
                        <div class="form-group">
                            <label>Home Background</label>
                            <input type="file" name="home_background" class="form-control-file">
                            @if($home_background)
                                <img src="{!! url($home_background) !!}" class="img-thumbnail w-50">
                            @endif
                        </div>
                        <div class="form-group">
                            <label>Register Background</label>
                            <input type="file" name="register_background" class="form-control-file">
                            @if($register_background)
                                <img src="{!! url($register_background) !!}" class="img-thumbnail w-50">
                            @endif
                        </div>
                        <div class="custom-control custom-checkbox">
                            <input<?php echo setting('active_captcha')?' checked':'';?> name="active_captcha" type="checkbox" class="custom-control-input" id="customCheck1">
                            <label class="custom-control-label" for="customCheck1">Active Captcha</label>
                            <p class="helper"><i class="flaticon-info"></i> If checked. the users will have fill google captcha to register.</p>
                        </div>
                        <div class="custom-control custom-checkbox">
                            <input<?php echo setting('user_timeline')?' checked':'';?> name="user_timeline" type="checkbox" class="custom-control-input" id="customCheck2">
                            <label class="custom-control-label" for="customCheck2">Active User Timeline</label>
                            <p class="helper"><i class="flaticon-info"></i> If checked, a timeline with the last actions of the user will be shown on profiles.</p>
                        </div>
                        <div class="form-group">
                            <label>Online Delay</label>
                            <input class="form-control" type="text" name="online_delay" value="{!! setting('online_delay') !!}">
                            <p class="helper"><i class="flaticon-info"></i> Delay before a user appear offline after no activity (in minutes).</p>
                        </div>
                        <div class="form-group">
                            <label>Minimum Age to Register</label>
                            <input class="form-control" type="number" name="min_age" value="{!! setting('min_age') !!}">
                            <p class="helper"><i class="flaticon-info"></i> Set zero for no limit.</p>
                        </div>
                        <div class="form-group">
                            <label>User photo upload limit</label>
                            <input class="form-control" type="number" name="min_upload" value="{!! setting('min_upload') !!}">
                            <p class="helper"><i class="flaticon-info"></i> Set zero for no limit.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group text-center">
            <button class="btn btn-info" type="submit"><i class="flaticon-save"></i> Save Changes</button>
        </div>
    </form>
@endsection