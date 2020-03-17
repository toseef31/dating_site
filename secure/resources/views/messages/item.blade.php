<li id="conversation-{!! $conv->id !!}" data-id="{!! $conv->id !!}" class="conversation-item{!! ( Illuminate\Support\Facades\Route::is('message') && request()->id ==  $conv->id) || (!request()->id && $key == 0) ? ' active':''!!}">
    <div class="media">
        @if(!isset($html_receive) && auth()->id() === $conv->sender_id)
            <img class="mr-2 border rounded-circle" src="{!! avatar($conv->receive->avatar, $conv->receive->gender) !!}">
        @else
            <img class="mr-2 border rounded-circle" src="{!! avatar($conv->sender->avatar, $conv->sender->gender) !!}">
        @endif
        <div class="media-body">
            @if(auth()->id() === $conv->sender_id)
                <strong>{!! fullname($conv->receive->firstname, $conv->receive->lastname, $conv->receive->username) !!}</strong>
            @else
                <strong>{!! fullname($conv->sender->firstname, $conv->receive->lastname, $conv->sender->username) !!}</strong>
            @endif
            <p class="mb-0">{!! isHTML($conv->last_message)?'<i class="far fa-image"></i> Image':$conv->last_message !!}</p>
        </div>
    </div>
</li>
