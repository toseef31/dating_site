@extends('layouts.page')
@section('content')
    <div class="conversations clearfix">
        <div class="float-left list-conversations">
            <div class="search-conversation">
                <input type="text" placeholder="Search">
                <i class="fas fa-search"></i>
            </div>
            <ul class="list-unstyled mb-0">
                @if($conversations->count())
                    @foreach($conversations as $key=>$conv)
                        @include('messages.item')
                    @endforeach
                @endif
            </ul>
        </div>
        <div class="float-left message-box">
            <?php
            if(!isset($conversation)){
                $conversation = $conversations->first();
            }
            ?>
            @if($conversation)
                @include('messages.conversation')
            @endif
        </div>
    </div>
@endsection
