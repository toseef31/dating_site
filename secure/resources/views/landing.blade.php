@extends('layouts.default')
@section('content')
<style>
  .online {
    left: 91% !important;
    top: 2%;
  }
  .online i{
    color: #0aec0a;
  }

  @media  (min-device-width: 1900px) and (max-device-width: 2000px) {
    .foo_container {
      margin-left: 16rem !important;
    }
  }

</style>
<div class="main-content">

    <div class="page-title text-capitalize">
        Search Filter
    </div>
    @if(session()->has('success_register'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Success!</strong> {!! session()->get('success_register') !!}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        {!! session()->forget('success_register') !!}
    </div>
    @endif
    <div class=" filter shadow-sm p-3 border bg-white">
        <form class="form-inline" action="" id="formFilter">

            <div class="filter col-12 col-md-4 ">
            <strong>I am a&nbsp;</strong>
            <div class="custom-control custom-radio custom-control-inline">
                <input{!! request()->get('gender') == 'male' || (auth()->check() && auth()->user()->gender == '1') || !auth()->check()?' checked':'' !!} type="radio" value="male" id="gender-filter-male" name="gender" class="custom-control-input">
                <label class="custom-control-label" for="gender-filter-male">Male</label>
            </div>
            <div class="custom-control custom-radio custom-control-inline">
                <input{!! request()->get('gender') == 'female' || auth()->check() && auth()->user()->gender == '2' ?' checked':'' !!} type="radio" value="female" id="gender-filter-female" name="gender" class="custom-control-input">
                <label class="custom-control-label" for="gender-filter-female">Female</label>
            </div>
            </div>


            <div class="filter col-12 col-md-4 ">
            <strong>Seeking a&nbsp;</strong>
            <div class="custom-control custom-checkbox custom-control-inline">
                <input{!! in_array(1,$default_preference)?' checked':'' !!} type="checkbox" value="male" id="seeking-filter-male" name="seeking[]" class="custom-control-input">
                <label class="custom-control-label" for="seeking-filter-male">Male</label>
            </div>
            <div class="custom-control custom-checkbox custom-control-inline">
                <input{!! in_array(2,$default_preference)?' checked':'' !!} type="checkbox" value="female" id="seeking-filter-female" name="seeking[]" class="custom-control-input">
                <label class="custom-control-label" for="seeking-filter-female">Female</label>
            </div>

            </div>

            <div class="filter col-12 col-md-4 ">
                <select class="search_search custom-select custom-select-sm w-50" name="country" id="filter-country">
                    <option value="">Country</option>
                    @foreach(countries() as $key=>$country)
                        <option{!! request()->get('country') == $key ? ' selected':'' !!} value="{!! $key !!}">{!! $country !!}</option>
                    @endforeach
                </select>
                <button class="search_btn btn btn-sm btn-primary ml-2">Search</button>

            </div>




        </form>
    </div>
    <div class="search-content mt-3 ml-2 mr-2 mb-3 col-xs-12">
        @if(count($users))
            <div class="row mb-3 ml-1 mr-1">
            @foreach($users as $user)
                <div class="col-md-3 col-sm-6 col-xs-12 ipad-col">
                    <a href="{!! route('profile',['username'=>$user->username]) !!}">
                        <div class="user-item shadow-sm rounded effect" style="background-image: url('{!! avatar($user->avatar, $user->gender) !!}') ">
                            <span class="photos"><i class="fas fa-camera"></i> {!! $user->photos()->count() !!}</span>
                            @if($user->status == 'Online')
                            <span class="online"><i class="fa fa-circle" aria-hidden="true"></i></span>
                            @endif
                            <span class="fullname">{!! fullname($user->firstname, $user->lastname, $user->username) !!}</span>
                            <span class="address">{!! fulladdress($user->address, $user->country) !!}</span>
                        </div>
                    </a>
                </div>
            @endforeach
            </div>
        @else
        @endif
        {!! $users->onEachSide(5)->links() !!}
    </div>
  </div>

  @include('partials.footer')
@endsection
