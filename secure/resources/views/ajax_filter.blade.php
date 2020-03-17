@if(count($users))
    <div class="row mb-3">
        @foreach($users as $user)
            <div class="col-md-3">
                <a href="{!! route('profile',['username'=>$user->username]) !!}">
                    <div class="user-item shadow-sm rounded effect" style="background-image: url('{!! avatar($user->avatar, $user->gender) !!}')">
                        <span class="photos"><i class="fas fa-camera"></i> {!! $user->photos()->count() !!}</span>
                        <span class="fullname">{!! fullname($user->firstname, $user->lastname, $user->username) !!}</span>
                        <span class="address">{!! fulladdress($user->address, $user->country) !!}</span>
                    </div>
                </a>
            </div>
        @endforeach
    </div>
@else
@endif
{!! $users->links() !!}
