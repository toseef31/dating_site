<!-- <div class="d-md-none " style="width: 100%;"> -->
<nav class="navbar  navbar-light bg-blue d-lg-none"  id="profile-header-sm">
    <!-- <div class="bg-blue"> -->
    <button type="button" class="navbar-toggler nav-btn" data-toggle="collapse" data-target="#navbarCollapse" style="background: #ffffff;">
        <span class="navbar-toggler-icon"></span>
    </button>
   <?php
    $logo = setting('website_logo');
    $logo = $logo ? url($logo) : url('assets/images/logo_white.png');
    ?>
    <?php
    $logo = setting('logo_second');
    $logo = $logo ? url($logo) : url('assets/images/logo_white.png');
    ?>
    <a href="#" class="navbar-brand">
      <img src="{{$logo}}" height="40" class="main-navbar-logo" alt="CoolBrand" style="min-height:40px;">
    </a>
    <!-- </div> -->
    <div class="collapse navbar-collapse"  id="navbarCollapse">
        <div class="navbar-nav">
            @if(auth()->check())
                <?php
                $user = auth()->user();
                $unread = $user->unread()->count();
                $avatar = avatar($user->avatar, $user->gender);
                // dd($avatar);
                $avatar2 = substr($avatar,7,9);
                if ($avatar2 == 'localhost') {
                    $avatar = substr($avatar,34);
                    $avatar ='http://localhost/dating/'.$avatar;
                }
                ?>
                <a href="{!! route('profile',['username'=>$user->username]) !!}" class="nav-item nav-link ">
                    <div class="" style="display:-webkit-box;">
                        <img src="{!! $avatar !!}" class="w-20 rounded-circle mb-2 nav-item nav-link" style="width: 20%">
                        <span class="mbl-hdr-nm">{!! fullname($user->firstname, $user->lastname, $user->username) !!}</span>
                    </div>
                </a>
                <a class="{!! Illuminate\Support\Facades\Route::is('adminhome')?'active':'' !!} nav-item nav-link" href="{!! route('adminhome') !!}">Dashboard <i class="fas fa-home float-right" style="padding-left:48px; margin-right: 50px;"></i></a>
                <a class="{!! Illuminate\Support\Facades\Route::is('adminsetting') || Illuminate\Support\Facades\Route::is('adminsetting')?'active':'' !!} nav-item nav-link" href="{!! route('adminsetting') !!}">Setting  <span class="badge badge-light ">{!! $unread > 0 ? $unread: '' !!}</span><i class="fas fa-cogs float-right"  style="padding-left:30px; margin-right: 50px;"></i></a>
                <a class="{!! Illuminate\Support\Facades\Route::is('admininterest')?'active':'' !!} nav-item nav-link" href="{!! route('admininterest') !!}">Interests <i class="fas fa-grin-hearts float-right"  style="padding-left:22px; margin-right: 50px;"></i></a>
                <a class="{!! Illuminate\Support\Facades\Route::is('adminusers')?'active':'' !!} nav-item nav-link" href="{!! route('adminusers') !!}">Manage AD <i class="fas fa-ad float-right" style="padding-left:50px; margin-right: 50px;"></i></a>
                    <a class="{!! Illuminate\Support\Facades\Route::is('adminusers')?'active':'' !!} nav-item nav-link" href="{!! route('adminusers') !!}">Manage Users <i class="fas fa-users float-right" style="padding-left:50px; margin-right: 50px;"></i></a>

                    <a class="{!! Illuminate\Support\Facades\Route::is('adminusers')?'active':'' !!} nav-item nav-link" href="{!! route('adminusers') !!}">Manage Languages <i class="fas fa-language float-right" style="padding-left:50px; margin-right: 50px;"></i></a>
                    <a class="{!! Illuminate\Support\Facades\Route::is('adminaddpage')?'active':'' !!} nav-item nav-link" href="{!! route('adminaddpage') !!}">Pages <i class="fas fa-file float-right" style="padding-left:50px; margin-right: 50px;"></i></a>
                    <a class="{!! Illuminate\Support\Facades\Route::is('adminlogout')?'active':'' !!} nav-item nav-link" href="{!! route('adminlogout') !!}">Logout <i class="fas fa-sign-out-alt float-right" style="padding-left:50px; margin-right: 50px;"></i></a>

            @else

                <a href="{{url('/register')}}" class="nav-item nav-link">Login</a>
        @endif
        <!-- <a href="#" class="nav-item nav-link active">Home</a>
      <a href="#" class="nav-item nav-link">Profile</a>
      <a href="#" class="nav-item nav-link">Messages</a>
      <a href="#" class="nav-item nav-link disabled" tabindex="-1">Reports</a> -->
        </div>
    </div>
</nav>
<!-- </div> -->
