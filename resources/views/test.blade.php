@extends('layouts.master')

@section('content')
    <p id="power">0</p>
    <p>amir</p>
@stop

@section('footer')
    <script src="{ { asset('js/socket.io.js') } }"></script>
    <script>
        //var socket = io('http://localhost:3000');
        var socket = io('http://localhost:3000');
        socket.on("channel", function(message){
            // increase the power everytime we load test route
            $('#power').text(parseInt($('#power').text()) + 1);
        });
    </script>
@stop