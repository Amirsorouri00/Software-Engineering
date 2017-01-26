<html>

<head>

    {{--<script src="{{asset('js/jqueryA.min.js')}}"></script>--}}
    {{--<script src="{{ asset('semantic/dist/semantic.min.js') }}"></script>--}}
    {{--<script src="{{ asset('js/bootstrap.js') }}"></script>--}}

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css" rel='stylesheet'
          type='text/css'>
    <link href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700" rel='stylesheet' type='text/css'>

    <!-- Styles -->
    <link rel="shortcut icon" href="{{ asset('favicon-16x16.png') }}">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
    {{--<link rel="stylesheet" type="text/css" href="{{ asset('semantic/dist/semantic.rtl.min.css') }}">--}}
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
            direction: rtl;
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


</head>
<body style="background-image: url(../img/back.jpg)">


<body id="app-layout">
{{--<nav class="navbar navbar-fixed-top navbar-default">--}}
{{--<div class="container-fluidr">--}}
{{--<div style="float: right" class="navbar-header">--}}

{{--<div  class="container-fluid">--}}
{{--<div style="float: right;" class="navbar-header">--}}
{{--<img   src= "{{asset('img/logo.jpg')}}">--}}

{{--</div>--}}
{{--<ul style="float: right; margin-right: 30px"  class="nav navbar-nav">--}}
{{--<li style="float: right;" class="active"><a href="#">Home</a></li>--}}
{{--<li style="float: right;"><a href="#section1">Page 1</a></li>--}}
{{--<li style="float: right;"><a href="#section2">Page 2</a></li>--}}

{{--</ul>--}}
{{--</div>--}}
{{--<!-- Collapsed Hamburger -->--}}


{{--<!-- Branding Image -->--}}

{{--</div>--}}
{{--</div>--}}
{{--</nav>--}}


<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <img src="{{asset('img/logo.jpg')}}">
        </div>
        <div class="collapse navbar-collapse" id="myNavbar">
            <ul class="nav navbar-nav navbar-right">

                <li><a href="#s5">تلگرام</a></li>
                <li><a href="#s4">داوطلبی</a></li>
                <li class="active"><a href="#s3">داوری</a></li>
                <li><a href="#s2">پرسش و پاسخ</a></li>
                <li class="active"><a href="#s1"> ورود و خروج </a></li>
            </ul>
        </div>
    </div>
</nav>
<div style="margin-top:60px" id="myPage" class="container">

    <div class="panel panel-default">

        <div class="panel-body" id="des">

            <img style="float: left" src="{{asset('img/bit logo.jpg')}}">


          دانشگاه همواره به عنوان یکی از بزرگترین مراکز علمی شناخته شده، و امور ارزشیابی دانشجویان از جمله بزرگترین وظایف
دانشگاه است. با توجه به اهمیت وجود یک سیستم ارزشیابی مناسب، دقیق و بی نقص که مشکلات سیستم فعلی در آن
برطرف شده باشد، سیستم ارزشیابی جدیدی نیاز است که این فرآیند را با دقت و کیفیت هرچه بیشتر محقق سازد.
<br>
 لذا ما بر آن آمدیم تا تا با تولید نرم افزاری این امر مهم را در در طول ترم 3951 در دانشگاه صنعتی اصفهان  به انجام رسانیم.
<br>
در زیر سیستم پیشرو بخش نوبت دهی در فرایند برگزاری امتحان انجام می شود .این سیستم تا برقراری هماهنگی کامل بین زیرسیستم های دیگر فقط حاوی همین صفحه میباشد.بخش های دیگر پروژه می توانند از API های این سیستم را در بخش های بعدی مشاهده کنند.
<br>
این سیستم به دست گروه مجرب و قدرتمند Bit ( ;) ) پیاده سازی شده است.  برای آشنایی بیشتر با این گروه می توانید به خودشان مراجعه کنید.



        </div>

    </div>


    <body data-spy="scroll" data-target=".navbar" data-offset="50">

    <!-- The navbar - The <a> elements are used to jump to a section in the scrollable area -->

    <!-- Section 1 -->
    <div class="panel panel-success" id="s1">
        <div class="panel-heading"> ورود و خروج</div>
        <div class="panel-body">
            <div class="api">
                http://51.254.79.220/entertogame
            </div>
            <div id="note">دریافت کاربر وارد شده</div>

            <div class="api">
                http://51.254.79.220/forceExit
            </div>
            <div id="note"> ارسال کاربری که باید خارج شود به سیستم ورود و خروج </div>

            <div class="api">
                http://51.254.79.220/volunteerExit
            </div>
            <div id="note"> ارسال اطلاعات کاربری که درخواست خروج داده به بهش ورود و خروج </div>

        </div>
    </div>
    <div class="panel panel-info" id="s1">
        <div class="panel-heading"> پرسش و پاسخ</div>
        <div class="panel-body">

            <div class="api">
                http://51.254.79.220/questionPartResult
            </div>
            <div id="note"> دریافت نتیجه پرسش و پاسخ اصلی(اولیه)</div>

            <div class="api">
                http://51.254.79.220/volunteerResult
            </div>
            <div id="note"> دریافت نتیجه پرسش و پاسخ بخش داوطلبی</div>

            <div class="api">
                http://51.254.79.220/getObjectedBasket
            </div>
            <div id="note">دریافت سبدی که برای آن تقاضای داوری داده شده (دریافت از سیستم سوال و جواب،تحویل به سیستم داوری)</div>

        </div>


    </div>


    <div class="panel panel-success" id="s3">
        <div class="panel-heading">داوری</div>
        <div class="panel-body">
            <div
                    class="api">
                http://51.254.79.220/getObjectionResult
            </div>
            <div id="note"> دریافت سبد به همراه نتیجه داوری</div>
        </div>


    </div>
    <div class="panel panel-info" id="s4">
        <div class="panel-heading">داوطلبی</div>
        <div class="panel-body">
            <div
                    class="api">
                http://51.254.79.220/getVolunteers
            </div>
            <div id="note"> دریافت سبد به همرا لیست داوطلبان </div>

        </div>
    </div>

    <div class="panel panel-success" id="s5">
        <div class="panel-heading">تلگرام</div>
        <div class="panel-body">
            <div
                    class="api">
                http://51.254.79.220/telegraRange
            </div>
            <div id="note"> دریافت بازه نمره یک کاربر</div>


        </div>


    </div>


    </body>
</div>
<footer class="container-fluid text-center">
    <a href="#myPage" title="To Top">
        <span class="glyphicon glyphicon-chevron-up"></span>
    </a>
    <p>ver 1.1
</footer>
<canvas style="z-index: -1" class='connecting-dots'></canvas>
</body>

</html>