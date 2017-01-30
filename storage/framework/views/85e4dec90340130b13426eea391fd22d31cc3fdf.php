<?php $__env->startSection('content'); ?>

    <div class="container">
        <h2>Active Baskets</h2>
        <p>Contextual classes can be used to color table rows or table cells. The classes that can be used are: .active,
            .success, .info, .warning, and .danger.</p>
        <table class="table">
            <thead>
            <tr>
                <th>BasketID</th>
                <th>QuestionID</th>
                <th>BasketScore</th>
                <th>ShowBasket</th>
            </tr>
            </thead>
            <tbody>
            <?php $cnt = 0; ?>
            <?php foreach($baskets as $b): ?>
                <?php if($cnt%5 == 0): ?>
                    <tr class="active">
                        <td><?php echo e($b->basketID); ?></td>
                        <td><?php echo e($b->questionID); ?></td>
                        <td><?php echo e($b->basketScore); ?></td>
                        <td style="direction: rtl;">
                            <form action="http://software:81/basket/<?php echo e($b->id); ?>" method="post">
                                <button class="btn btn-info col-md-4">Go</button>
                            </form>
                        </td>
                    </tr>
                    <?php $cnt++; ?>
                <?php elseif($cnt%5 == 1): ?>
                    <tr class="success">
                        <td><?php echo e($b->basketID); ?></td>
                        <td><?php echo e($b->questionID); ?></td>
                        <td><?php echo e($b->basketScore); ?></td>
                        <td style="direction: rtl;">
                            <form action="http://software:81/basket/<?php echo e($b->id); ?>" method="post">
                                <button class="btn btn-info col-md-4">Go</button>
                            </form>
                        </td>
                    </tr>
                    <?php $cnt++; ?>
                <?php elseif($cnt%5 == 2): ?>
                    <tr class="info">
                        <td><?php echo e($b->basketID); ?></td>
                        <td><?php echo e($b->questionID); ?></td>
                        <td><?php echo e($b->basketScore); ?></td>
                        <td style="direction: rtl;">
                            <form action="http://software:81/basket/<?php echo e($b->id); ?>" method="post">
                                <button class="btn btn-info col-md-4">Go</button>
                            </form>
                        </td>
                    </tr>
                    <?php $cnt++; ?>
                <?php elseif($cnt%5 == 3): ?>
                    <tr class="warning">
                        <td><?php echo e($b->basketID); ?></td>
                        <td><?php echo e($b->questionID); ?></td>
                        <td><?php echo e($b->basketScore); ?></td>
                        <td style="direction: rtl;">
                            <form action="http://software:81/basket/<?php echo e($b->id); ?>" method="post">
                                <button class="btn btn-info col-md-4">Go</button>
                            </form>
                        </td>
                    </tr>
                    <?php $cnt++; ?>
                <?php elseif($cnt%5 == 4): ?>
                    <tr class="active">
                        <td><?php echo e($b->basketID); ?></td>
                        <td><?php echo e($b->questionID); ?></td>
                        <td><?php echo e($b->basketScore); ?></td>
                        <td style="direction: rtl;">
                            <form action="http://software:81/basket/<?php echo e($b->id); ?>" method="post">
                                <button class="btn btn-info col-md-4">Go</button>
                            </form>
                        </td>
                    </tr>
                    <?php $cnt++; ?>
                <?php endif; ?>
            <?php endforeach; ?>
            </tbody>
        </table>
        <?php echo e($baskets->links()); ?>

    </div>




    <!--
    <div class="container">
        <?php foreach($baskets as $b): ?>
            <div class="panel panel-default ">
                <div class="panel-heading">
                    <label>basketID:</label>
                    <a href="basket/<?php echo e($b->id); ?>"> <?php echo e($b->basketID); ?></a>
                </div>
                <div class="panel-body">
                    <?php echo e($b->questionID); ?>

            </div>
            <div class="panel-footer">
                <?php echo e($b->basketScore); ?>

            </div>
        </div>
    <?php endforeach; ?>
    <?php echo e($baskets->links()); ?>

            </div>
            -->
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>