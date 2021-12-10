<?php $__env->startSection('adminlte_css'); ?>
<link rel="stylesheet" href="<?php echo e(asset('vendor/adminlte/dist/css/skins/skin-' . config('adminlte.skin', 'blue') . '.min.css')); ?> ">
    <?php echo $__env->yieldPushContent('css'); ?>
    <?php echo $__env->yieldContent('css'); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('body_class', 'skin-' . config('adminlte.skin', 'blue') . ' sidebar-mini ' . (config('adminlte.layout') ? [
    'boxed' => 'layout-boxed',
    'fixed' => 'fixed',
    'top-nav' => 'layout-top-nav'
][config('adminlte.layout')] : '') . (config('adminlte.collapse_sidebar') ? ' sidebar-collapse ' : '')); ?>
<?php $__env->startSection('body'); ?>
    <div class="wrapper">

        <!-- Main Header -->
        <header class="main-header">
            <?php if(config('adminlte.layout') == 'top-nav'): ?>
                <nav class="navbar navbar-static-top">
                    <div class="container">
                        <div class="navbar-header">
                            <a href="<?php echo e(url(config('adminlte.dashboard_url', 'admin'))); ?>" class="navbar-brand">
                                <?php echo config('adminlte.logo', '<b>Admin</b>LTE'); ?>

                            </a>
                            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                                    data-target="#navbar-collapse">
                                <i class="fa fa-bars"></i>
                            </button>
                        </div>

                        <!-- Collect the nav links, forms, and other content for toggling -->
                        <div class="collapse navbar-collapse pull-left" id="navbar-collapse">
                            <ul class="nav navbar-nav">
                                <?php echo $__env->renderEach('adminlte::partials.menu-item-top-nav', $adminlte->menu(), 'item'); ?>
                            </ul>
                        </div>
                        <!-- /.navbar-collapse -->
                    <?php else: ?>
                        <!-- Logo -->
                            <a href="<?php echo e(url(config('adminlte.dashboard_url', 'admin'))); ?>" class="logo">
                                <!-- mini logo for sidebar mini 50x50 pixels -->
                                <span class="logo-mini"><?php echo config('adminlte.logo_mini', '<b>A</b>LT'); ?></span>
                                <!-- logo for regular state and mobile devices -->
                                <span class="logo-lg"><?php echo config('adminlte.logo', '<b>Admin</b>LTE'); ?></span>
                            </a>

                            <!-- Header Navbar -->
                            <nav class="navbar navbar-static-top" role="navigation">
                                <!-- Sidebar toggle button-->
                                <a href="#" class="sidebar-toggle fa5" data-toggle="push-menu" role="button">
                                    <span class="sr-only"><?php echo e(trans('adminlte::adminlte.toggle_navigation')); ?></span>
                                </a>
                            <?php endif; ?>
                            <!-- Navbar Right Menu -->
                                <div class="navbar-custom-menu">

                                    <ul class="nav navbar-nav">
                                        <li class="dropdown messages-menu">
                                            <a href="/" target="_blank"><i class="fas fa-external-link-square-alt"></i> <?php echo app('translator')->getFromJson('admin.browse_site'); ?></a></li>
                                        <li>
                                            <?php if(config('adminlte.logout_method') == 'GET' || !config('adminlte.logout_method') && version_compare(\Illuminate\Foundation\Application::VERSION, '5.3.0', '<')): ?>
                                                <a href="<?php echo e(url(config('adminlte.logout_url', 'auth/logout'))); ?>">
                                                    <i class="fa fa-fw fa-power-off"></i> <?php echo e(trans('adminlte::adminlte.log_out')); ?>

                                                </a>
                                            <?php else: ?>
                                                <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                                    <i class="fa fa-fw fa-power-off"></i> <?php echo e(trans('adminlte::adminlte.log_out')); ?>

                                                </a>
                                                <form id="logout-form"
                                                      action="<?php echo e(url(config('adminlte.logout_url', 'auth/logout'))); ?>"
                                                      method="POST" class="display-none">
                                                    <?php if(config('adminlte.logout_method')): ?>
                                                        <?php echo e(method_field(config('adminlte.logout_method'))); ?>

                                                    <?php endif; ?>
                                                    <?php echo e(csrf_field()); ?>

                                                </form>
                                            <?php endif; ?>
                                        </li>
                                    <?php if(config('adminlte.right_sidebar') and (config('adminlte.layout') != 'top-nav')): ?>
                                        <!-- Control Sidebar Toggle Button -->
                                            <li>
                                                <a href="#" data-toggle="control-sidebar"
                                                   <?php if(!config('adminlte.right_sidebar_slide')): ?> data-controlsidebar-slide="false" <?php endif; ?>>
                                                    <i class="<?php echo e(config('adminlte.right_sidebar_icon')); ?>"></i>
                                                </a>
                                            </li>
                                        <?php endif; ?>
                                    </ul>
                                </div>
                            <?php if(config('adminlte.layout') == 'top-nav'): ?>
                    </div>
                    <?php endif; ?>
                </nav>
        </header>

    <?php if(config('adminlte.layout') != 'top-nav'): ?>
        <!-- Left side column. contains the logo and sidebar -->
            <aside class="main-sidebar">

                <!-- sidebar: style can be found in sidebar.less -->
                <section class="sidebar">

                    <!-- Sidebar Menu -->
                    <ul class="sidebar-menu" data-widget="tree">
                        <?php echo $__env->make('vendor.adminlte.partials.menu-item', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    </ul>
                    <!-- /.sidebar-menu -->
                </section>
                <!-- /.sidebar -->
            </aside>
    <?php endif; ?>

    <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <?php if(config('adminlte.layout') == 'top-nav'): ?>
                <div class="container">
                <?php endif; ?>

                <!-- Content Header (Page header) -->
                    <section class="content-header">
                        <h4><?php echo $__env->yieldContent('content_header'); ?></h4>
                    </section>

                    <!-- Main content -->
                    <section class="content">

                        <?php echo $__env->yieldContent('content'); ?>

                    </section>
                    <!-- /.content -->
                    <?php if(config('adminlte.layout') == 'top-nav'): ?>
                </div>
                <!-- /.container -->
            <?php endif; ?>
        </div>
        <!-- /.content-wrapper -->

        <?php if (! empty(trim($__env->yieldContent('footer')))): ?>
            <footer class="main-footer">
                <?php echo $__env->yieldContent('footer'); ?>
            </footer>
        <?php endif; ?>

        <?php if(config('adminlte.right_sidebar') and (config('adminlte.layout') != 'top-nav')): ?>
            <aside class="control-sidebar control-sidebar-<?php echo e(config('adminlte.right_sidebar_theme')); ?>">
                <?php echo $__env->yieldContent('right-sidebar'); ?>
            </aside>
            <!-- /.control-sidebar -->
            <!-- Add the sidebar's background. This div must be placed immediately after the control sidebar -->
            <div class="control-sidebar-bg"></div>
        <?php endif; ?>

    </div>
    <!-- ./wrapper -->
<?php $__env->stopSection(); ?>

<?php $__env->startSection('adminlte_js'); ?>
    <script src="<?php echo e(asset('vendor/adminlte/dist/js/adminlte.min.js')); ?>"></script>
    <?php echo $__env->yieldPushContent('js'); ?>
    <?php echo $__env->yieldContent('js'); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('adminlte::master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/cariazlj/prod.foxart.co/lapp/resources/views/vendor/adminlte/page.blade.php ENDPATH**/ ?>