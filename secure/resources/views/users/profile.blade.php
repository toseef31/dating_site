@extends('layouts.profile')
@section('javascript')
    <script>
        function showUserLocation(){
            var userlocation = {lat: {!! $user->lat !!}, lng: {!! $user->lng !!}};
            var map = new google.maps.Map(
                document.getElementById('usermap'), {zoom: 15, center: userlocation, zoomControl: false, mapTypeControl: false, scaleControl: false});
            // The marker, positioned at Uluru
            var icon = {
                url: '{!! avatar($user->avatar, $user->gender) !!}',
                size: new google.maps.Size(50, 50),
                origin: new google.maps.Point(0, 0),
                scaledSize: new google.maps.Size(50, 50),
                shape:{coords:[25,25,25],type:'circle'},
                optimized:false
            };
            var myoverlay = new google.maps.OverlayView();
            myoverlay.draw = function () {
                this.getPanes().markerLayer.id='markerLayer';
            };
            myoverlay.setMap(map);
            var marker = new google.maps.Marker({
                position: userlocation,
                map: map,
                title: '{!! fullname($user->firstname, $user->lastname, $user->username) !!}',
                icon: icon
            });
        }
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key={!! env('GOOGLE_PLACE_API','AIzaSyBjVRkL8MOLaVd-fjloQguTIQDLAAzA4w0') !!}&callback=showUserLocation" async defer></script>
@endsection
@section('content')

    <div class="profile">

        <div class="container-fluid main_container">
            {{--@if(!auth()->check())--}}
                @include('partials.sidebar')
                <div class="main">


            {{--@endif--}}
                    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm hidden-sm hidden-xs" id="profile-header">
                        <div class="container">
                            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
                                <span class="navbar-toggler-icon"></span>
                            </button>
                            <div class="collapse navbar-collapse">
                                <ul class="navbar-nav mr-auto">
                                    @if((auth()->check() && auth()->user()->id != $user->id) || !auth()->check())
                                        <li class="nav-item">
                                            <a class="nav-link" href="javascript:void(0)">
                                                <button data-id="{!! $user->id !!}" data-type="like" class="btn-love<?php echo auth()->check() && auth()->user()->likes()->where('id', $user->id)->first() && auth()->user()->likes()->where('id', $user->id)->first()->pivot->type == 'like' ? ' active': '';?>"><i class="fas fa-heart"></i></button>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="{!! $nextuser ? route('profile',['username'=>$nextuser->username]) : route('landing') !!}">
                                                <button class="btn-unlove"><i class="fas fa-times"></i></button>
                                            </a>
                                        </li>
                                    @endif
                                    <li class="nav-item">
                                        <p class="mb-1">
                                            <span class="text-uppercase font-weight-bold pr-3 bold" >{!! fullname($user->firstname, $user->lastname, $user->username) !!}</span>
                                            <span class="user-info">
                                    {!! Carbon\Carbon::parse($user->birthday)->age !!}yr {!! $user->gender == 1 ? 'Male' : 'Female' !!}
                                                | Seeking {!! $user->preference == 1 ? 'Male' : ($user->preference == 2 ? 'Female': 'Male, Female') !!}
                                </span>
                                        </p>
                                        <p class="user-address font-weight-bold mt-2"><i class="fas fa-map-marker-alt"></i> {!! fulladdress($user->address, $user->country) !!}</p>
                                    </li>
                                </ul>
                                @if((auth()->check() && auth()->user()->id != $user->id) || !auth()->check())
                                    <span class="navbar-text">
                        <a href="{!! route('chat',['id'=>$user->id]) !!}" class="btn btn-light btn-sm border rounded-pill">Chat&nbsp;&nbsp;&nbsp;<i class="fas fa-comment"></i></a>
                    </span>
                                @endif
                            </div>
                        </div>
                    </nav>

            @if($user->photos()->count() || (auth()->check() && auth()->user()->id == $user->id) )
                <p class="page-title text-uppercase mb-1 clearfix pl-4">
                    Public Photos
                    <a class="float-right" href="{!! route('userphoto',['username'=>$user->username]) !!}">View All</a>
                </p>
                <div class="row users-photo mb-3  pl-4 mr-1">
                    <?php
                    if((auth()->check() && auth()->user()->id == $user->id)){
                        $photos = $user->photos()->orderBy('updated_at','DESC')->get()->take(5);
                    }
                    else{
                        $photos = $user->photos()->orderBy('updated_at','DESC')->get()->take(6);
                    }
                    ?>
                    @foreach($photos as $photo)

                    <?php
                    $url = url()->full();
                    $url2 = substr($url,7,9);
                    if ($url2 == 'localhost') {
                      $cover = 'http://localhost/dating/'.$photo->thumb;
                      $photo_file ='http://localhost/dating/'.$photo->file;
                    }else {
                      $cover = $photo->thumb;
                      $photo_file = $photo->file;
                    }
                     ?>
                        <div class="col-md-2">
                            <!-- <div data-id="{!! $photo->id !!}" data-url="{!! url($photo->file) !!}" class="photo-item view-photo border" style="background-image: url('{!! url($photo->thumb) !!}')"> -->
                            <div data-id="{!! $photo->id !!}" data-url="{!! url($photo_file) !!}" class="photo-item view-photo border" style="background-image: url('{!! url($cover) !!}')">

                            </div>
                        </div>
                    @endforeach
                    @if((auth()->check() && auth()->user()->id == $user->id))
                        <div class="col-md-2 ">
                            <div class="photo-item add-photo">
                                <i class="fas fa-camera"></i>
                                <p>Add Photo</p>
                            </div>
                        </div>
                    @endif
                    <div class="modal fade" id="modalUpload" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Writing something</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="upload-progress progress">
                                        <div class="progress-bar bg-primary progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <form id="formUpload" action="{!! route('upload_photo') !!}" enctype="multipart/form-data" method="post">
                                        {!! csrf_field() !!}
                                        <input id="upload-photo" name="file" type="file" accept="image/*" class="d-none">
                                        <div class="form-group">
                                            <textarea class="form-control" placeholder="Writing something for photo" name="description" rows="3"></textarea>
                                        </div>
                                        <div class="form-group">
                                            <button class="btn btn-sm btn-primary btn-block" type="submit">Upload</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
                <p class="page-title text-uppercase mb-1 pl-4 ">Location</p>
                <div id="usermap" class="ml-4 mr-3"></div>
                <p class="page-title text-uppercase mb-1 mt-3 pl-4">About Me</p>
                <div id="user-about" class="text-muted pl-4">{!! $user->about !!}</div>
                <p class="page-title text-uppercase mb-1 mt-3 pl-4">Preference</p>
                <div id="user-preference" class="pl-4 mb-3">
                    @foreach($user->interests as $interest)
                        <a href="javascript:void(0)" class="user-interest">{!! $interest->text !!}</a>
                    @endforeach
                </div>
            @if(!auth()->check())
                </div>
            @endif
        </div>
    </div>
@endsection
