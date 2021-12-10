<?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<?php $category_name[$category->id]=$category->title; ?>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

<?php if($type =='1' OR $type =='2' OR $type =='3'): ?>
<?php if(count($popular_apps) > 0): ?>

<div class="top-title">
    <?php if($type =='1'): ?>
    <?php echo app('translator')->getFromJson('general.popular_downloads'); ?>
    <?php endif; ?>
    <?php if($type =='2'): ?>
    <?php echo app('translator')->getFromJson('general.popular_downloads_category'); ?>
    <?php endif; ?>
    <?php if($type =='3'): ?>
    <?php echo app('translator')->getFromJson('general.popular_downloads_platform'); ?>
    <?php endif; ?> <i class="fas fa-angle-down float-right"></i></div>

<div class="row apps top mt-2">
    <?php $i = 1; ?>

    <?php $__currentLoopData = $popular_apps; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $app): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

    <?php if(empty($app->image)): ?>
    <?php $app->image='no_image.png'; ?>
    <?php endif; ?>

    <div class="col-md-12 col-12">
        <div class="d-flex <?php if($loop->last): ?> mb-0 pb-0 border-0 <?php endif; ?>">
            <div class="my-auto">
                <div
                    class="rank <?php if($i <= '3'): ?>green <?php else: ?> pink <?php endif; ?>">
                    <?php echo e($loop->iteration); ?></div>
            </div>
            <div class="mr-2"><a href="<?php echo e(asset($settings['app_base'])); ?>/<?php echo e($app->slug); ?>"><img
                        src="<?php echo e(asset('images')); ?>/<?php echo e($app->image); ?>" class="image rounded"></a></div>
            <div class="box"><a href="<?php echo e(asset($settings['app_base'])); ?>/<?php echo e($app->slug); ?>" class="title"><?php echo e($app->title); ?></a>

                <div class="stars">
                    <?php for($x = 1; $x <= 5; $x++): ?> <?php if($x<=round($app->votes)): ?>
                        <span class="fa fa-star checked"></span>
                        <?php else: ?>
                        <span class="fa fa-star"></span>
                        <?php endif; ?>
                        <?php endfor; ?>
                </div>

                <span class="category"><?php echo e($category_name[$app->category]); ?></span>

            </div>
        </div>
    </div>
    <?php $i++; ?>

    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>
<?php endif; ?>
<?php endif; ?>

<?php if($type =='4'): ?>

<?php if(count($editors_choice) > 0): ?>
<div class="top-title mt-3"><?php echo app('translator')->getFromJson('general.editors_choice'); ?><i class="fas fa-medal float-right"></i></div>

<div class="row apps top mt-2">
    <?php $i = 1; ?>

    <?php $__currentLoopData = $editors_choice; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $app): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

    <?php if(empty($app->image)): ?>
    <?php $app->image='no_image.png'; ?>
    <?php endif; ?>

    <div class="col-md-12 col-12">
        <div class="d-flex <?php if($loop->last): ?> mb-0 pb-0 border-0 <?php endif; ?>">
            <div class="pr-2"><a href="<?php echo e(asset($settings['app_base'])); ?>/<?php echo e($app->slug); ?>"><img
                        src="<?php echo e(asset('images')); ?>/<?php echo e($app->image); ?>" class="image rounded"></a></div>
            <div class="box"><a href="<?php echo e(asset($settings['app_base'])); ?>/<?php echo e($app->slug); ?>" class="title"><?php echo e($app->title); ?></a>

                <div class="stars">
                    <?php for($i = 1; $i <= 5; $i++): ?> <?php if($i<=round($app->votes)): ?>
                        <span class="fa fa-star editor-star checked"></span>
                        <?php else: ?>
                        <span class="fa fa-star"></span>
                        <?php endif; ?>
                        <?php endfor; ?>
                </div>

                <span class="category"><?php echo e($category_name[$app->category]); ?></span>

            </div>
        </div>
    </div>
    <?php $i++; ?>

    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>
<?php endif; ?>
<?php endif; ?><?php /**PATH /home/cariazlj/prod.foxart.co/lapp/resources/views/vendor/frontend/inc/top.blade.php ENDPATH**/ ?>