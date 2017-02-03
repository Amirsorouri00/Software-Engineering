<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="userid" content="{{$info[0]->participantID}}">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta id="token" name="token" content="{{ csrf_token() }}">
    {{--<script--}}
    {{--src="https://code.jquery.com/jquery-3.1.1.min.js"--}}
    {{--integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8="--}}
    {{--crossorigin="anonymous"></script>--}}
    <link rel="shortcut icon" href="{{ asset('favicon-16x16.png') }}">
    <script src="{{asset('js/jqueryA.min.js')}}"></script>
    <script src="{{ asset('semantic/dist/semantic.min.js') }}"></script>
    {{--<script src="{{ asset('js/bootstrap.js') }}"></script>--}}

    <link rel="stylesheet" type="text/css" href="{{ asset('semantic/dist/semantic.rtl.min.css') }}">
    <script src="{{asset('js/back.js')}}"></script>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/back.css') }}">
    {{--<link href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.2.2/semantic.min.css" rel="stylesheet"--}}
    {{--type="text/css">--}}
    {{--<link rel="stylesheet" type="text/css" href="{{ asset('css/app.css') }}">--}}

    {{--<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">--}}

    <title>Laravel Quickstart - Intermediate</title>
    <style>
        @font-face {
            font-family: "KoodakBold";
            src: url(../font/KoodakBold.eot);
            src: url(../font/KoodakBold.eot?#iefix) format("embedded-opentype"), url(../font/KoodakBold.woff) format("woff"), url(../font/KoodakBold.ttf) format("truetype"), url(../font/Yekan.svg#BYekan) format("svg");
            font-weight: normal;
            font-style: normal
        }

        body {
            font-family: 'Tahoma';
        }
    </style>
    <script>


        function fn() {
            $('.ui.modal')
                    .modal('setting', 'closable', false)
                    .modal('show')
            ;

        }
        ;
    </script>
</head>
<body style="background-image: url(../img/back.jpg)">

@if( isset($err))
    <div class="ui warning message">
        <i class="close icon"></i>
        <div class="header">
            خطا
        </div>
        {{$err}}
    </div>
@endif


<div class="ui borderless main menu" style="z-index:-10;  height: 55px;background-color: #f9f9f9;">
    <div class="ui  container" style="width: 937px;">
        <div href="#" class="header item">
            <img style="width: 55px" src="{{asset('img/logo.jpg')}}">
            {{$info[0]->participantID}}
        </div>
        <div style=""></div>
    </div>
</div>

<!--<canvas style="z-index: -1" class='connecting-dots'></canvas>-->
{{--<button onClick="fn()" class="ui button" id="btn-show">--}}
{{--Show modal--}}
{{--</button>--}}

<div id="main" class="ui container ">
    @yield('content')
</div>

<script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
