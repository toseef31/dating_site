<div class="row position-relative">
    <span class="close-view-photo position-absolute">&times;</span>
    <div class="col-md-8">
      <?php
      $url = url()->full();
      $url2 = substr($url,7,9);
      if ($url2 == 'localhost') {
        // $cover = 'http://localhost/dating/'.$photo->thumb;
        $photo_file ='http://localhost/dating/'.$photo->file;
      }else {
        // $cover = $photo->thumb;
        $photo_file = $photo->file;
      }
       ?>
        <div class="full_photo d-flex align-items-center"><img src="{!! url($photo_file) !!}" style="width:100%"></div>
    </div>
    <div class="col-md-4 view-photo-right">
        <div class="content-photo">
            <div class="user-info">
                <div class="media">
                  <?php
                  $avatar = avatar($photo->user->avatar, $photo->user->gender);
                  // dd($avatar);
                  $url = url()->full();
                  $url2 = substr($url,7,9);
                  if ($url2 == 'localhost') {
                    $avatar = substr($avatar,34);
                    $avatar ='http://localhost/dating/'.$avatar;
                  }
                  ?>
                    <img src="{!! $avatar !!}">
                    <div class="media-body">
                        <h3 class="mb-0"><a href="{!! route('profile',['username'=>$photo->user->username]) !!}">{!! fullname($photo->user->firstname, $photo->user->lastname, $photo->user->username) !!}</a></h3>
                        @if(auth()->check() && in_array($photo->user->id, collect(auth()->user()->follows()->get())->pluck('id')->all()))
                            <span data-id="{!! $photo->user->id !!}" class="badge badge-primary btn-follow"><i class="fas fa-check"></i> Followed</span>
                        @else
                            <span data-id="{!! $photo->user->id !!}" class="badge badge-primary btn-follow">Follow</span>
                        @endif
                        <p>
                            {!! $photo->description !!}
                        </p>
                    </div>
                </div>
            </div>
            <div class="comments">
                <ul class="list-unstyled m-0">
                    @if($photo->comments()->count())
                        @foreach($photo->comments as $comment)
                            @include('photo.comment')
                        @endforeach
                    @endif
                </ul>
            </div>
        </div>
        <div class="photo-action">
            <div class="like-photo clearfix">
                @if($photo->likes()->count() && auth()->check() && in_array(auth()->id(), collect($photo->likes()->get())->pluck('id')->all()))
                    <i class="fas fa-heart" data-id="{!! $photo->id !!}" id="love-photo"></i>
                @else
                    <i class="far fa-heart" data-id="{!! $photo->id !!}" id="love-photo"></i>
                @endif
                <span>{!! $photo->likes()->count()?$photo->likes()->count():'' !!}</span>
            </div>
            <textarea data-id="{!! $photo->id !!}" class="write-comment" placeholder="Comment on this photo"></textarea>
        </div>
    </div>
</div>
