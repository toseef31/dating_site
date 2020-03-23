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
        <div class="footer" style="position: fixed !important;"  >
            <div class="container foo_container" style="margin-left: 5rem;">
                <div class="text-center">
                    <ul class="list-unstyled menu-footer clearfix mb-1">
                        <li><a href="#">About</a></li>
                        <li><a href="#">Blog</a></li>
                        <li><a href="{!! route('landing') !!}">Search</a></li>
                        <li><a href="#">Terms</a></li>
                        <li><a href="#">Privacy</a></li>
                        <li><a href="#">Contact</a></li>
                    </ul>
                    <p class="mb-1">&copy; 2020 Singles Dating World</p>
                </div>
            </div>
        </div>

    </div>

@endsection
