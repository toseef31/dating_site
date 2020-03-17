@extends('layouts.photo')
@section('content')
    <div class="container photos">
        @if(!auth()->check())
            @include('partials.sidebar')
            <div class="main">
                @endif
                <div class="top-photo pt-3 pb-3">
                    <div class="media">
                      <?php
                      $avatar = avatar($user->avatar, $user->gender);
                      $avatar2 = substr($avatar,7,9);
                      if ($avatar2 == 'localhost') {
                        $avatar = substr($avatar,34);
                        $avatar ='http://localhost/dating/'.$avatar;
                      }
                       ?>
                        <img src="{!! $avatar !!}" class="mr-3 border rounded-circle w-25">
                        <div class="media-body pt-4">
                            <p class="font-weight-bold text-uppercase"><a href="{!! route('profile',['username'=>$user->username]) !!}">#{!! $user->username !!}</a></p>
                            <p>{!! $user->photos()->count() !!} photos</p>
                            @if(auth()->check() && in_array($user->id, collect(auth()->user()->follows()->get())->pluck('id')->all()))
                                <button class="btn btn-sm btn-primary font-weight-bold btn-follow" data-id="{!! $user->id !!}" style="padding-left: 30px!important;padding-right: 30px!important;"><i class="fas fa-check"></i>Followed</button>
                            @else
                                <button class="btn btn-sm btn-primary font-weight-bold btn-follow" data-id="{!! $user->id !!}" style="padding-left: 30px!important;padding-right: 30px!important;">Follow</button>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="main-photos">
                    <p class="page-title mb-2 mt-5">Lastest Photos</p>
                    @if($user->photos()->count())
                        <div class="row">
                            @foreach($user->photos()->orderBy('created_at','DESC')->get()->take(16) as $photo)
                            <?php
                            $url = url()->full();
                            $url2 = substr($url,7,9);
                            if ($url2 == 'localhost') {
                              $cover = 'http://localhost/dating/'.$photo->thumb;
                            }else {
                              $cover = $photo->thumb;
                            }
                             ?>
                                <div class="col-md-3">
                                    <div data-id="{!! $photo->id !!}" data-url="{!! url($photo->file) !!}" class="photo-item view-photo border shadow" style="background-image: url('{!! url($cover) !!}')">
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <hr>
                        <p class="text-center">
                            <button data-id="{!! $user->id !!}" data-page="1" class="load_more_photo btn btn-sm btn-primary" style="padding-left: 50px!important;padding-right: 50px!important;"><i class="fas fa-spinner fa-spin"></i> Load more</button>
                        </p>
                    @else
                    @endif
                </div>
            @if(!auth()->check())
            </div>
            @endif
    </div>
@endsection
