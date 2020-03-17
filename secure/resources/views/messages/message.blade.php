<li class="message{!! !isset($html_receive) && auth()->id() == $message->user_id ? ' self':'' !!}" id="message-{!! $message->id !!}">
    <img src="{!! avatar($message->user->avatar, $message->user->gender) !!}" class="avatar border rounded-circle mr-2">
    <div class="message-detail">
        {!! $message->message !!}
        <p>{!! \Carbon\Carbon::createFromTimestamp(strtotime($message->created_at))->diffForHumans() !!}</p>
        @if(!isset($html_receive) && $message->user_id == auth()->id())
        <span>{!! $message->seen?'Seen':'Delivered' !!}</span>
        @endif
    </div>
</li>
