<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="teacher" id="teacher" content="{{$info[0]}}">
    <meta name="status" id="status" content="{{$info[0]->individualStatus}}">
    <meta name="max" id="max" content="{{$info[5]}}">

    <meta id="token" name="token" content="{{ csrf_token() }}">
    <title>GUESTEXAM</title>
    <style media="screen">
      body {padding: 2em 0;}
      .error {font-weight: bold; color: red;}
    </style>
    <script src="js/teacher-main.js"></script>
    <script src="js/teacher-main.js"></script>
      <meta name="userid" content="{{ $info[0]->participantID }}">
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <!--<meta id="status" name="status" content="{{ $info[0] }}">-->
      {{--<script--}}
      {{--src="https://code.jquery.com/jquery-3.1.1.min.js"--}}
      {{--integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8="--}}
      {{--crossorigin="anonymous"></script>-- }}
      <link rel="shortcut icon" href="{{ asset('favicon-16x16.png')}}">
      <script src="{{ asset('js/jqueryA.min.js') }}"></script>
      <script src="{{ asset('semantic/dist/semantic.min.js') }}"></script>
      {{--<script src="{{ asset('js/bootstrap.js') }}"></script>--}}

      <link rel="stylesheet" type="text/css" href="{{ asset('semantic/dist/semantic.rtl.min.css') }}">
      <script src="{{ asset('js/back.js') }}"></script>
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
            {{ $err }}
        </div>
    @endif

    <div class="ui borderless main menu" style="z-index:-10;  height: 55px;background-color: #f9f9f9;">
        <div class="ui  container" style="width: 937px;">
            <div href="#" class="header item">
                <img style="width: 55px" src="{{ asset('img/logo.jpg') }}">
                {{ $info[0]->participantID }}
            </div>
            <div style=""></div>
        </div>
    </div>

    <!--<canvas style="z-index: -1" class='connecting-dots'></canvas>-->
    {{--<button onClick="fn()" class="ui button" id="btn-show">--}}
    {{--Show modal--}}
    {{--</button>--}}

    <div id="main" class="ui container ">

      <div id="app2">
          {{--<button v-on:click="Aj">Reverse Message</button>--}}

          {{--@{{ message }}--}}
          <div class="ui  container" id="main">
              <div class="ui two column centered grid">
                  <div class="column twelve wide">
                      <div class="ui two column grid">
                          <div class="column">
                              <div class="ui   piled raised segment ">
                                  <a class="ui  teal right ribbon label">Exam Information</a>
                                  <div class="ui blue segment">
                                      <div class="ui right aligned grid">
                                          <div class="center aligned two column row">
                                              <div id="userid" class="column right aligned">Max grade</div>
                                              <div class="column left aligned">
                                                  {{ $info[1] }}
                                              </div>
                                          </div>
                                      </div>
                                  </div>
                                  <div class="ui red segment">
                                      <div class="ui right aligned grid">
                                          <div class="center aligned two column row">
                                              <div id="userid" class="column right aligned">Min grade</div>
                                              <div class="column left aligned">
                                                  {{ $info[2] }}
                                              </div>
                                          </div>
                                      </div>
                                  </div>
                                  <div class="ui blue segment">
                                      <div class="ui right aligned grid">
                                          <div class="center aligned two column row">
                                              <div id="userid" class="column right aligned">Average</div>
                                              <div class="column left aligned">
                                                  {{ $info[3] }}
                                              </div>
                                          </div>
                                      </div>
                                  </div>
                                  <div class="ui green segment">
                                      <div class="ui right aligned grid">
                                          <div class="center aligned two column row">
                                              <div id="userid" class="column right aligned">Maximum round number</div>
                                              <div class="column left aligned">
                                                  {{ $info[5] }}
                                              </div>
                                          </div>
                                      </div>
                                  </div>
                                  <div class="ui yellow segment">
                                      <div class="ui right aligned grid">
                                          <div class="center aligned two column row">
                                              <div id="userid" class="column right aligned">Student numbers</div>
                                              <div class="column left aligned">
                                                  {{ $info[4] }}
                                              </div>
                                          </div>
                                      </div>
                                  </div>

                              </div>
                          </div>
                          <div class="column">
                              <div class="ui  piled raised segment ">
                                  <a class="ui olive ribbon label">Individual Information</a>
                                  <div class="ui blue segment">
                                      <div class="ui right aligned grid">
                                          <div class="center aligned two column row">
                                              <div id="userid" class="column right aligned">Grade</div>
                                              <div class="column left aligned">
                                                  {{ $info[0]->finalScore }}
                                              </div>
                                          </div>
                                      </div>
                                  </div>
                                  <div class="ui red segment">
                                      <div class="ui right aligned grid">
                                          <div class="center aligned two column row">
                                              <div id="userid" class="column right aligned">Individual round number</div>
                                              <div class="column left aligned">
                                                  {{ $info[0]->roundNumberInd }}
                                              </div>
                                          </div>
                                      </div>
                                  </div>
                                  <div class="ui blue segment">
                                      <div class="ui right aligned grid">
                                          <div class="center aligned two column row">
                                              <div id="userid" class="column right aligned">Correct answers
                                              </div>
                                              <div class="column left aligned">
                                                  {{ $info[0]->grade }}
                                              </div>
                                          </div>
                                      </div>
                                  </div>
                                  <div class="ui green segment">
                                      <div class="ui right aligned grid">
                                          <div class="center aligned two column row">
                                              <div id="userid" class="column right aligned">Wrong answers</div>
                                              <div class="column left aligned">
                                                  {{ $info[5] }}
                                              </div>
                                          </div>
                                      </div>
                                  </div>
                                  <div class="ui yellow segment">
                                      <div class="ui right aligned grid">
                                          <div class="center aligned two column row">
                                              <div id="userid" class="column right aligned">Student state</div>
                                              <div class="column left aligned">
                                                  @if($info[0]->QorR==1)
                                                      Questionnaire
                                                  @else
                                                      Respondent
                                                  @endif
                                              </div>
                                          </div>
                                      </div>
                                  </div>

                              </div>
                          </div>
                      </div>
                  </div>
              </div>
              <div class="thirteen wide column centered row">
                  <div class="ui grid centered" id="guestexam">
                      <div class="eight wide column centered">
                          <form action="/teacherEntertoGame/{{ $id }}" method="post">
                            <!--  v-on="submit: onSubmitForm" -->
                              <button  class="ui inverted massive fluid red button" type="submit" >
                              <!--v-on="click: submit" name="button" v-attr = "disabled: errors"-->
                                  Enter To Game
                              </button>
                          </form>
                      </div>
                      <div class="eight wide column centered">
                          <form action="/startgame/{{$info[0]->participantID}}" v-on="submit: enterToGame" method="get">
                              <button  class="ui inverted massive fluid olive button" v-on="click: submit" v-attr = "disabled: notstarted">
                                  Start Game
                              </button>
                          </form>
                      </div>
                  </div>
              </div>
              <div class="thirteen wide column centered row">
                  <div class=" ui grid centered">
                      <div class="eight wide column centered">
                          <form action="/baskets" method="get">
                              <button class="ui inverted massive fluid blue button">
                                  Show Baskets
                              </button>
                          </form>
                      </div>
                  </div>
              </div>
          </div>
      </div>


      <div id="dmm" class="ui page dimmer ">
          <div class="content">
              <div class="center"> لطفا صبر کنید
                  <div class="ui loader"></div>
              </div>

          </div>
      </div>

      <div class="ui modal">
          {{--<i class="close icon"></i>--}}
          <div class="header">

              لطفا باز ه ی نمره خود را وارد کنید
              <div> @{{ timeR }} زمان باقی مانده</div>
          </div>
          <form>
              <div class=" content">

                  <div class="ui   input">

                      <div class="right floated  four wide column">
                          <input v-model="num2" min="0" max="20"
                                 oninvalid="this.setCustomValidity('بازه نمره میبایست بین 0 تا 20 باشد')">
                      </div>
                      <div class="right floated  one wide column">تا</div>
                      <div class="right floated  four wide column">
                          <input v-model="num1" min="0" max="20"
                                 oninvalid="this.setCustomValidity('بازه نمره میبایست بین 0 تا 20 باشد')">
                      </div>
                      <div class="right floated  one wide column">از</div>
                  </div>

              </div>
              <p> @{{ errormessage }} </p>
              <div class="actions">
                  <button type="button" v-on:click="submit" class="ui button">تایید</button>
                  {{--<div class="ui black deny button">--}}
                  {{--Nope--}}
                  {{--</div>--}}
                  {{--<div class="ui positive right labeled icon button">--}}
                  {{--Yep, that's me--}}
                  {{--<i class="checkmark icon"></i>--}}
                  {{--</div>--}}
              </div>
          </form>
      </div>

      <script>
          $('.message .close')
                  .on('click', function () {
                      $(this)
                              .closest('.message')
                              .transition('fade')
                      ;
                  })
          ;
      </script>
    </div>

    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/teacher.js') }}"></script>
    <script src="{{ asset('js/teacher-main.js') }}"></script>
    <script src="js/app.js"></script>
    <!--<script src="js/teacher.js"></script>-->
    <script src="js/vendor.js"></script>
    <script src="js/guestexam.js"></script>
  </body>
</html>
