<div class="sidebar hidden-xs">
    <?php
    $logo = setting('logo_second');
    $logo = $logo ? url($logo) : url('assets/images/logo_white.png');
    ?>
    <!-- <p class="text-center logo mb-4">
        <a href="{!! url('/') !!}"><img src="{!! $logo !!}" class="img-fluid"></a>
    </p> -->
    @if(auth()->check())
        <?php
        $user = auth()->user();
        $unread = $user->unread()->count();
        ?>
        <div class="p-3">
            <div class="text-center user-block text-white mb-3">
                <a href="{!! route('profile',['username'=>$user->username]) !!}"><img src="{!! avatar($user->avatar, $user->gender) !!}" class="w-50 rounded-circle mb-2"></a>
                <p class="font-weight-bold text-uppercase mb-0">{!! fullname($user->firstname, $user->lastname, $user->username) !!}</p>
                <p style="font-size: 14px;"><i class="fas fa-map-marker-alt"></i> {!! fulladdress($user->address, $user->country) !!}</p>
            </div>
        </div>
        <ul class="list-unstyled">
            <li><a class="{!! Illuminate\Support\Facades\Route::is('landing')?'active':'' !!}" href="{!! route('landing') !!}">Browse <i class="fas fa-search"></i></a></li>
            <li id="message-sidebar"><a class="{!! Illuminate\Support\Facades\Route::is('messages') || Illuminate\Support\Facades\Route::is('message')?'active':'' !!}" href="{!! route('messages') !!}">Messages  <span class="badge badge-light">{!! $unread > 0 ? $unread: '' !!}</span><i class="fas fa-comments"></i></a></li>
            <li><a class="{!! Illuminate\Support\Facades\Route::is('video')?'active':'' !!}" href="">Video Chat <i class="fas fa-video"></i></a></li>
            <li><a class="{!! Illuminate\Support\Facades\Route::is('setting')?'active':'' !!}" href="{!! route('setting') !!}">Setting <i class="fas fa-cog"></i></a></li>
            <li><a href="{!! route('logout') !!}">Logout <i class="fas fa-sign-out-alt"></i></a></li>
        </ul>


    @endif
</div>
