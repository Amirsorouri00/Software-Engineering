<?php $__env->startSection('content'); ?>


    <div id="app2">
        <?php /*<button v-on:click="Aj">Reverse Message</button>*/ ?>

        <?php /*{{ message }}*/ ?>
        <div class="ui  container">
            <div class="ui two column centered grid">
                <div class="column ten wide">
                    <div class="ui center one column grid">
                        <div class="column">
                            <div class="ui   piled raised segment ">
                                <a class="ui  teal left ribbon label">Overview</a>
                            </div>
                        </div>
                        <!--
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
                        -->
                    </div>
                </div>
                <div class="thirteen wide column centered row ">
                    <div class=" ui grid centered">
                        <div class="eight wide column centered">
                            <form action="http://software:81/teacherEntertoGame/<?php echo e($id); ?>" method="post">
                                <button v-on:click="close" class="ui inverted massive fluid red button">
                                    درخواست ورود به بازی
                                </button>
                            </form>
                        </div>
                        <div class="eight wide column centered">
                            <form action="http://software:81/startgame" method="get">
                                <button v-on:click="reverseMessage" class="ui inverted massive fluid olive button">
                                    شروع بازی
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

            <?php /*<i class="close icon"></i>*/ ?>
            <div class="header">

                لطفا باز ه ی نمره خود را وارد کنید
                <div> {{ timeR }} زمان باقی مانده</div>
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
                <p> {{ errormessage }} </p>
                <div class="actions">
                    <button type="button" v-on:click="submit" class="ui button">تایید</button>
                    <?php /*<div class="ui black deny button">*/ ?>
                    <?php /*Nope*/ ?>
                    <?php /*</div>*/ ?>
                    <?php /*<div class="ui positive right labeled icon button">*/ ?>
                    <?php /*Yep, that's me*/ ?>
                    <?php /*<i class="checkmark icon"></i>*/ ?>
                    <?php /*</div>*/ ?>
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

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.template', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>