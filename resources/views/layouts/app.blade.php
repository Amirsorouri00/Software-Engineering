<!DOCTYPE html>
<html lang="en" >

<head>

    {{--<script src="{{asset('js/jqueryA.min.js')}}"></script>--}}
    {{--<script src="{{ asset('semantic/dist/semantic.min.js') }}"></script>--}}
    {{--<script src="{{ asset('js/bootstrap.js') }}"></script>--}}

    <link rel="shortcut icon" href="{{ asset('favicon-16x16.png') }}" >
    <script src="{{asset('js/jqueryA.min.js')}}"></script>
    <script src="{{ asset('semantic/dist/semantic.min.js') }}"></script>
    {{--<script src="{{ asset('js/bootstrap.js') }}"></script>--}}



    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css" rel='stylesheet'
          type='text/css'>
    <link href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700" rel='stylesheet' type='text/css'>

    <!-- Styles -->
    <link rel="shortcut icon" href="{{ asset('favicon-16x16.png') }}">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset('semantic/dist/semantic.rtl.min.css') }}">
    <script src="{{asset('js/back.js')}}"></script>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/back.css') }}">
    <link href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700" rel='stylesheet' type='text/css'>




    <script>
        $(document).ready(function () {
            // Add smooth scrolling to all links in navbar + footer link
            $(".navbar a, footer a[href='#myPage']").on('click', function (event) {

                // Make sure this.hash has a value before overriding default behavior
                if (this.hash !== "") {

                    // Prevent default anchor click behavior
                    event.preventDefault();

                    // Store hash
                    var hash = this.hash;

                    // Using jQuery's animate() method to add smooth page scroll
                    // The optional number (900) specifies the number of milliseconds it takes to scroll to the specified area
                    $('html, body').animate({
                        scrollTop: $(hash).offset().top
                    }, 900, function () {

                        // Add hash (#) to URL when done scrolling (default click behavior)
                        window.location.hash = hash;
                    });
                } // End if
            });
        })
    </script>
    <script>
        $(function () {

            $('.navbar-right li').click(function () {
                $(this).addClass('active').siblings().removeClass('active');
            });
        })
    </script>
    <style>

        /*——————  font- web-yar.ir —————— */
        @font-face {
            font-family: "KoodakBold";
            src: url(../font/KoodakBold.eot);
            src: url(../font/KoodakBold.eot?#iefix) format("embedded-opentype"), url(../font/KoodakBold.woff) format("woff"), url(../font/KoodakBold.ttf) format("truetype"), url(../font/Yekan.svg#BYekan) format("svg");
            font-weight: normal;
            font-style: normal

        }

        #des {

            font-size: 15pt;
        }

        body {
            font-family: 'KoodakBold';
            direction: ltr;
        }

        #note {
            background-color: #ffffcc;
            border-right: 6px solid #ffeb3b;
        }

        .fa-btn {
            margin-right: 6px;
        }

        .api {
            text-shadow: 4px 4px 4px #aaa;
            font-family: 'Lato';
            direction: ltr;
        }
    </style>




<style>
    @import url(http://fonts.googleapis.com/css?family=Open+Sans:400,600,700);

    .event {
        width: 300px;
        height: 80px;
        background: #fff;
        border: 1px solid #CCC;
        border-radius: 2px;
        margin: 10px;
    }
    .event:before {
        content: '';
        display: block;
        width: 295px;
        height: 70px;
        background: #fff;
        border: 1px solid #CCC;
        border-radius: 2px;
        transform: rotate(2deg);
        position: relative;
        top: 12px;
        left: 2px;
        z-index: -1;
    }
    .event:after {
        content: '';
        display: block;
        width: 295px;
        height: 75px;
        background: #fff;
        border: 1px solid #CCC;
        border-radius: 2px;
        transform: rotate(-2deg);
        position: relative;
        top: -136px;
        z-index: -2;
    }
    .event > span {
        display: block;
        width: 30px;
        background: #232323;
        position: relative;
        top: -55px;
        left: -15px;

        /* Text */
        color: #fff;
        font-size: 10px;
        padding: 2px 7px;
        text-align: right;
    }
    .event > .info {
        display: inline-block;
        position: relative;
        top: -75px;
        left: 40px;

        /* Text */
        color: #232323;
        font-weight: 600;
        line-height: 25px;
    }
    .event > .info:first-line {
        text-transform: uppercase;
        font-size: 10px;
        margin: 10px 0 0 0;
        font-weight: 700;
    }
    .event > .price {
        display: inline-block;
        width: 60px;
        position: relative;
        top: -85px;
        left: 115px;

        /* Text */
        color: #E35354;
        text-align: center;
        font-weight: 700;
    }
</style>


    <link rel="shortcut icon" href="{{ asset('favicon-16x16.png') }}" >

</head>
<body style="background-image: url(../img/back.jpg)">
<canvas style="z-index: -1" class='connecting-dots'></canvas>
    <nav class="navbar navbar-default">
        <div class="container">
            <div class="navbar-header">

                <!-- Collapsed Hamburger -->
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <img src="{{asset('img/logo.jpg')}}">
                <!-- Branding Image -->
            </div>

            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <!-- Left Side Of Navbar -->
                <ul class="nav navbar-nav">
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    <!-- Authentication Links -->
                    @if (Auth::guest())
                        <li><a href="{{ url('/teacherlogin') }}">Login</a></li>
                        <li><a href="{{ url('/register') }}">Register</a></li>
                    @else
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu" role="menu">
                                <li><a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i>Logout</a></li>
                            </ul>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    @yield('content')

    <div id="main" class="ui container ">

        @yield('content2')

    </div>

    <!-- JavaScripts -->
    {{-- <script src="{{ elixir('js/app.js') }}"></script> --}}
</body>
</html>
