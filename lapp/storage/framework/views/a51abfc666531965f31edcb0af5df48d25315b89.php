<?php $__env->startPush('assets_header'); ?>
<!-- Swiper CSS -->
<link href="<?php echo e(asset('css/swiper.min.css')); ?>" rel="stylesheet">
<?php $__env->stopPush(); ?>

<?php $__env->startPush('assets_footer'); ?>
<!-- Swiper JS -->
<script src="<?php echo e(asset('js/swiper.min.js')); ?>"></script>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>

<!-- Big Container -->
<div class="big-container mt-3">

    <!-- Container -->
    <div class="container">

        <!-- Grid row -->
        <div class="row">

            <!-- Grid column -->
            <div class="col-md-8 mb-3">

                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php $category_name[$category->id]=$category->title; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                <?php if(!is_null($ad[5])): ?>
                <div class="mb-3"><?php echo $ad[5]; ?></div><?php endif; ?>

                <?php if(count($sliders) > 0): ?>
                <!-- Main Slider -->
                <div class="swiper-container swiper-main">
                    <div class="swiper-wrapper">
                        <?php $__currentLoopData = $sliders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slider): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                        <div class="swiper-slide">
                            <a href="<?php echo e(asset($settings['app_base'])); ?>/<?php echo e($slider->slug); ?>">
                                <div class="coverbg"></div>
                                <h3><?php echo e($slider->title); ?></h3>
                                <img src="<?php echo e(asset('images')); ?>/sliders/<?php echo e($slider->image); ?>" alt="">
                            </a>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    </div>
                    <div class="swiper-button-next swiper-button-white"></div>
                    <div class="swiper-button-prev swiper-button-white"></div>
                </div>
                <div class="swiper-pagination-main mt-3 mb-3"></div>
                <!-- /Main Slider -->
                <?php endif; ?>

                <?php if(!is_null($ad[9])): ?><div class="mb-3 mt-3"><?php echo $ad[9]; ?></div><?php endif; ?>

                <?php if(count($apps) > 0): ?>
                <!-- New Apps -->
                <div class="d-flex top-title justify-content-between mb-3 mt-3">
                    <div><?php echo app('translator')->getFromJson('general.new_apps'); ?></div>
                    <div><a href="<?php echo e(asset('new-apps')); ?>"><?php echo app('translator')->getFromJson('general.more'); ?> »</a></div>
                </div>

                <div class="row apps mb-1">
                    <?php $__currentLoopData = $apps; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $app): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                    <?php if(empty($app->image)): ?>
                    <?php $app->image='no_image.png'; ?>
                    <?php endif; ?>

                    <div class="col-4 mb-2">
                        <div class="d-flex flex-sm-row flex-column">
                            <div class="pr-2 mb-1"><a href="<?php echo e(asset($settings['app_base'])); ?>/<?php echo e($app->slug); ?>"><img
                                        src="<?php echo e(asset('images')); ?>/<?php echo e($app->image); ?>" class="image rounded"></a></div>
                            <div class="box"><a href="<?php echo e(asset($settings['app_base'])); ?>/<?php echo e($app->slug); ?>"
                                    class="title"><?php echo e($app->title); ?></a>

                                <div class="stars">
                                    <?php for($i = 1; $i <= 5; $i++): ?> <?php if($i<=round($app->votes)): ?>
                                        <span class="fa fa-star checked"></span>
                                        <?php else: ?>
                                        <span class="fa fa-star"></span>
                                        <?php endif; ?>
                                        <?php endfor; ?>
                                </div>

                                <span
                                    class="category"><?php echo e(\Carbon\Carbon::parse($app->created_at)->translatedFormat('M d, Y')); ?></span>
                                <span class="license"><?php echo e($app->license); ?></span>

                            </div>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                </div>
                <!-- /New Apps -->
                <?php endif; ?>

                <?php if(!is_null($ad[10])): ?><div class="mb-3 mt-1"><?php echo $ad[10]; ?></div><?php endif; ?>

                <?php if(count($latest_news) > 0): ?>
                <!-- Tech News -->
                <div class="d-flex top-title justify-content-between mb-3">
                    <div><?php echo app('translator')->getFromJson('general.tech_news'); ?></div>
                    <div><a href="<?php echo e(asset($settings['news_base'])); ?>"><?php echo app('translator')->getFromJson('general.more_news'); ?> »</a></div>
                </div>

                <div class="row news">

                    <?php $__currentLoopData = $latest_news; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $news): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                    <div class="col-md-6 col-12 mb-3 <?php if($key++ % 2 != 1): ?> pr-md-2 <?php else: ?> pl-md-2 <?php endif; ?>">
                        <div class="news-box">
                            <a href="<?php echo e(asset($settings['news_base'])); ?>/<?php echo e($news->slug); ?>">
                                <div class="news-cover"></div>
                                <h4><?php echo e($news->title); ?></h4>
                                <img src="<?php echo e(asset('images')); ?>/news/<?php echo e($news->image); ?>" class="img-fluid" alt="">
                            </a>
                        </div>
                    </div>

                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                </div>
                <!-- /Tech news -->
                <?php endif; ?>

                <?php if(!is_null($ad[11])): ?><div class="mb-3"><?php echo $ad[11]; ?></div><?php endif; ?>

                <?php if(count($featured_apps) > 0): ?>
                <!-- Featured apps -->
                <div class="d-flex top-title justify-content-between">
                    <div><?php echo app('translator')->getFromJson('general.featured_apps'); ?></div>
                    <div><a href="<?php echo e(asset('featured-apps')); ?>"><?php echo app('translator')->getFromJson('general.more'); ?> »</a></div>
                </div>

                <div class="featured-apps page-left mr-3 ml-3">
                    <div class="row flex-nowrap mb-1 pb-2">
                        <?php $__currentLoopData = $featured_apps; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $app_category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                        <?php if(empty($app_category->image)): ?>
                        <?php $app_category->image='no_image.png'; ?>
                        <?php endif; ?>

                        <div class="col-half p-2 <?php if($loop->last): ?> mr-0 <?php endif; ?>"><a
                                href="<?php echo e(asset($settings['app_base'])); ?>/<?php echo e($app_category->slug); ?>"><img
                                    src="<?php echo e(asset('images')); ?>/<?php echo e($app_category->image); ?>"
                                    class="img-fluid rounded"><span><?php echo e($app_category->title); ?></span></a></div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
                <!-- /Featured apps -->
                <?php endif; ?>

                <?php if(!is_null($ad[12])): ?><div class="mt-3"><?php echo $ad[12]; ?></div><?php endif; ?>

                <?php if(count($must_have_apps) > 0): ?>
                <!-- Must-Have Apps -->
                <div class="d-flex top-title justify-content-between mb-3 mt-3">
                    <div><?php echo app('translator')->getFromJson('general.must_have_apps'); ?></div>
                    <div><a href="<?php echo e(asset('must-have-apps')); ?>"><?php echo app('translator')->getFromJson('general.more'); ?> »</a></div>
                </div>

                <div class="row apps">
                    <?php $__currentLoopData = $must_have_apps; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $app): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                    <?php if(empty($app->image)): ?>
                    <?php $app->image='no_image.png'; ?>
                    <?php endif; ?>

                    <div class="col-4 mb-2">
                        <div class="d-flex flex-sm-row flex-column">
                            <div class="pr-2 mb-1"><a href="<?php echo e(asset($settings['app_base'])); ?>/<?php echo e($app->slug); ?>"><img
                                        src="<?php echo e(asset('images')); ?>/<?php echo e($app->image); ?>" class="image rounded"></a></div>
                            <div class="box"><a href="<?php echo e(asset($settings['app_base'])); ?>/<?php echo e($app->slug); ?>"
                                    class="title"><?php echo e($app->title); ?></a>

                                <div class="stars">
                                    <?php for($i = 1; $i <= 5; $i++): ?> <?php if($i<=round($app->votes)): ?>
                                        <span class="fa fa-star checked"></span>
                                        <?php else: ?>
                                        <span class="fa fa-star"></span>
                                        <?php endif; ?>
                                        <?php endfor; ?>
                                </div>

                                <span class="category"><?php echo e($category_name[$app->category]); ?></span>
                                <span class="license"><?php echo e($app->license); ?></span>

                            </div>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                </div>
                <!-- /Must-Have Apps -->
                <?php endif; ?>

                <?php if(!is_null($ad[13])): ?><div class="mb-3 mt-1"><?php echo $ad[13]; ?></div><?php endif; ?>

                <?php if(count($all_topics) > 0): ?>
                <!-- Topics -->
                <div class="d-flex top-title justify-content-between mt-2">
                    <div><?php echo app('translator')->getFromJson('general.topics'); ?></div>
                    <div><a href="<?php echo e(asset($settings['topic_base'])); ?>"><?php echo app('translator')->getFromJson('general.more_topics'); ?> »</a></div>
                </div>

                <div class="topics-home mr-3 ml-3">

                    <div class="row flex-nowrap topics">

                        <?php $__currentLoopData = $all_topics; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $topics): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                        <div class="col-topic p-3 <?php if($loop->last): ?> mr-0 <?php endif; ?>">

                            <a href="<?php echo e(asset($settings['topic_base'])); ?>/<?php echo e($topics->slug); ?>">
                                <img src="<?php echo e(asset('images')); ?>/topics/<?php echo e($topics->image); ?>" class="img-fluid" alt="">
                            </a>
                            <div class="topic-box">
                                <a href="<?php echo e(asset($settings['topic_base'])); ?>/<?php echo e($topics->slug); ?>">
                                    <?php echo e($topics->title); ?>

                                </a>
                            </div>
                        </div>

                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    </div>
                </div>
                <!-- /Tppics -->
                <?php endif; ?>

                <?php if(!is_null($ad[15])): ?><div class="mb-3 mt-1"><?php echo $ad[15]; ?></div><?php endif; ?>     

                <?php if(count($apps_24_hours) > 0): ?>
                <!-- Popular apps in last 24 hours -->
                <div class="d-flex top-title justify-content-between mt-1 mb-3">
                    <div><?php echo app('translator')->getFromJson('general.popular_apps_24_hours'); ?></div>
                    <div><a href="<?php echo e(asset('popular-apps-in-last-24-hours')); ?>"><?php echo app('translator')->getFromJson('general.more'); ?> »</a></div>
                </div>

                <div class="row apps mb-1">
                    <?php $x=1; ?>
                    <?php $__currentLoopData = $apps_24_hours; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $app): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                    <?php if(empty($app->image)): ?>
                    <?php $app->image='no_image.png'; ?>
                    <?php endif; ?>

                    <?php if($x<=9): ?> <div class="col-4 mb-2">
                        <div class="d-flex flex-sm-row flex-column">
                            <div class="pr-2 mb-1"><a href="<?php echo e(asset($settings['app_base'])); ?>/<?php echo e($app->slug); ?>"><img
                                        src="<?php echo e(asset('images')); ?>/<?php echo e($app->image); ?>" class="image rounded"></a></div>
                            <div class="box"><a href="<?php echo e(asset($settings['app_base'])); ?>/<?php echo e($app->slug); ?>"
                                    class="title"><?php echo e($app->title); ?></a>

                                <div class="stars">
                                    <?php for($i = 1; $i <= 5; $i++): ?> <?php if($i<=round($app->votes)): ?>
                                        <span class="fa fa-star checked"></span>
                                        <?php else: ?>
                                        <span class="fa fa-star"></span>
                                        <?php endif; ?>
                                        <?php endfor; ?>
                                </div>

                                <span class="category"><?php echo e($category_name[$app->category]); ?></span>
                                <span class="license"><?php echo e($app->license); ?></span>

                            </div>
                        </div>
                </div>
                <?php endif; ?>
                <?php $x++; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            </div>
            <!-- /Popular apps in last 24 hours -->
            <?php endif; ?>

            <?php if(!is_null($ad[6])): ?><?php echo $ad[6]; ?><?php endif; ?>


        </div>
        <!-- /Grid column -->

        <!-- Grid column -->
        <div class="col-md-4 bl-1 mb-3">
            <?php if(!is_null($ad[3])): ?><div class="mb-3"><?php echo $ad[3]; ?></div><?php endif; ?>
            <?php echo $__env->make('frontend::inc.top', ['type' => '1'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php if(!is_null($ad[4])): ?><div class="mt-3"><?php echo $ad[4]; ?></div><?php endif; ?>
            <?php echo $__env->make('frontend::inc.top', ['type' => '4'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php if(!is_null($ad[14])): ?><div class="mt-3"><?php echo $ad[14]; ?></div><?php endif; ?>
        </div>
        <!-- /Grid column -->

    </div>
    <!-- /Grid row -->

</div>
<!-- /Container -->

</div>
<!-- /Big Container -->

<?php $__env->stopSection(); ?>
<?php echo $__env->make('frontend::page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/cariazlj/prod.foxart.co/lapp/resources/views/vendor/frontend/site.blade.php ENDPATH**/ ?>