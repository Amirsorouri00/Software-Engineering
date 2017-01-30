<?php $__env->startSection('content'); ?>
    <p id="power">0</p>
    <p>amir</p>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('footer'); ?>
    <script src="{ { asset('js/socket.io.js') } }"></script>
    <script>
        //var socket = io('http://localhost:3000');
        var socket = io('http://localhost:3000');
        socket.on("channel", function(message){
            // increase the power everytime we load test route
            $('#power').text(parseInt($('#power').text()) + 1);
        });
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>