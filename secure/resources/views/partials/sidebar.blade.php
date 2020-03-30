
<div class="sidebar hidden-sm hidden-xs ">
    <?php
    $logo = setting('logo_second');
    $logo = $logo ? url($logo) : url('assets/images/logo_white.png');
    ?>
    <!-- <p class="text-center logo mb-4">
        <a href="{!! url('/') !!}"><img src="{!! $logo !!}" class="img-fluid"></a>
    </p> -->
        <a href="/" class="navbar-brand d-block text-center ml-2" style="min-height: 70px; overflow: hidden;" >
            <!-- <img src="https://demo.myclouddate.com/uploads/sites/n52fiuUta9o8rUR5seeb.png" height="28" alt="CoolBrand"> -->
            <img src="{{$logo}}" height="70" alt="CoolBrand" >
        </a>
    @if(auth()->check())
        <?php
        $user = auth()->user();
        $unread = $user->unread()->count();
        ?>
        <div class="p-3">
            <div class="text-center user-block text-white mb-3">
                <a href="{!! route('profile',['username'=>$user->username]) !!}"><img src="{!! avatar($user->avatar, $user->gender) !!}" class="w-50 rounded-circle mb-2"></a>
                <p class="font-weight-bold text-uppercase mb-0">{!! fullname($user->firstname, $user->lastname, $user->username) !!}</p>
                @if($user->address !=null && $user->country)
                <p style="font-size: 14px;"><i class="fas fa-map-marker-alt"></i> {!! fulladdress($user->address, $user->country) !!}</p>
                @endif
          </div>
        </div>
        <ul class="list-unstyled">
            <li><a class="{!! Illuminate\Support\Facades\Route::is('landing')?'active':'' !!}" href="{!! route('landing') !!}">Browse <i class="fas fa-search"></i></a></li>
            <li id="message-sidebar"><a class="{!! Illuminate\Support\Facades\Route::is('messages') || Illuminate\Support\Facades\Route::is('message')?'active':'' !!}" href="{!! route('messages') !!}">Messages  <span class="badge badge-light">{!! $unread > 0 ? $unread: '' !!}</span><i class="fas fa-comments"></i></a></li>
            <li><a class="{!! Illuminate\Support\Facades\Route::is('video')?'active':'' !!}" href="">Video Chat <i class="fas fa-video"></i></a></li>
            <li><a class="{!! Illuminate\Support\Facades\Route::is('setting')?'active':'' !!}" href="{!! route('setting') !!}">Setting <i class="fas fa-cog"></i></a></li>
            <!-- <li><a class="{!! Illuminate\Support\Facades\Route::is('Custome')?'active':'' !!}" href="{!! route('custome') !!}">Custome Page <i class="fa fa-file"></i></a></li> -->
            <li><a href="{!! route('logout') !!}">Logout <i class="fas fa-sign-out-alt"></i></a></li>
        </ul>
    @else
        <div class="text-center text-white p-3">
            <p class="text-uppercase font-weight-bold">Create an account</p>
            <form action="{!! route('quick_reg') !!}" method="post" id="formQuick">
                <div class="form-group">
                    <input class="form-control form-control-sm" name="username" required placeholder="Username" id="register-username">
                </div>
                <div class="form-group">
                    <input class="form-control form-control-sm" type="password" name="password" required placeholder="Password" id="quick-pass">
                </div>
                <div class="form-group">
                    <select class="form-control form-control-sm" name="gender" id="quick-gender">
                        <option value="">Gender</option>
                        <option value="1">Male</option>
                        <option value="2">Female</option>
                    </select>
                    <i class="fa fa-chevron-down"></i>
                </div>
                <div class="form-group">
                    <input class="form-control form-control-sm" name="email" required placeholder="Email" type="email" id="register-email">
                </div>
                <div class="form-group">
                    <select class="form-control form-control-sm" name="country" id="quick-country">
                        <option value="">Location</option>
                        @foreach(countries() as $key=>$country)
                            <option value="{!! $key !!}">{!! $country !!}</option>
                        @endforeach
                    </select>
                    <i class="fa fa-chevron-down"></i>
                </div>
                <div class="form-group">
                    <button class="btn btn-gray btn-block btn-md" type="submit">Sign Up</button>
                </div>
                <p>OR</p>
                <a href="{!! route('loginfacebook') !!}" class="btn btn-block btn-facebook btn-sm"><i class="fab fa-facebook-f"></i> Login with Facebook</a>
                <a href="{!! route('logintwitter') !!}" class="btn btn-block btn-twitter btn-sm"><i class="fab fa-facebook-f"></i> Login with Twitter</a>
            </form>
        </div>
    @endif
</div>
