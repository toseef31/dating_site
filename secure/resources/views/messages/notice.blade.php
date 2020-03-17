<div class="notification" id="notification-{!! $message->id !!}">
    <span class="close">&times;</span>
    <a href="{!! route('message',['id'=>$message->conversation_id]) !!}">
        <div class="media">
            <img src="{!! avatar($message->user->avatar, $message->user->gender) !!}" class="rounded-circle border">
            <div class="media-body">
                {!! fullname($message->user->firstname, $message->user->lastname, $message->user->username) !!}
            </div>
        </div>
        <p>{!! $message->message !!}</p>
    </a>
</div>
