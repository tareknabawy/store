<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo $__env->yieldContent('title_prefix', config('adminlte.title_prefix', '')); ?>
<?php echo $__env->yieldContent('title', config('adminlte.title', 'AdminLTE 2')); ?>
<?php echo $__env->yieldContent('title_postfix', config('adminlte.title_postfix', '')); ?> - <?php echo $__env->yieldContent('content_header'); ?></title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>"/>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="<?php echo e(asset('vendor/adminlte/vendor/bootstrap/dist/css/bootstrap.min.css')); ?>">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?php echo e(asset('vendor/adminlte/vendor/font-awesome/css/all.min.css')); ?>">
    <!-- Ionicons -->
    <link rel="stylesheet" href="<?php echo e(asset('vendor/adminlte/vendor/Ionicons/css/ionicons.min.css')); ?>">
    <!-- Bootstrap-select -->
    <link rel="stylesheet" href="<?php echo e(asset('vendor/adminlte/dist/css/bootstrap-select.min.css')); ?>">
    <!-- AdminLTE Theme style -->
    <link rel="stylesheet" href="<?php echo e(asset('vendor/adminlte/dist/css/AdminLTE.min.css')); ?>">
    <!-- Adminlte Purple skin -->    
    <link rel="stylesheet" href="<?php echo e(asset('vendor/adminlte/dist/css/skins/skin-purple.min.css')); ?>">
    <!-- Summernote Text Editor -->
    <link rel="stylesheet" href="<?php echo e(asset('vendor/adminlte/vendor/summernote/summernote.css')); ?>">
    <!-- iCheck plugin Square skin -->
    <link rel="stylesheet" href="<?php echo e(asset('vendor/adminlte/dist/js/iCheck/square/aero.css')); ?>">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="<?php echo e(asset('vendor/adminlte/dist/css/sweetalert2.css')); ?>">
    <!-- Tagsinput -->
    <link rel="stylesheet" href="<?php echo e(asset('vendor/adminlte/dist/css/bootstrap-tagsinput.css')); ?>">
    <!-- Jquery UI -->
    <link rel="stylesheet" href="<?php echo e(asset('vendor/adminlte/dist/css/jquery-ui.min.css')); ?>">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?php echo e(asset('vendor/adminlte/dist/css/custom.css')); ?>">
        
    <!-- Jquery -->
    <script src="<?php echo e(asset('vendor/adminlte/vendor/jquery/dist/jquery.min.js')); ?>"></script>
    <!-- jQuery Form Plugin -->
    <script src="<?php echo e(asset('vendor/adminlte/dist/js/jquery.form.min.js')); ?>"></script>
    <!-- Custom JS -->
    <script src="<?php echo e(asset('vendor/adminlte/dist/js/custom.js')); ?>"></script>
    <!-- Bootstrap-select -->
    <script src="<?php echo e(asset('vendor/adminlte/dist/js/bootstrap-select.min.js')); ?>"></script>
    <!-- iCheck -->
    <script src="<?php echo e(asset('vendor/adminlte/dist/js/iCheck/icheck.min.js')); ?>"></script>
    <!-- jQuery UI -->    
    <script src="<?php echo e(asset('vendor/adminlte/vendor/other/jquery-ui.js')); ?>"></script>
    <!-- jQuery UI Touch Punch -->    
    <script src="<?php echo e(asset('vendor/adminlte/vendor/other/jquery.ui.touch-punch.min.js')); ?>"></script>
    <!-- SweetAlert2 -->
    <script src="<?php echo e(asset('vendor/adminlte/dist/js/sweetalert2.js')); ?>"></script>
    <!-- Tagsinput -->
    <script src="<?php echo e(asset('vendor/adminlte/dist/js/bootstrap-tagsinput.min.js')); ?>"></script>

    <!--[if lt IE 9]>
    <script src="<?php echo e(asset('vendor/adminlte/vendor/other/html5shiv.min.js')); ?>"></script>
    <script src="<?php echo e(asset('vendor/adminlte/vendor/other/respond.min.js')); ?>"></script>
    <![endif]-->
</head>
<body class="hold-transition <?php echo $__env->yieldContent('body_class'); ?>">

<?php echo $__env->yieldContent('body'); ?>

    <!-- Bootstrap -->
    <script src="<?php echo e(asset('vendor/adminlte/vendor/bootstrap/dist/js/bootstrap.min.js')); ?>"></script>
    <!-- Summernote Text Editor -->
    <script src="<?php echo e(asset('vendor/adminlte/vendor/summernote/summernote.js')); ?>"></script>
    <!-- AdminLTE -->
    <script src="<?php echo e(asset('vendor/adminlte/dist/js/adminlte.min.js')); ?>"></script>

</body>
</html>
<?php /**PATH /home/cariazlj/prod.foxart.co/lapp/resources/views/vendor/adminlte/master.blade.php ENDPATH**/ ?>