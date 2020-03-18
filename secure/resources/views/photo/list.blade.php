@extends('layouts.photo')
@section('content')
    <div class="container-fluid main_container photos">
        {{--@if(!auth()->check())--}}
            @include('partials.sidebar')
            <div class="main">
                {{--@endif--}}
                <div class="top-photo pt-3 pb-3 pl-3">
                    <div class="media">
                        <img src="{!! avatar($user->avatar, $user->gender) !!}" class="mr-3 border rounded-circle w-25">
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
                    <p class="page-title mb-2 mt-5 pl-3">Lastest Photos</p>
                    @if($user->photos()->count())
                        <div class="row pl-3 mr-1">
                            @foreach($user->photos()->orderBy('created_at','DESC')->get()->take(16) as $photo)
                                <div class="col-md-3 col-6 ">
                                    <div data-id="{!! $photo->id !!}" data-url="{!! url($photo->file) !!}" class="photo-item view-photo border shadow" style="background-image: url('{!! url($photo->thumb) !!}')">
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
