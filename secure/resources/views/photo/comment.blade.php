<li>
    <div class="media">
        <img src="{!! avatar($comment->user->avatar, $comment->user->gender) !!}">
        <div class="media-body">
            <h3 class="font-weight-bold"><a href="{!! route('profile',['username'=>$comment->user->username]) !!}">{!! fullname($comment->user->firstname, $comment->user->lastname, $comment->user->username) !!}</a></h3>
            <p>
                {!! $comment->comment !!}
            </p>
        </div>
    </div>
</li>
