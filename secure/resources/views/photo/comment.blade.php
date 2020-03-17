<li>
    <div class="media">
      <?php
      $avatar = avatar($comment->user->avatar, $comment->user->gender);
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
            <h3 class="font-weight-bold"><a href="{!! route('profile',['username'=>$comment->user->username]) !!}">{!! fullname($comment->user->firstname, $comment->user->lastname, $comment->user->username) !!}</a></h3>
            <p>
                {!! $comment->comment !!}
            </p>
        </div>
    </div>
</li>
