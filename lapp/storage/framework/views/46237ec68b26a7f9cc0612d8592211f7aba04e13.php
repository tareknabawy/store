<?php $__env->startPush('assets_header'); ?>
<!-- Lity CSS -->
<link href="<?php echo e(asset('css/simpleLightbox.min.css')); ?>" rel="stylesheet">
<?php $__env->stopPush(); ?>

<?php $__env->startPush('assets_footer'); ?>
<!-- Popper -->
<script src="<?php echo e(asset('js/popper.min.js')); ?>"></script>

<!-- Lity JS -->
<script src="<?php echo e(asset('js/simpleLightbox.min.js')); ?>"></script>

<!-- Rating JS -->
<script src="<?php echo e(asset('js/rating.js')); ?>"></script>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>

<!-- Big Container -->
<div class="big-container mt-3">

    <!-- Container -->
    <div class="container">

        <!-- Grid row -->
        <div class="row">

            <!-- Grid column -->
            <div class="col-md-8 page-content mb-3">

                <?php if(!is_null($ad[5])): ?>
                <div class="mb-3"><?php echo $ad[5]; ?></div><?php endif; ?>

                <?php if($settings['breadcrumbs'] == '1'): ?>
                <div class="breadcrumbs mb-3">
                    <a href="<?php echo e(asset('')); ?>"><?php echo app('translator')->getFromJson('general.homepage'); ?></a> » <a href="<?php echo e(asset($settings['platform_base'])); ?>/<?php echo e($data_to_pass['platform_slug']); ?>"><?php echo e($data_to_pass['platform_name']); ?></a> » <a href="<?php echo e(asset($settings['category_base'])); ?>/<?php echo e($data_to_pass['category_slug']); ?>"><?php echo e($data_to_pass['category_name']); ?></a> » <a href="<?php echo e(url()->current()); ?>"><?php echo e($app_query->title); ?></a>
                </div>

                <?php if($settings['schema_breadcrumbs'] == '1'): ?>
                <?php echo $breadcrumb_schema_data->toScript(); ?>

                <?php endif; ?>

                <?php endif; ?>

                <div class="d-flex flex-row app-info">

                    <div class="mr-2"><img src="<?php echo e(asset('images')); ?>/<?php echo e($app_query->image); ?>" class="float-left pimage">
                    </div>

                    <div>
                        <h2><?php echo e($app_query->title); ?></h2>

                        <span class="voteinfo"></span>
                        <div><?php echo app('translator')->getFromJson('general.rating'); ?>: <strong><?php echo e($app_query->votes); ?></strong> (<?php echo app('translator')->getFromJson('general.votes'); ?>:
                            <?php echo e($app_query->total_votes); ?>)
                        </div>

                        <div class="ratings" id="rating" data-rating-id="<?php echo e($app_query->id); ?>">
                            <?php for($i = 1; $i <= 5; $i++): ?> <?php if($i<=round($app_query->votes)): ?>
                                <input type="radio" name="vote" class="rating" value="<?php echo e($i); ?>" checked="checked" />
                                <?php else: ?>
                                <input type="radio" name="vote" class="rating" value="<?php echo e($i); ?>" />
                                <?php endif; ?>
                                <?php endfor; ?>
                        </div>

                    </div>
                </div>

                <div class="container mt-3 smi">
                    <div class="row">
                        <div class="col text-center p-2 facebook"><a onclick="sm_share('https://www.facebook.com/sharer/sharer.php?u=<?php echo e(url()->current()); ?>','Facebook','600','300');" href="javascript:void(0);"><i class="fab fa-facebook-f ml-2"></i> <span class="d-none d-lg-inline-block">Facebook</span></a></div>
                        <div class="col text-center p-2 twitter"><a onclick="sm_share('http://twitter.com/share?text=<?php echo e($app_query->title); ?>&url=<?php echo e(url()->current()); ?>','Twitter','600','300');" href="javascript:void(0);"><i class="fab fa-twitter ml-2"></i> <span class="d-none d-lg-inline-block">Twitter</span></a></div>
                        <div class="col text-center p-2 linkedin"><a onclick="sm_share('https://www.linkedin.com/sharing/share-offsite/?url=<?php echo e(url()->current()); ?>','Linkedin','600','300');" href="javascript:void(0);"><i class="fab fa-linkedin-in ml-2"></i> <span class="d-none d-lg-inline-block">Linkedin</span></a></div>
                        <div class="col text-center p-2 email"><a href="mailto:?subject=<?php echo e($app_query->title); ?>&amp;body=<?php echo e(url()->current()); ?>"><i class="fas fa-envelope ml-2"></i> <span class="d-none d-lg-inline-block">E-mail</span></a></div>
                        <div class="col text-center p-2 whatsapp"><a onclick="sm_share('https://api.whatsapp.com/send?text=<?php echo e($app_query->title); ?> <?php echo e(url()->current()); ?>','WhatsApp','700','650');" href="javascript:void(0);"><i class="fab fa-whatsapp ml-2"></i> <span class="d-none d-lg-inline-block">WhatsApp</span></a></div>
                    </div>
                </div>


                <?php if($app_query->screenshots != ""): ?>
                <div class="container screenshots mt-3">
                    <div class="row">

                        <div id="left"><i class="fas fa-angle-left"></i></div>
                        <div id="right"><i class="fas fa-angle-right"></i></div>

                        <div id="screenshot-main">

                            <?php $__currentLoopData = $screenshot_data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image_name): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <a href="<?php echo e(asset('screenshots')); ?>/<?php echo e($image_name); ?>"><img src="<?php echo e(asset('screenshots')); ?>/<?php echo e($image_name); ?>" class="mr-1"></a>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        </div>
                    </div>
                </div>
                <?php endif; ?>

                <div class="description" id="description" data-show-more="<?php echo app('translator')->getFromJson('general.show_more'); ?>" data-show-less="<?php echo app('translator')->getFromJson('general.show_less'); ?>">

                    <p><?php echo e($app_query->description); ?></p>
                    <?php echo $app_query->details; ?>


                </div>

                <?php if(isset($app_query->tags)): ?>
                <?php if(count($app_query->tags) > 0): ?>

                <div class="tags pt-3">
                    <span><?php echo app('translator')->getFromJson('general.tags'); ?></span>
                    <ul>

                        <?php $__currentLoopData = $app_query->tags; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><a href="<?php echo e(asset($settings['tag_base'])); ?>/<?php echo e($tag['slug']); ?>"><?php echo e($tag['name']); ?></a></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    </ul>
                </div>

                <?php endif; ?>
                <?php endif; ?>

                <div class="review-title mt-3 pt-3"><?php echo app('translator')->getFromJson('general.user_reviews'); ?><a href="#" class="add-comment btn btn-success float-right"><?php echo app('translator')->getFromJson('general.add_comment_review'); ?></a>
                    <div class="stars">
                        <?php for($i = 1; $i <= 5; $i++): ?> <?php if($i<=round($app_query->votes)): ?>
                            <span class="fa fa-star checked"></span>
                            <?php else: ?>
                            <span class="fa fa-star"></span>
                            <?php endif; ?>
                            <?php endfor; ?>
                    </div>
                </div>

                <div class="user-votes-total mt-2"><?php echo app('translator')->getFromJson('general.based_on'); ?> <?php echo e($app_query->total_votes); ?>

                    <?php echo app('translator')->getFromJson('general.votes'); ?> <?php echo app('translator')->getFromJson('general.and'); ?>
                    <?php echo e($data_to_pass['total_comments']); ?> <?php echo app('translator')->getFromJson('general.user_reviews'); ?></div>

                <div class="user-ratings container mt-3">

                    <?php $__currentLoopData = $comment_order; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rating => $total_rating): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                    <?php $bar_length=@(100/$data_to_pass[total_comments])*$total_rating; ?>

                    <div class="row">
                        <div class="col-2 p-0 rating"><?php echo e(trans_choice('general.star', $rating)); ?></div>
                        <div class="col-9">
                            <div class="progress" data-bar-width="<?php echo e($bar_length); ?>">
                                <div class="progress-bar"></div>
                            </div>
                        </div>
                        <div class="col-1 p-0 votes text-center"><?php echo e($total_rating); ?></div>
                    </div>

                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                </div>

                <div class="user-reviews">

                    <?php if($app_comments->isEmpty()): ?>
                    <div class="alert alert-info show mt-1" role="alert"><?php echo app('translator')->getFromJson('general.no_reviews_yet'); ?></div>
                    <?php endif; ?>

                    <?php $__currentLoopData = $app_comments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $comment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                    <div class="review mt-2">
                        <p class="title">"<?php echo e($comment->title); ?>"</p>
                        <div class="row">
                            <div class="col-6">
                                <p class="name"><?php echo e($comment->name); ?></p>
                            </div>
                            <div class="col-6">
                                <div class="stars float-right">
                                    <?php for($i = 1; $i <= 5; $i++): ?> <?php if($i<=round($comment->rating)): ?>
                                        <span class="fa fa-star checked"></span>
                                        <?php else: ?>
                                        <span class="fa fa-star"></span>
                                        <?php endif; ?>
                                        <?php endfor; ?>
                                </div>
                            </div>
                        </div>
                        <p class="date" data-toggle="tooltip" title="<?php echo e(\Carbon\Carbon::parse($comment->created_at)->translatedFormat('F d, Y H:i:s')); ?>">
                            <?php echo e(\Carbon\Carbon::parse($comment->created_at)->diffForHumans()); ?></p>

                        <p class="comment"><?php echo e($comment->comment); ?></p>
                    </div>

                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    <?php if(count($app_comments) > '3'): ?>
                    <div class="rm-link show-more"><?php echo app('translator')->getFromJson('general.show_more'); ?></div>
                    <?php endif; ?>

                    <div class="comment-box" id="comment-section" data-fill-all-fields="<?php echo app('translator')->getFromJson('general.fill_all_fields'); ?>">

                        <form id="comment-form">

                            <div class="review-title mt-3 mb-2 pt-3" id="review-title">
                                <?php echo app('translator')->getFromJson('general.add_comment_review'); ?></div>

                            <input type="hidden" name="app_id" value="<?php echo e($app_query->id); ?>" />

                            <div class="form-group">
                                <label for="name"><?php echo app('translator')->getFromJson('general.your_name'); ?>: <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>

                            <div class="form-group">
                                <label for="title"><?php echo app('translator')->getFromJson('general.comment_title'); ?>: <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="title" name="title" required>
                            </div>

                            <div class="form-group">
                                <label for="email"><?php echo app('translator')->getFromJson('general.your_email'); ?>: <span class="text-danger">*</span></label>
                                <input type="email" class="form-control" id="email" name="email" required>
                                <small id="emailHelp" class="form-text text-muted"><?php echo app('translator')->getFromJson('general.email_notification'); ?></small>
                            </div>

                            <div class="form-group">
                                <label for="comment"><?php echo app('translator')->getFromJson('general.your_comment'); ?>: <span class="text-danger">*</span></label>
                                <textarea class="form-control" rows="5" id="comment" name="comment" maxlength="1000" required></textarea>
                            </div>

                            <div class="form-group">
                                <label for="rating"><?php echo app('translator')->getFromJson('general.your_rating'); ?>: <span class="text-danger">*</span></label>
                                <div class="form-check-inlin user_ratings">
                                    <input type="radio" id="user_rating" name="user_rating" value="1">
                                    <input type="radio" id="user_rating" name="user_rating" value="2">
                                    <input type="radio" id="user_rating" name="user_rating" value="3">
                                    <input type="radio" id="user_rating" name="user_rating" value="4">
                                    <input type="radio" id="user_rating" name="user_rating" value="5" checked>
                                </div>
                                <div class="clearfix"></div>
                            </div>

                        </form>

                        <button type="submit" class="btn m-0 comment-button" onclick="form_control()"><?php echo app('translator')->getFromJson('general.submit'); ?></button>

                        <div id="comment_result">
                            <div class="alert alert-warning show mt-3" role="alert">
                                <?php echo app('translator')->getFromJson('general.comment_rules'); ?></div>
                        </div>

                    </div>
                </div>

                <?php if(count($latest_news) > 0): ?>
                <!-- Tech News -->
                <div class="d-flex top-title justify-content-between mb-3 mt-3">
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

                <!-- Other Apps in This Category -->
                <div class="d-flex top-title justify-content-between">
                    <div><?php echo app('translator')->getFromJson('general.other_apps_in_category'); ?></div>
                    <div>
                        <a href="<?php echo e(asset('category')); ?>/<?php echo e($data_to_pass['category_slug']); ?>"><?php echo app('translator')->getFromJson('general.more'); ?>
                            »</a></div>
                </div>

                <div class="featured-apps mr-3 ml-3">
                    <div class="row flex-nowrap page-left mb-1 pb-2">
                        <?php $__currentLoopData = $apps_category; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $app_category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                        <?php if(empty($app_category->image)): ?>
                        <?php $app_category->image='no_image.png'; ?>
                        <?php endif; ?>

                        <div class="col-half p-2 <?php if($loop->last): ?> mr-0 <?php endif; ?>"><a href="<?php echo e(asset($settings['app_base'])); ?>/<?php echo e($app_category->slug); ?>"><img src="<?php echo e(asset('images')); ?>/<?php echo e($app_category->image); ?>" class="img-fluid rounded"><span><?php echo e($app_category->title); ?></span></a>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>

                </div>
                <!-- /Other Apps in This Category -->

                <?php if(!is_null($ad[6])): ?><div class="mt-3"><?php echo $ad[6]; ?></div><?php endif; ?>

            </div>
            <!-- /Grid column -->

            <!-- Grid column -->
            <div class="col-md-4 bl-1 mb-3">

                <div id="move_item"></div>

                <div id="download_section">
                    <div class="download">

                        <?php if($app_query->type=='1'): ?>
                        <a href="<?php echo e(url('/redirect/' . $app_query->slug)); ?>" class="btn m-0"><i class="fas fa-download"></i>
                            <?php echo app('translator')->getFromJson('general.download_now'); ?></a>
                        <?php else: ?>
                        <a href="<?php echo e(url('/redirect/' . $app_query->slug)); ?>" class="btn m-0"><i class="fas fa-external-link-alt"></i> <?php echo app('translator')->getFromJson('general.visit_page'); ?></a>
                        <?php endif; ?>

                        <?php if(!empty($app_query->buy_url)): ?>
                        <a href="<?php echo e($app_query->buy_url); ?>" target="_blank" class="btn buy-btn mt-3"><i class="fas fa-tag"></i>
                            <?php echo app('translator')->getFromJson('general.buy_now'); ?></a>
                        <?php endif; ?>

                    </div>

                    <div class="show-qr-code mt-2"><i class="fas fa-qrcode"></i>
                        <?php if($app_query->type=='1'): ?>
                        <?php echo app('translator')->getFromJson('general.qr_download'); ?>
                        <?php else: ?>
                        <?php echo app('translator')->getFromJson('general.qr_visit'); ?>
                        <?php endif; ?>
                        <div class="qr-code">
                            <img src="data:image/png;base64, <?php echo base64_encode(QrCode::format('png')->margin(0)->size(125)->generate(url()->current()));; ?> ">
                        </div>
                    </div>

                    <ul class="specs">
                        <li><strong><?php echo app('translator')->getFromJson('general.category'); ?>:</strong> <?php echo e($data_to_pass['category_name']); ?></li>
                        <li><strong><?php echo app('translator')->getFromJson('general.platform'); ?>:</strong> <?php echo e($data_to_pass['platform_name']); ?></li>
                        <li><strong><?php echo app('translator')->getFromJson('general.developer'); ?>:</strong> <?php echo e($app_query->developer); ?></li>
                        <?php if(!empty($app_query->file_size)): ?>
                        <li><strong><?php echo app('translator')->getFromJson('general.file_size'); ?>:</strong> <?php echo e($app_query->file_size); ?></li><?php endif; ?>
                        <?php if($app_query->type=='1'): ?>
                        <li><strong><?php echo app('translator')->getFromJson('general.downloads'); ?>:</strong> <?php echo e($app_query->counter); ?></li>
                        <?php else: ?>
                        <li><strong><?php echo app('translator')->getFromJson('general.visits'); ?>:</strong> <?php echo e($app_query->counter); ?></li><?php endif; ?>
                        <?php if(!empty($app_query->license)): ?>
                        <li><strong><?php echo app('translator')->getFromJson('general.license'); ?>:</strong> <?php echo e($app_query->license); ?></li><?php endif; ?>
                        <li><strong><?php echo app('translator')->getFromJson('general.last_update'); ?>:</strong>
                            <?php echo e(\Carbon\Carbon::parse($app_query->updated_at)->translatedFormat('F d, Y')); ?></li>
                    </ul>

                </div>

                <!-- Trending apps -->
                <div class="d-flex top-title justify-content-between mt-md-3" id="popular_apps">
                    <div><?php echo app('translator')->getFromJson('general.popular_downloads_category'); ?></div>
                    <div><i class="fas fa-angle-down"></i></div>
                </div>

                <div class="featured-apps app-page mr-3 ml-3">
                    <div class="row flex-nowrap mb-1 pb-2">
                        <?php $__currentLoopData = $popular_apps; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $app_category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                        <?php if(empty($app_category->image)): ?>
                        <?php $app_category->image='no_image.png'; ?>
                        <?php endif; ?>

                        <div class="col-half p-2 <?php if($loop->last): ?> mr-0 <?php endif; ?>"><a href="<?php echo e(asset($settings['app_base'])); ?>/<?php echo e($app_category->slug); ?>"><img src="<?php echo e(asset('images')); ?>/<?php echo e($app_category->image); ?>" class="img-fluid rounded"><span><?php echo e($app_category->title); ?></span></a>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>

                </div>
                <!-- /Trending apps -->

                <?php if(!is_null($ad[4])): ?>
                <div class="mt-3"><?php echo $ad[4]; ?></div><?php endif; ?>
                <?php echo $__env->make('frontend::inc.top', ['type' => '4'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <?php if(!is_null($ad[14])): ?>
                <div class="mt-3"><?php echo $ad[14]; ?></div><?php endif; ?>

            </div>
            <!-- /Grid column -->

        </div>
        <!-- /Grid row -->

    </div>
    <!-- /Container -->

</div>
<!-- /Big Container -->

<?php $__env->stopSection(); ?>
<?php echo $__env->make('frontend::page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/cariazlj/prod.foxart.co/lapp/resources/views/vendor/frontend/app.blade.php ENDPATH**/ ?>