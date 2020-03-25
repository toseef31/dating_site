<nav class="navbar navbar-expand-md navbar-light bg-blue d-md-none d-lg-none hidden-sm"  id="profile-header-sm">
  <!-- <div class="bg-blue"> -->
    <button type="button" class="navbar-toggler nav-btn" data-toggle="collapse" data-target="#navbarCollapse">
      <span class="navbar-toggler-icon"></span>
    </button>
    <?php
    $logo = setting('website_logo');
    $logo = $logo ? url($logo) : url('assets/images/logo_white.png');
    ?>
    <a href="#" class="navbar-brand">
      <img src="{{$logo}}" height="28" alt="CoolBrand">
    </a>
  <!-- </div> -->
  <div class="collapse navbar-collapse" id="navbarCollapse">
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
      <a href="{!! route('profile',['username'=>$user->username]) !!}" class="nav-item nav-link">
        <div class="" style="display:-webkit-box;">
          <img src="{!! $avatar !!}" class="w-20 rounded-circle mb-2 nav-item nav-link">
          <span class="mbl-hdr-nm">{!! fullname($user->firstname, $user->lastname, $user->username) !!}</span>
        </div>
      </a>
      <a class="{!! Illuminate\Support\Facades\Route::is('landing')?'active':'' !!} nav-item nav-link" href="{!! route('landing') !!}">Browse <i class="fas fa-search" style="float: right;"></i></a>
      <a class="{!! Illuminate\Support\Facades\Route::is('messages') || Illuminate\Support\Facades\Route::is('message')?'active':'' !!} nav-item nav-link" href="{!! route('messages') !!}">Messages  <span class="badge badge-light">{!! $unread > 0 ? $unread: '' !!}</span><i class="fas fa-comments"  style="float: right;"></i></a>
      <a class="{!! Illuminate\Support\Facades\Route::is('video')?'active':'' !!} nav-item nav-link" href="">Video Chat <i class="fas fa-video"  style="float: right;"></i></a>
      <a class="{!! Illuminate\Support\Facades\Route::is('setting')?'active':'' !!} nav-item nav-link" href="{!! route('setting') !!}">Setting <i class="fas fa-cog" style="float: right;"></i></a>
        <a class="{!! Illuminate\Support\Facades\Route::is('Custome')?'active':'' !!} nav-item nav-link" href="{!! route('custome') !!}">Custome Page <i class="fa fa-file" style="float: right;"></i></a>
      <a class="nav-item nav-link" href="{!! route('logout') !!}">Logout <i class="fas fa-sign-out-alt" style="float: right;"></i></a>
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
