@extends('layouts.page')
@section('content')
<style>
@media  (min-device-width: 600px) and (max-device-width: 768px) {
  .foo_container {
    margin-left: -5rem !important;
  }
}
@media  (min-device-width: 768px) and (max-device-width: 1024px) {
  .foo_container {
    margin-left: 0rem !important;
  }
}
@media  (min-device-width: 1500px) and (max-device-width: 2000px) {
  .foo_container {
    margin-left: 14rem !important;
  }
}
</style>
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
        <div class="float-left message-box hidden-xs">

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
    <script>
        function functionHide() {
            if (navigator.userAgent.match(/Android/i)
                || navigator.userAgent.match(/webOS/i)
                || navigator.userAgent.match(/iPhone/i)

                || navigator.userAgent.match(/BlackBerry/i)
                || navigator.userAgent.match(/Windows Phone/i)
            )
            {
                $('.list-conversations').hide();
                $('.message-box').show();
            }

        }
    </script>
@endsection
