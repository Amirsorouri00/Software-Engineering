<?php $__env->startSection('content'); ?>



    <div class="container">

        <h1>BasketID <?php echo e($basket->id); ?></h1>
        <div class="panel panel-default">
            <div class="panel-heading">Manage Basket</div>
            <div class="panel-body">
                <div class="col-md-6">
                    <h2 class="col-md-9" style="margin-bottom: 0; border-right: thick solid #e7e7e7;">Change Basket</h2>
                    <form class="form-horizontal" action="<?php echo e(url('basketupdate/' . $basket->id)); ?>" method="post">
                        <div class="col-md-9" style="margin-top: 0; border-right: thick solid #e7e7e7;">
                            <div class="form-group col-md-12">
                                <label class="control-label col-md-4" for="email"><h3>Bonus: </h3></label>
                                <div class="col-md-5" style="margin-top: 20px; margin-left: 10px;">
                                    <input type="number" name="score" class="form-control" min="0" max="20" id="email"
                                           value="<?php echo e($basket->basketScore); ?>"
                                           oninvalid="setCustomValidity('Please Enter The Right Bonus !!')">
                                </div>
                            </div>
                            <div class="form-group col-md-12">
                                <div class="col-md-offset-5">
                                    <button type="submit" class="btn btn-default">Submit</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="col-md-4">
                    <div class="event" style="font-family: 'Open Sans', sans-serif;font-weight: 400;">
                        <span style="padding-left: 0; border: 3px solid #111;border-radius: 2px; transform: rotate(2deg);">
                            Active
                        </span>
                        <div class="info">
                            Basket Status: <?php echo e($basket->basketStatus); ?>;
                            <br/>
                            Volunteer Numbers: 0;

                        </div>
                    </div>

                    <div class="event" style="font-family: 'Open Sans', sans-serif;font-weight: 400;">
                        <span style="border: 1px solid #111;border-radius: 1px; transform: rotate(2deg);">
                            #002
                        </span>
                        <div class="info">
                            RESPONDERE ID: <?php echo e($basket->responderedID); ?> <br/>
                            Questioner ID: <?php echo e($basket->questionerID); ?>

                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>


<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>