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
<style>
.abt-spc {
min-height:88px;
padding-top:10px;
padding-bottom:10px;
}
.padd-top-20 {
  padding-top:20px;
}
.padd-bottom-20 {
  padding-bottom:20px;
}
@media  (min-device-width: 1900px) and (max-device-width: 2000px) {
  .foo_container {
    margin-left: 16rem !important;
  }
}
@media  (min-device-width: 765px) and (max-device-width: 1025px) {
    .online-class
    {
        left:40% !important;
    }
}
@media  (max-device-width: 576px) {
    .online-class
    {
        left:10% !important;
    }
}

@media (min-device-width: 576px) and  (max-device-width: 760px) {
    .user-info {
        font-size: 0.75rem !important;
    }
    .online-class
    {
        left:55% !important;
    }
}
.online-class
{
    color: #03bf20;
position: relative;
top: 47%;
left: 30px;
font-weight: 600;
}
.online {
  position: absolute;
  left: 5%;
  color: #02e75c;
}

</style>
    <div class="landing">

        <div class="container-fluid main_container ">
            @include('partials.sidebar')
                <div class="main">

                  <div class="main-content">

                    <nav class="navbar navbar-expand navbar-expand-md navbar-expand-lg navbar-light bg-white shadow-sm " id="profile-header">
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
                                        <p class="mb-1 pl-4 padd-top-20">
                                            <span class="text-capitalize font-weight-bold pr-3 bold" >{!! fullname($user->firstname, $user->lastname, $user->username) !!}</span>
                                            <span class="user-info">Age <strong> {!! Carbon\Carbon::parse($user->birthday)->age !!}</strong>. &nbsp;  {!! $user->gender == 1 ? 'Male' : 'Female' !!}&nbsp; seeking&nbsp; {!! $user->preference == 1 ? 'Male' : ($user->preference == 2 ? 'Female': 'Male, Female') !!}
                                </span>
                                       @if($user->status == 'Online')
                                        <span class="online-class">Online Now</span>
                                        @endif
                                      </p>
                                        

                                    </li>
                                </ul>
                                @if((auth()->check() && auth()->user()->id != $user->id) || !auth()->check())
                                    <span class="navbar-text">
                        <a href="{!! route('chat',['id'=>$user->id]) !!}" class="btn btn-chatter btn-sm border rounded-pill">Chat&nbsp;&nbsp;&nbsp;<i class="fas fa-comment"></i></a>
                    </span>
                                @endif
                            </div>
                        </div>
                    </nav>
                    <?php
                    // @if($user->photos()->count() || (auth()->check() && auth()->user()->id == $user->id) )
                     ?>
                <p class="page-title text-capitalize mb-1 clearfix pl-4">
                    Public Photos
                    <a class="float-right push-right" href="{!! route('userphoto',['username'=>$user->username]) !!}">View All</a>
                </p>
                <div class="row users-photo mb-3  pl-4 mr-1">

                    <?php
                    if((auth()->check() && auth()->user()->id == $user->id)){
                        $photos = $user->photos()->orderBy('updated_at','DESC')->get()->take(4);
                    }
                    else{
                        $photos = $user->photos()->orderBy('updated_at','DESC')->get()->take(5);
                    }
                    ?>
                    <?php
                    $avatar = avatar($user->avatar, $user->gender);
                    // dd($user->id);
                    $avatar2 = substr($avatar,7,9);
                    if ($avatar2 == 'localhost') {
                        $avatar = substr($avatar,34);
                        $avatar ='http://localhost/dating/'.$avatar;
                    }

                    ?>
                        <div class="col-md-2 profile-ipad-img">
                            <div data-id="{!! $user->id !!}" data-url="{!! url($avatar) !!}" class="photo-item-cover view-photo border" style="background-image: url('{!! url($avatar) !!}')">
                              @if($user->status == 'Online')
                              <span class="online"><i class="fa fa-circle" aria-hidden="true"></i></span>
                              @endif
                            </div>
                        </div>

                    @foreach($photos as $photo)

                    <?php
                    $url = url()->full();
                    $url2 = substr($url,7,9);
                    // dd($photo->id);
                    if ($url2 == 'localhost') {
                      $cover = 'http://localhost/dating/'.$photo->thumb;
                      $photo_file ='http://localhost/dating/'.$photo->file;
                    }else {
                      $cover = $photo->thumb;
                      $photo_file = $photo->file;
                    }
                     ?>
                        <div class="col-md-2 profile-ipad-img">
                            <!-- <div data-id="{!! $photo->id !!}" data-url="{!! url($photo->file) !!}" class="photo-item view-photo border" style="background-image: url('{!! url($photo->thumb) !!}')"> -->
                            <div data-id="{!! $photo->id !!}" data-url="{!! url($photo_file) !!}" class="photo-item view-photo border" style="background-image: url('{!! url($cover) !!}')">

                            </div>
                        </div>
                    @endforeach
                    @if((auth()->check() && auth()->user()->id == $user->id))
                        <div class="col-md-2 profile-ipad-img">
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
                <?php
                // @endif
                 ?>
                <p class="page-title text-capitalize mb-1 mt-3 pl-4">About Me</p>
                <div id="user-about" class="text-muted pl-4 abt-spc">{!! $user->about !!}</div>
                <p class="page-title text-capitalize mb-1 pl-4 ">Location</p>
                 @if($user->address !=null && $user->country)
                                        <p class="user-address mb-1 pl-4 mt-2"><i class="fas fa-map-marker-alt"></i> {!! fulladdress($user->address, $user->country) !!} 
                                        </p>@endif
                <div id="usermap" class="ml-4 mr-3"></div>
                <p class="page-title text-capitalize mb-1 mt-3 pl-4">Interests</p>
                <div id="user-preference" class="pl-4 padd-bottom-20">
                    @foreach($user->interests as $interest)
                        <a href="javascript:void(0)" class="user-interest">{!! $interest->text !!}</a>
                    @endforeach
                </div>
              </div>

              @include('partials.footer')
                    <div class="modal" id="modalPhoto" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered  iphone-low-model" role="document">
                            <div class="modal-content">
                                <div class="modal-body p-0">
                                </div>
                            </div>
                        </div>
                    </div>

            @if(!auth()->check())
                </div>
            @endif
        </div>
</div>

    <!-- </div> -->
@endsection
