<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta id="token" name="token" content="{{ csrf_token() }}">
    {{--<script--}}
    {{--src="https://code.jquery.com/jquery-3.1.1.min.js"--}}
    {{--integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8="--}}
    {{--crossorigin="anonymous"></script>--}}

    <script src="{{asset('js/jqueryA.min.js')}}"></script>
    <script src="{{ asset('semantic/dist/semantic.min.js') }}"></script>
    {{--<script src="{{ asset('js/bootstrap.js') }}"></script>--}}

    <link rel="stylesheet" type="text/css" href="{{ asset('semantic/dist/semantic.rtl.min.css') }}">
    {{--<link href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.2.2/semantic.min.css" rel="stylesheet"--}}
    {{--type="text/css">--}}
    {{--<link rel="stylesheet" type="text/css" href="{{ asset('css/app.css') }}">--}}

    {{--<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">--}}

    <title>Laravel Quickstart - Intermediate</title>


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
<body>
<button onClick="fn()" class="ui button" id="btn-show">
    Show modal
</button>

<div id="main" class="ui container ">

    @yield('content')

</div>

</body>
</html>
