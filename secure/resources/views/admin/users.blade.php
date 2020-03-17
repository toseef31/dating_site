@extends('admin.layout')
@section('title')
    <title>Users</title>
@endsection
@section('content')
    <div class="users_section">
        <h2>Manage Users</h2>
        <div class="row mb-4">
            @foreach($users as $user)
                <div class="col-md-2">
                    <div class="user effect<?php echo !$user->active?' suspended':'';?>">
                        @if(!$user->active)
                            <span>Deactivated</span>
                        @endif
                        <?php
                        $avatar = avatar($user->avatar, $user->gender);
                        $age = Carbon\Carbon::parse($user->birthday)->age;
                        ?>
                        <a target="_blank" href="{!! route('profile',['username'=>$user->username]) !!}"><img src="{!! $avatar !!}"></a>
                        <p class="text-center text-primary">{!! ($user->ip)?$user->ip:'No IP' !!}</p>
                        <p class="age">&#64;{!! $user->username !!}</p>
                        <p class="age">{!! $age !!} - {!! countries($user->country) !!}</p>
                        <div class="btn-group btn-block" role="group" aria-label="Basic example">
                            @if(!$user->is_admin)
                            <a onclick="return confirm('Are you sure?')" type="button" class="btn btn-danger" href="{!! route('admindeleteuser',['id'=>$user->id]) !!}"><i class="fas fa-trash"></i> Delete</a>
                            @endif
                            <a type="button" class="btn btn-info" href="{!! route('adminedituser',['id'=>$user->id]) !!}"><i class="fas fa-edit"></i> Edit</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        {!! $pages !!}
    </div>
@endsection
