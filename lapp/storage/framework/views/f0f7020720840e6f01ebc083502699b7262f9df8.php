<?php if(!is_null($ad[2])): ?>
<?php echo '<div class="container text-center mb-3">'.$ad[2].'</div>'; ?>
<?php endif; ?>

<!-- Footer Container -->
<div class="footer-container">

    <!-- Footer -->
    <footer class="page-footer">

        <!-- Footer Links -->
        <div class="container">

            <!-- Grid row -->
            <div class="row">

                <!-- Grid column -->
                <div class="col-md-3 mx-auto">
                    <strong><?php echo e($settings['site_title']); ?></strong><br /><br />
                    <?php echo e($settings['site_description']); ?><br /><br />
                    <?php if($settings['show_submission_form'] == '1'): ?>
                    <a href="<?php echo e(asset('submit-app')); ?>" class="submit-app"><?php echo app('translator')->getFromJson('general.submit_your_app'); ?></a>
                    <?php endif; ?>
                    <?php if(!empty($settings['facebook_page'])): ?><a href="<?php echo e($settings['facebook_page']); ?>" target="_blank"><i class="fab fa-facebook-f"></i></a><?php endif; ?>
                    <?php if(!empty($settings['twitter_account'])): ?><a href="<?php echo e($settings['twitter_account']); ?>" target="_blank"><i class="fab fa-twitter"></i></a><?php endif; ?>
                </div>
                <!-- /Grid column -->

                <div class="clearfix w-100 d-md-none">&nbsp;</div>

                <!-- Grid column -->
                <div class="col-md-3 col-4">
                    <a class="font-weight-bold"><?php echo app('translator')->getFromJson('general.pages'); ?></a><br /><br />
                    <ul class="list-unstyled">
                        <?php $__currentLoopData = $pages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><a href="<?php echo e(asset($settings['page_base'])); ?>/<?php echo e($page->slug); ?>"><?php echo e($page->title); ?></a></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
                <!-- /Grid column -->

                <!-- Grid column -->
                <div class="col-md-3 col-4">
                    <a class="font-weight-bold"><?php echo app('translator')->getFromJson('general.categories'); ?></a><br /><br />
                    <ul class="list-unstyled">
                        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if($category->footer == '1'): ?>
                        <li><a href="<?php echo e(asset($settings['category_base'])); ?>/<?php echo e($category->slug); ?>"><?php echo e($category->title); ?></a></li>
                        <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
                <!-- /Grid column -->

                <!-- Grid column -->
                <div class="col-md-3 col-4">
                    <a class="font-weight-bold mt-3 mb-4"><?php echo app('translator')->getFromJson('general.platforms'); ?></a><br /><br />
                    <ul class="list-unstyled">
                        <?php $__currentLoopData = $platforms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $platform): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><a href="<?php echo e(asset($settings['platform_base'])); ?>/<?php echo e($platform->slug); ?>"><?php echo e($platform->title); ?></a></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
                <!-- /Grid column -->

            </div>
            <!-- /Grid row -->

        </div>
        <!-- /Footer Links -->

        <!-- Copyright Message -->
        <div class="footer-copyright text-center py-2">© <?php echo e(date('Y')); ?> <?php echo app('translator')->getFromJson('general.copyright'); ?> -
            <a href="#"> <?php echo e($settings['site_title']); ?></a>
        </div>
        <!-- /Copyright Message -->

    </footer>
    <!-- /Footer -->

</div>
<!-- /Footer Container -->

<?php if($settings['show_cookie_bar'] == '1'): ?>
<!-- Cookie Alert -->
<div class="alert text-center cookiealert" role="alert">
    <?php echo app('translator')->getFromJson('general.cookies_note'); ?>
    <button type="button" class="btn btn-sm acceptcookies" aria-label="Close">
        <?php echo app('translator')->getFromJson('general.accept_cookies'); ?>
    </button>
</div>
<!-- /Cookie Alert -->
<?php endif; ?>

<?php echo $settings['before_body_end_tag']; ?>


<?php echo $__env->yieldPushContent('assets_footer'); ?>

<!-- Other JS -->
<script src="<?php echo e(asset('js/scripts.js')); ?>?v1.4"></script>

<!-- Bootstrap -->
<script src="<?php echo e(asset('js/bootstrap.min.js')); ?>"></script>

<!-- Cookie Alert -->
<script src="<?php echo e(asset('js/cookiealert.js')); ?>"></script>
<?php /**PATH /home/cariazlj/prod.foxart.co/lapp/resources/views/vendor/frontend/inc/footer.blade.php ENDPATH**/ ?>