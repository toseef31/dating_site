@extends('admin.layout')
@section('title')
    <title>Edit User</title>
@endsection
@section('content')
    <div class="users_section">
        <h2>Edit User</h2>
        @if($errors->any())
            <div class="alert alert-warning alert-dismissible fade show">
                <ul>
            @foreach($errors->all() as $error)
                @foreach($error as $item)
                    <li>{!! $item !!}</li>
                @endforeach
            @endforeach
                </ul>
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
            <div class="row">
                <div class="col-md-2">
                    <div class="user">
                        <span class="change-avatar"><i class="fas fa-camera"></i></span>
                        <span class="clear-avatar">&times;</span>
                        <?php
                        $avatar = avatar($user->avatar, $user->gender);
                        $age = Carbon\Carbon::parse($user->birthday)->age;
                        ?>
                        <div class="avatar-upload">
                            <input type="hidden" name="x" id="x">
                            <input type="hidden" name="y" id="y">
                            <input type="hidden" name="w" id="w">
                            <input type="hidden" name="h" id="h">
                        </div>
                        <div id="avatarPreview">
                            <img id="uploadPreview" src="{!! $avatar !!}">
                        </div>
                        <input type="file" name="avatar" style="display: none" id="uploadImage" accept="image/jpeg">
                        <p class="text-center text-primary">{!! ($user->ip)?$user->ip:'No IP' !!}</p>
                        <p class="age">&#64;{!! $user->username !!}</p>
                        <p class="age">{!! $age !!} - {!! countries($user->country) !!}</p>
                    </div>
                    <button class="btn btn-success btn-block mt-2">Save</button>
                </div>
                <div class="col-md-10">
                    <div class="card">
                        <div class="card-header">Public Info</div>
                        <div class="card-body">
                            <div class="form-group">
                                <label>Fullname</label>
                                <input class="form-control" name="fullname" value="{!! fullname($user->firstname, $user->lastname, $user->username) !!}">
                            </div>
                            <div class="form-group">
                                <label>Username</label>
                                <input class="form-control" name="username" value="{!! $user->username !!}">
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <input class="form-control" type="email" name="email" value="{!! $user->email !!}">
                            </div>
                            <div class="form-group">
                                <label>Birthday</label>
                                <div class="row">
                                    <div class="col-md-4">
                                        <select name="day" class="form-control">
                                            <option value="">Day</option>
                                            @for($i=1; $i< 32; $i++)
                                                <option<?php echo date('j', strtotime($user->birthday)) == $i?' selected':'';?> value="{!! strlen($i)==1?'0'.$i:$i !!}">{!! strlen($i)==1?'0'.$i:$i !!}</option>
                                            @endfor
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <select name="month" class="form-control">
                                            <option value="">Month</option>
                                            @foreach(months() as $key=>$val)
                                                <option<?php echo date('n', strtotime($user->birthday)) == $key+1?' selected':'';?> value="{!! strlen($key+1)==1?'0'.$key+1:$key+1 !!}">{!! $val !!}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <select name="year" class="form-control">
                                            <option value="">Year</option>
                                            @for($i=1920; $i <= date('Y'); $i++)
                                                <option<?php echo date('Y', strtotime($user->birthday)) == $i?' selected':'';?> value="{!! $i !!}">{!! $i !!}</option>
                                            @endfor
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Country</label>
                                <select class="form-control" name="country">
                                    <option value="">Select Country</option>
                                    @foreach(countries() as $key=>$val)
                                        <option<?php echo $user->country == $key?' selected':'';?> value="{!! $key !!}">{!! $val !!}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>About</label>
                                <textarea class="form-control" name="about">{!! $user->about !!}</textarea>
                            </div>
                            <div class="form-group">
                                <label>Status</label>
                                <select class="form-control" name="active">
                                    <option<?php echo $user->active?'':' selected'; ?> value="0">Deactivate</option>
                                    <option<?php echo $user->active?' selected':''; ?> value="1">Active</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="card mt-3">
                        <div class="card-header">Change Password</div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Password</label>
                                        <input class="form-control" type="password" name="password">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Confirm Password</label>
                                        <input class="form-control" type="password" name="password_confirm">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
@section('javascript')
    <script>
        var uploadedImageURL = '{!! $avatar !!}';
    </script>
@endsection
