<?php echo $settings['after_head_tag']; ?>


<!-- Header Container -->
<div class="header-container">
    <div class="container">
        <header class="site-header pt-2 pb-2">
            <div class="row flex-nowrap justify-content-between align-items-center">
                <div class="col-6">
                    <h1 class="site-header-logo"><a href="<?php echo e(asset('')); ?>"><?php if($settings['use_text_logo'] == '0'): ?><img src="/images/logo.png" alt="<?php echo e($settings['site_title']); ?>" class="img-fluid"><?php else: ?><?php echo e($settings['site_title']); ?><?php endif; ?></a></h1>
                </div>
                <div class="col-6 d-flex justify-content-end align-items-center">
                    <div class="headersm">
                        <a href="javascript:void(0);" onclick="SearchBox()"><i class="fas fa-search"></i></a>
                        <?php if(!empty($settings['facebook_page'])): ?><a href="<?php echo e($settings['facebook_page']); ?>" target="_blank"><i class="fab fa-facebook-f"></i></a><?php endif; ?>
                        <?php if(!empty($settings['twitter_account'])): ?><a href="https://www.twitter.com/<?php echo e($settings['twitter_account']); ?>" target="_blank"><i class="fab fa-twitter"></i></a><?php endif; ?>
                        <?php if($settings['random_app_link'] == '1'): ?><a href="<?php echo e(asset($settings['app_base'].'/random')); ?>"><i class="fas fa-random"></i></a><?php endif; ?>
                        <?php if(!empty($settings['show_rss_feed'])): ?><a href="<?php echo e(asset('rss')); ?>" target="_blank"><i class="fas fa-rss"></i></a><?php endif; ?>
                    </div>
                </div>
            </div>
        </header>
    </div>
</div>
<!-- /Header Container -->

<!-- Nav Container -->
<div class="nav-container nav-bg-<?php echo e($settings['navbar_color']); ?>">
    <div class="container">
        <div class="nav-scroller">
            <nav class="nav d-flex">
                <a class="pr-2 pt-2" href="<?php echo e(asset('')); ?>"><i class="fa fa-home"></i> <?php echo app('translator')->getFromJson('general.homepage'); ?></a>
                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if($category->navbar == '1'): ?>
                <a href="<?php echo e(asset($settings['category_base'])); ?>/<?php echo e($category->slug); ?>"><?php if(!empty($category->fa_icon)): ?><i class="<?php echo e($category->fa_icon); ?>"></i> <?php endif; ?><?php echo e($category->title); ?></a>
                <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </nav>
        </div>
    </div>
</div>
<!-- /Nav Container -->

<!-- Search Box -->
<div id="SearchBox" class="overlaymenu">
    <a href="javascript:void(0)" class="closebtn" onclick="closeSearchBox()">&times;</a>
    <div class="overlay-content-search">
        <div class="container">
            <form method="post" action="<?php echo e(asset('search')); ?>">
                <?php echo e(csrf_field()); ?>

                <div class="row justify-content-center">
                    <div class="md-form mt-0">
                        <input class="form-control form-control-lg" type="text" name="term" id="term" placeholder="<?php echo app('translator')->getFromJson('general.search_apps'); ?>" aria-label="<?php echo app('translator')->getFromJson('general.search_apps'); ?>">
                    </div>
                    <div class="col-auto">
                        <button class="sbtn btn-lg" type="submit"><?php echo app('translator')->getFromJson('general.search'); ?></button>
                    </div>
                </div>

                <?php if(!empty($settings['recommended_terms'])): ?>
                <?php $terms = explode(",", $settings['recommended_terms']); ?>
                <?php if(count($terms) > 0): ?>

                <div class="d-flex justify-content-center">
                <div class="recommended-terms mt-1" id="terms">
                    <strong><?php echo app('translator')->getFromJson('general.recommended_terms'); ?></strong>
                    <?php $__currentLoopData = $terms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $term): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <a href="#"><?php echo e($term); ?></a>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>

                <?php endif; ?>
                <?php endif; ?>

            </form>
        </div>
    </div>
</div>
<!-- /Search Box -->

<?php if(!is_null($ad[1])): ?>
<?php echo '<div class="container text-center mt-3">'.$ad[1].'</div>'; ?>
<?php endif; ?><?php /**PATH /home/cariazlj/prod.foxart.co/lapp/resources/views/vendor/frontend/inc/header.blade.php ENDPATH**/ ?>