@extends('layouts.welcome')
@section('stylesheet')
    <?php
    $register_background = setting('register_background');
    $register_background = $register_background ? url($register_background) : url('assets/images/bg.jpg');
    ?>
    <style>
        .register{
            background-image: url("{!! $register_background !!}");
            background-repeat: no-repeat;
            background-position: top left;
        }
    </style>
@endsection
@section('javascript')
    <script src="https://maps.googleapis.com/maps/api/js?key={!! env('GOOGLE_PLACE_API','AIzaSyBjVRkL8MOLaVd-fjloQguTIQDLAAzA4w0') !!}&libraries=places&callback=initMap" async defer></script>
@endsection
@section('content')
    <div class="register">
        <div class="container h-100">
            <div class="row">
                <div class="col-md-9 mx-auto mt-5 ">
                    <div class="tab-register">
                        <ul class="nav nav-tabs nav-fill" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="account-tab" data-toggle="tab" href="#register-account" role="tab" aria-controls="account" aria-selected="true">Account</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="age-tab" data-toggle="tab" href="#register-age" role="tab" aria-controls="age" aria-selected="false">Age</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="interest-tab" data-toggle="tab" href="#register-interests" role="tab" aria-controls="interests" aria-selected="false">Interests</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="about-tab" data-toggle="tab" href="#register-about" role="tab" aria-controls="about" aria-selected="false">About</a>
                            </li>
                        </ul>
                        <form action="" method="post" enctype="multipart/form-data" id="formRegister">
                            {!! csrf_field() !!}
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade show active p-5" id="register-account" role="tabpanel" aria-labelledby="home-tab">
                                    <div class="form-group">
                                        <label>Username</label>
                                        <input class="form-control second bg-mute" name="username" id="register-username">
                                    </div>
                                    <div class="form-group">
                                        <label>Email</label>
                                        <input class="form-control second bg-mute" name="email" type="email" id="register-email">
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Password</label>
                                                <input class="form-control second bg-mute" name="password" type="password" id="register-password" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Confirm Password</label>
                                                <input class="form-control second bg-mute" name="password_confirmation" type="password" id="register-password-confirm" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Gender</label>
                                                <select class="form-control second bg-mute" name="gender" id="register-gender" required>
                                                    <option value="1">Male</option>
                                                    <option value="2">Female</option>
                                                </select>
                                                <i class="fa fa-chevron-down"></i>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Preference</label>
                                                <select class="form-control second bg-mute" name="preference" id="register-preference" required>
                                                    <option value="1">Male</option>
                                                    <option value="2">Female</option>
                                                    <option value="3">Male & Female</option>
                                                </select>
                                                <i class="fa fa-chevron-down"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-md-6 mx-auto">
                                            <div class="form-group">
                                                <button type="button" class="btn btn-primary btn-block btn-age">Next</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade p-5" id="register-age" role="tabpanel" aria-labelledby="profile-tab">
                                    <div class="form-group">
                                        <label>Choose Age</label>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <select class="form-control second bg-mute" name="day" id="register-day" required>
                                                    <option value="">Day</option>
                                                    @for($i=1;$i <32; $i++)
                                                        <option value="{!! strlen($i) == 1 ? '0'.$i:$i !!}">{!! $i !!}</option>
                                                    @endfor
                                                </select>
                                                <i class="fa fa-chevron-down"></i>
                                            </div>
                                            <div class="col-md-4">
                                                <select class="form-control second bg-mute" name="month" id="register-month" required>
                                                    <option value="">Month</option>
                                                    @foreach(months() as $key=>$month)
                                                        <option value="{!! strlen($key+1) == 1?'0'.($key+1):$key+1 !!}">{!! $month !!}</option>
                                                    @endforeach
                                                </select>
                                                <i class="fa fa-chevron-down"></i>
                                            </div>
                                            <div class="col-md-4">
                                                <select class="form-control second bg-mute" name="year" id="register-year" required>
                                                    <option value="">Year</option>
                                                    @for($i=date('Y')-10;$i >= 1920; $i--)
                                                        <option value="{!! $i !!}">{!! $i !!}</option>
                                                    @endfor
                                                </select>
                                                <i class="fa fa-chevron-down"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Address</label>
                                        <input class="form-control second bg-mute" name="address" id="register-address">
                                        <input type="hidden" value="{!! $geoip['lat'] !!}" name="lat" id="register-lat">
                                        <input type="hidden" value="{!! $geoip['lng'] !!}" name="lng" id="register-lng">
                                    </div>
                                    <div class="form-group">
                                        <label>Country</label>
                                        <select class="form-control second bg-mute" name="country" id="register-country" required>
                                            <option value="0">Country</option>
                                            @foreach(countries() as $key=>$val)
                                                <option{!! ($geoip['iso_code'] == $key)?' selected':'' !!} value="{!! $key !!}">{!! $val !!}</option>
                                            @endforeach
                                        </select>
                                        <i class="fa fa-chevron-down"></i>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-md-6 mx-auto">
                                            <div class="form-group">
                                                <button type="button" class="btn btn-primary btn-block btn-interests">Next</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade p-5" id="register-interests" role="tabpanel" aria-labelledby="contact-tab">
                                    <div class="form-group">
                                        <label>Your interests</label>
                                        <input type="hidden" name="interests" value="" id="register-interests-input" required>
                                        <div class="row">
                                            @foreach($interests as $interest)
                                                <div data-id="{!! $interest->id !!}" class="interest-item shadow text-center">
                                                    <span class="fas fa-check-circle"></span>
                                                    <i class="{!! $interest->icon !!}"></i>
                                                    {!! $interest->text !!}
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-md-6 mx-auto">
                                            <div class="form-group">
                                                <button type="button" class="btn btn-primary btn-block btn-about">Next</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade p-5" id="register-about" role="tabpanel" aria-labelledby="contact-tab">
                                    <div class="row">
                                        <div class="col-md-8 d-flex align-items-center">
                                            <div class="form-group">
                                                <label>Upload Profile Photo</label>
                                                <div class="input-group mb-3">
                                                    <div class="custom-file">
                                                        <input accept="image/*" type="file" class="custom-file-input" name="avatar" id="register-avatar" aria-describedby="register-avatar">
                                                        <label class="custom-file-label" for="register-avatar">Choose file</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="register-upload-avatar">
                                                <input type="hidden" id="x" value="" name="x">
                                                <input type="hidden" id="y" value="" name="y">
                                                <input type="hidden" id="w" value="" name="w">
                                                <input type="hidden" id="h" value="" name="h">
                                                <span class="clear-avatar">&times;</span>
                                                <img id="register-upload-avatar" src="{!! url('assets/images/1.jpg') !!}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>About Me</label>
                                        <textarea class="form-control second bg-mute" rows="6" name="about"></textarea>
                                        <p class="font-weight-bold mb-0 mt-3">Please include important keywords example. </p>
                                        <p class="helper">SHY, OUTGOING, SPONTANEOUS, FUN, LOVE TO TRAVEL or HOMEBODY etc.</p>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-md-6 mx-auto">
                                            <div class="form-group">
                                                <button class="btn btn-primary btn-block" type="submit">Submit</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        var uploadedImageURL = '{!! url('assets/images/1.jpg') !!}';
    </script>
@endsection
