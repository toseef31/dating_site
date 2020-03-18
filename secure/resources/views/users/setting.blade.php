@extends('layouts.page')
@section('javascript')
    <script src="https://maps.googleapis.com/maps/api/js?key={!! env('GOOGLE_PLACE_API','AIzaSyBjVRkL8MOLaVd-fjloQguTIQDLAAzA4w0') !!}&libraries=places&callback=initMap" async defer></script>
@endsection
@section('content')
<div class="user-setting mt-2 pl-3">
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible ">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    @if(session()->has('success_msg'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Success!</strong> {!! session()->get('success_msg') !!}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            {!! session()->forget('success_msg') !!}
        </div>
    @endif
    @if(session()->has('error_msg'))
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <strong>Warning!</strong> {!! session()->get('error_msg') !!}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            {!! session()->forget('error_msg') !!}
        </div>
    @endif
    <form action="" method="post" enctype="multipart/form-data">
        {!! csrf_field() !!}
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>First Name</label>
                    <input class="form-control second bg-white" name="firstname" value="{!! $user->firstname !!}">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Last Name</label>
                    <input class="form-control second bg-white" name="lastname" value="{!! $user->lastname !!}">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Email</label>
                    <input class="form-control second bg-white" readonly value="{!! $user->email !!}">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Age</label>
                    <div class="row">
                        <div class="col-md-4">
                            <select autocomplete="off" class="form-control second bg-white" name="day" required>
                                <option value="">Day</option>
                                @for($i=1;$i <32; $i++)
                                    <option{!!  (date('j', strtotime($user->birthday)) == $i) ? ' selected="selected"': '' !!} value="{!! strlen($i) == 1 ? '0'.$i:$i !!}" >{!! $i !!}</option>
                                @endfor
                            </select>
                            <i class="fa fa-chevron-down"></i>
                        </div>
                        <div class="col-md-4">
                            <select autocomplete="off" class="form-control second bg-white" name="month" required>
                                <option value="">Month</option>
                                @foreach(months() as $key=>$month)
                                    <option{!!  date('n', strtotime($user->birthday)) == $key+1 ? ' selected': '' !!} value="{!! strlen($key+1) == 1?'0'.($key+1):$key+1 !!}">{!! $month !!}</option>
                                @endforeach
                            </select>
                            <i class="fa fa-chevron-down"></i>
                        </div>
                        <div class="col-md-4">
                            <select autocomplete="off" class="form-control second bg-white" name="year" required>
                                <option value="">Year</option>
                                @for($i=date('Y')-10;$i >= 1920; $i--)
                                    <option{!! date('Y', strtotime($user->birthday)) == $i? ' selected':'' !!} value="{!! $i !!}">{!! $i !!}</option>
                                @endfor
                            </select>
                            <i class="fa fa-chevron-down"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Address</label>
                    <input id="register-address" class="form-control second bg-white" name="address" value="{!! $user->address !!}">
                    <input type="hidden" value="{!! $user->lat !!}" name="lat" id="register-lat">
                    <input type="hidden" value="{!! $user->lng !!}" name="lng" id="register-lng">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Country</label>
                    <select class="form-control second bg-white" name="country" required id="register-country">
                        <option value="0">Country</option>
                        @foreach(countries() as $key=>$val)
                            <option{!! ($user->country == $key)?' selected':'' !!} value="{!! $key !!}">{!! $val !!}</option>
                        @endforeach
                    </select>
                    <i class="fa fa-chevron-down"></i>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Username</label>
                    <input class="form-control second bg-white" name="username" value="{!! $user->username !!}">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Password</label>
                    <input class="form-control second bg-white" name="password" type="password">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Gender</label>
                    <select class="form-control second bg-white" name="gender" required>
                        <option value="1">Male</option>
                        <option value="2"{!! $user->gender === 2?' selected':'' !!}>Female</option>
                    </select>
                    <i class="fa fa-chevron-down"></i>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Preference</label>
                    <select class="form-control second bg-white" name="preference" required>
                        <option value="1">Male</option>
                        <option value="2"{!! $user->preference === 2?' selected':'' !!}>Female</option>
                        <option value="3"{!! $user->preference === 3?' selected':'' !!}>Male & Female</option>
                    </select>
                    <i class="fa fa-chevron-down"></i>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label>Avatar</label>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="input-group mb-3">
                                <div class="custom-file">
                                    <input accept="image/*" type="file" class="custom-file-input" name="avatar" id="register-avatar" aria-describedby="register-avatar">
                                    <label class="custom-file-label" for="register-avatar">Choose file</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="register-upload-avatar">
                                <input type="hidden" id="x" value="" name="x">
                                <input type="hidden" id="y" value="" name="y">
                                <input type="hidden" id="w" value="" name="w">
                                <input type="hidden" id="h" value="" name="h">
                                <span class="clear-avatar">&times;</span>
                                <img id="register-upload-avatar" src="{!! avatar($user->avatar, $user->gender) !!}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php
            $user_interests = collect($user->interests()->get())->pluck('id')->all();
            ?>
            <div class="col-md-12">
                <div class="form-group">
                    <label>Interests</label>
                    <input type="hidden" name="interests" value="{!! implode(',',$user_interests) !!}" id="register-interests-input" required>
                    <div class="row mr-1">
                        @foreach($interests as $interest)
                            <div data-id="{!! $interest->id !!}" class="interest-item shadow text-center{!! in_array($interest->id, $user_interests)?' active':'' !!}">
                                <span class="fas fa-check-circle"></span>
                                <i class="{!! $interest->icon !!}"></i>
                                {!! $interest->text !!}
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group mr-3">
                    <label>About Me</label>
                    <textarea rows="3" class="form-control bg-white">{!! $user->about !!}</textarea>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group text-center">
                    <button class="btn btn-primary" type="submit">Save Changes</button>
                </div>
            </div>
        </div>
    </form>
</div>
<script>
    var uploadedImageURL = '{!! avatar($user->avatar, $user->gender) !!}';
</script>
@endsection
