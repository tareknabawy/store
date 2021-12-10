<!DOCTYPE html>
<html lang="<?php echo e($settings['site_language']); ?>">
<head>
    <?php echo $__env->make('frontend::inc.head', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</head>
<body>

<?php echo $__env->make('frontend::inc.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php echo $__env->yieldContent('content'); ?>

<?php echo $__env->make('frontend::inc.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

</body>
</html><?php /**PATH /home/cariazlj/prod.foxart.co/lapp/resources/views/vendor/frontend/page.blade.php ENDPATH**/ ?>