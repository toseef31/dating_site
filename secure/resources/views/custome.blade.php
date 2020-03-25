@extends('layouts.custome')
@section('stylesheet')
    <style>
        .custome-title
        {
            background-color: white;
            height: 80px;
        }
        .custome-description
        {
            font-size: 35px;
            height: 150px;
        }
        .custome-content-main
        {
            font-size: 25px;
        }
    </style>
    @endsection
@section('content')
    <div class="landing">
    <div class="container-fluid main_container">

        @include('partials.sidebar')
        <div class="main">
            <div class="container-fluid custome-title">
                <h1 class="ml-3 pt-3">Title</h1>
            </div>


            <div class="main-photos">

                <div class="container-fluid">
                    <p class="ml-3 pt-5 custome-description"> Page discription</p>
                </div>
                <div class="container-fluid custome-content">
                    <h2 class="ml-3 pt-5 "> Singles Dating World Privacy Policy</h2>
                    <p class="ml-3 custome-content-main">It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for 'lorem ipsum' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).</p>
                </div>
            </div>
            <div class="footer" style="position: fixed !important; width: 100%;">
                <div class="container foo_container">
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

    </div>
    </div>
@endsection
