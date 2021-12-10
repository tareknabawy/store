<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<?php echo \MetaTag::setPath()
->setDefault(['robots' => 'follow', 'canonical' => url()->current()])
->setDefault(['og_site_name' => $settings['site_title']])
->setDefault(['og_locale' => $locale_tags[$settings['site_language']]])
->render(); ?>

<?php if(\Request::is("$settings[app_base]/*")): ?>
<?php echo $schema_data->toScript(); ?>

<?php endif; ?>

<meta name="csrf-token" content="<?php echo e(csrf_token()); ?>" />
<link rel="alternate" type="application/rss+xml" title="<?php echo e($settings['site_title']); ?>" href="<?php echo e(asset('rss')); ?>" />
<link rel="icon" type="image/png" href="<?php echo e(asset('images/favicon.png')); ?>" />

<!-- Bootstrap 4.3.1 -->
<link href="<?php echo e(asset('css/bootstrap.min.css')); ?>" rel="stylesheet">
<!-- Common Styles -->
<link href="<?php echo e(asset('css/app.css')); ?>?v1.4" rel="stylesheet">
<!-- jQuery -->
<script src="<?php echo e(asset('js/jquery-3.4.1.min.js')); ?>"></script>
<!-- Other JS -->
<script src="<?php echo e(asset('js/other.js')); ?>?v1.4"></script>
<?php echo $__env->yieldPushContent('assets_header'); ?>
<!-- Font Awesome -->
<link href="<?php echo e(asset('css/all.css')); ?>" rel="stylesheet">

<?php echo $settings['before_head_tag']; ?><?php /**PATH /home/cariazlj/prod.foxart.co/lapp/resources/views/vendor/frontend/inc/head.blade.php ENDPATH**/ ?>