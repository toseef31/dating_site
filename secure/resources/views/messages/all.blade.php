@extends('layouts.page')
@section('content')
<style>
@media (max-width: 444px) {
  .main-content {
    /* margin-top: 4rem; */
    /* min-height: 475px !important; */
    min-height: 100% !important;
  }
  .message-box {
    height: 400px !important;
  }
}
@media  (min-device-width: 444px) and (max-device-width: 768px) {
  .main-content {
    /* margin-top: 7rem; */
    /* min-height: 500px !important; */
    min-height: 93% !important;

  }
}
@media  (min-device-width: 600px) and (max-device-width: 768px) {
  .foo_container {
    margin-left: -5rem !important;
  }
}
@media (max-device-width: 1024px) and (min-device-width: 769px){
  .main-content {
      min-height: 90% !important;
      /* margin-top: 7rem; */
  }
}
@media  (min-device-width: 768px) and (max-device-width: 1024px) {
  .foo_container {
    margin-left: 0rem !important;
  }
}
@media  (min-device-width: 1900px) and (max-device-width: 2000px) {
  .foo_container {
    margin-left: 14rem !important;
  }
}
.main-content {
  min-height: 536px;
}
/* .footer{
  position: fixed !important;
} */
.message-box {
  max-height:
}
.list-unstyled {
  border-left: 1px solid #cccc;
}
</style>
    <div class="conversations clearfix">
      <div class="main-content">


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
        <div class="float-left message-box hidden-xs" style="height:481px;">

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

       @include('partials.footer')
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
                // $('.list-conversations').hide();
                $('.list-conversations').hide("slide", { direction: "left" }, 1000);
                $('.message-box').show();
            }

        }
    </script>
@endsection
