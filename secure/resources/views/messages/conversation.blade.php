<div id="message-box-{!! $conversation->id !!}" class="h-100">
    <div class="title-conversation clearfix">
        {!! auth()->id() === $conversation->sender_id ? fullname($conversation->receive->firstname, $conversation->receive->lastname, $conversation->receive->username) : fullname($conversation->sender->firstname, $conversation->sender->lastname, $conversation->sender->username) !!}
        <div class="dropdown float-right">
            <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-ellipsis-v"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink">
                <a class="dropdown-item" href="{!! route('profile', ['username' => (auth()->id() === $conversation->sender_id ? $conversation->receive->username : $conversation->sender->username)]) !!}">Profile</a>
                <a data-receive="{!! auth()->id() === $conversation->sender_id ? $conversation->receive_id : $conversation->sender_id !!}" href="javascript:void(0)" class="dropdown-item text-danger delete_conversation" data-id="{!! $conversation->id !!}">Delete</a>
            </div>
        </div>
    </div>
    <div class="list-messages">
        <ul class="list-unstyled mb-0">
            @if($conversation->messages()->count())
                @if($conversation->messages()->count() > 20)
                    <li class="load_more_message" data-id="{!! $conversation->id !!}" data-page="1"><span>Load more</span></li>
                @endif
                @foreach(collect($conversation->messages()->get()->take(20))->reverse() as $message)
                    {!! $message->seen() !!}
                    @include('messages.message')
                @endforeach
            @endif
        </ul>
        <div class="write-message{!! auth()->id() == $conversation->sender_id && $conversation->waiting == 1 && !empty($conversation->last_message)?' waiting':'' !!}">
            <form data-receive="{!! auth()->id() === $conversation->sender_id ? $conversation->receive_id : $conversation->sender_id !!}" data-id="{!! $conversation->id !!}" id="uploadChat" method="post" action="{!! route('message_upload') !!}" enctype="multipart/form-data">
                {!! csrf_field() !!}
                <input type="hidden" name="id" value="{!! $conversation->id !!}">
                <input name="file" type="file" style="display: none" id="imageChat" accept="image/*">
            </form>
            <div class="progress">
                <div class="progress-bar" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
            <div class="typing"></div>
            <div class="emojis" id="emojis">
                <span><i class="fas fa-grin"></i></span>
                <div class="list-emojis" id="list-emojis">
                    @foreach(emojis() as $item)
                        <a href="javascript:void(0)">{!! $item !!}</a>
                    @endforeach
                </div>
            </div>
            <div class="send-photo"><i class="far fa-image"></i></div>
            <input data-sendername="{!! fullname(auth()->user()->firstname, auth()->user()->lastname, auth()->user()->username) !!}" data-sender="{!! auth()->id() !!}" data-receive="{!! auth()->id() === $conversation->sender_id ? $conversation->receive_id : $conversation->sender_id !!}" data-id="{!! $conversation->id !!}" placeholder="Type your message..." class="message-input">
        </div>
    </div>
</div>
