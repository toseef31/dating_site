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
{!! $users->links() !!}
