@extends('layouts.template')

@section('content')


    <div id="app2">
        {{--<button v-on:click="Aj">Reverse Message</button>--}}

        {{--@{{ message }}--}}
        <div class="ui  container">
            <div class="ui two column centered grid">
                <div class="column ten wide">
                    <div class="ui two column grid   ">
                        <div class="column">
                            <div class="ui   piled raised segment ">
                                <a class="ui  teal right ribbon label">Overview</a>
                                <div class="ui blue segment">
                                    <div class="ui right aligned grid">
                                        <div class="center aligned two column row">
                                            <div class="column right aligned">

                                                Center محسن row

                                            </div>
                                            <div class="column left aligned">

                                                Center aligned row

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="ui red segment">
                                    <p>Middle</p>
                                </div>
                                <div class="ui blue segment">
                                    <p>Middle</p>
                                </div>
                                <div class="ui green segment">
                                    <p>Middle</p>
                                </div>
                                <div class="ui yellow segment">
                                    <p>Bottom</p>
                                </div>

                            </div>
                        </div>
                        <div class="column">
                            <div class="ui  piled raised segment ">
                                <a class="ui olive ribbon label">Overview</a>
                                <div class="ui blue segment">
                                    <div class="ui right aligned grid">
                                        <div class="center aligned two column row">
                                            <div class="column right aligned">

                                                Center aligned row

                                            </div>
                                            <div class="column left aligned">

                                                Center aligned row

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="ui red segment">
                                    <p>Middle</p>
                                </div>
                                <div class="ui blue segment">
                                    <p>Middle</p>
                                </div>
                                <div class="ui green segment">
                                    <p>Middle</p>
                                </div>
                                <div class="ui yellow segment">
                                    <p>Bottom</p>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="thirteen wide column centered row">
                    <div class=" ui grid centered">
                        <div class="eight wide column centered">
                            <form action="http://software:81/teacherEntertoGame/{{$b->id}}" method="post">
                                <button v-on:click="close" class="ui inverted massive fluid red button"> درخواست خروج از
                                    بازی
                                </button>
                            </form>

                        </div>
                        <div class="eight wide column centered">
                            <button v-on:click="reverseMessage" class="ui inverted massive fluid olive button"> ورود
                                به
                                بخش
                                داوطلبی
                            </button>

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

@endsection