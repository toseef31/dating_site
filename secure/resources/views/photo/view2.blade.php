<style>
.img-next {
  /* right: 32%; */
  right: -12%;
}
.img-prev {
  /* right: 32%; */
  left: -12%;
}
</style>
<div id="demo" class="carousel slide" data-ride="carousel">
  <!-- The slideshow -->
  <div class="carousel-inner">
    @foreach($photos as $photo)
    <div class="carousel-item" id="{{$photo->id}}">
      <div class="row position-relative">
          <span class="close-view-photo position-absolute">&times;</span>
          <div class="col-md-8">
            <?php
            $url = url()->full();
            $url2 = substr($url,7,9);
            if ($url2 == 'localhost') {
              if ($type == 'cover') {
                $photo_file = avatar($photo->avatar, $photo->gender);
                $photo_file = substr($photo_file,34);
                $photo_file ='http://localhost/dating/'.$photo_file;
              }else {
                $photo_file = $photo->file;
                $photo_file ='http://localhost/dating/'.$photo_file;
              }
            }else {
              if ($type == 'cover') {
                $photo_file = avatar($photo->avatar, $photo->gender);
              }else {
                $photo_file = $photo->file;
              }
              // dd($photo_file);
            }
             ?>
              <!-- <div class="full_photo d-flex align-items-center"><img src="{!! url($photo_file) !!}" style="width:100%;max-height: 630px;min-height:500px;"></div> -->
              <div class="full_photo d-flex align-items-center"><img src="{!! url($photo_file) !!}" style="width:100%;max-height: 570px;min-height:450px;"></div>
          </div>
          <div class="col-md-4 view-photo-right">
              <div class="content-photo">
                  <div class="user-info">
                      <div class="media">
                        <?php
                        if($type == 'cover') {
                          $avatar = avatar($photo->avatar, $photo->gender);
                          $username = $photo->username;
                          $firstname = $photo->firstname;
                          $lastname = $photo->lastname;
                          $user_id = $photo->id;
                          // print_r($username); die;
                        }else {
                          $avatar = avatar($photo->user->avatar, $photo->user->gender);
                          $username = $photo->user->username;
                          $firstname = $photo->user->firstname;
                          $lastname = $photo->user->lastname;
                          $user_id = $photo->user->id;
                        }
                        // dd($avatar);
                        $url = url()->full();
                        $url2 = substr($url,7,9);
                        if ($url2 == 'localhost') {
                          $avatar = substr($avatar,34);
                          $avatar ='http://localhost/dating/'.$avatar;
                          // dd($avatar);
                        }
                        // dd(auth()->user()->follows()->get()->pluck('id'));
                        // dd(in_array($user_id, collect(auth()->user()->follows()->get())->pluck('id')->all()));
                        ?>
                          <img src="{!! $avatar !!}">
                          <div class="media-body content-photo2">
                              <h3 class="mb-0"><a href="{!! route('profile',['username'=>$username]) !!}">{!! fullname($firstname, $lastname, $username) !!} </a></h3>
                              @if(!auth()->check() || auth()->user()->id != $user_id)
                                @if(auth()->check() && in_array($user_id, collect(auth()->user()->follows()->get())->pluck('id')->all()))
                                    <span data-id="{!! $user_id !!}" class="badge badge-primary btn-follow"><i class="fas fa-check"></i> Followed</span>
                                @else
                                    <span data-id="{!! $user_id !!}" class="badge badge-primary btn-follow">Follow</span>
                                @endif
                              @endif
                                @if($type != 'cover')
                                <p>
                                    {!! $photo->description !!}
                                </p>
                              @endif
                          </div>
                      </div>
                  </div>
                  <div class="comments">
                    @if($photo->comments()->count() >0)
                    <ul class="list-unstyled m-0 gallery_list">
                    @else
                      <ul class="list-unstyled m-0">
                    @endif
                        @if($type != 'cover')
                          @if($photo->comments()->count())
                              @foreach($photo->comments as $comment)
                                  @include('photo.comment')
                              @endforeach
                          @endif
                        @endif
                      </ul>
                  </div>
              </div>
              @if($type != 'cover')
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
              @endif

          </div>
      </div>
    </div>
    @endforeach
  </div>

  <!-- Left and right controls -->
  <a class="carousel-control-prev img-prev" href="#demo" data-slide="prev">
    <span class="btn-border"><span class="carousel-control-prev-icon"></span></span>
  </a>
  <a class="carousel-control-next img-next" href="#demo" data-slide="next">
    <span class="btn-border"><span class="carousel-control-next-icon"></span></span>
  </a>
</div>

<script>
$('.carousel').carousel({
    interval: false
});
$(document).ready(function () {
  var id = "{{$id}}";
  $("#"+id).addClass("active");
})


</script>
