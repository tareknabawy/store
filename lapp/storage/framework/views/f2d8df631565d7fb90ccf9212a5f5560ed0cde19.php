<?php $__env->startSection('content'); ?>

<?php $__env->startSection('content_header', __('admin.settings')); ?>

<!-- box -->
<div class="row">

    <!-- col -->
    <div class="col-md-12">

        <?php if($message = Session::get('success')): ?>
        <div class="alert alert-success">
            <p><?php echo e($message); ?></p>
        </div>
        <?php endif; ?>

        <!-- general form elements -->
        <div class="box">

            <!-- form -->
            <form method="POST" enctype="multipart/form-data" action="<?php echo e(url('/admin/settings')); ?>">
                <?php echo csrf_field(); ?> <?php echo method_field('POST'); ?>

                <!-- box-body -->
                <div class="box-body">

                    <?php $__currentLoopData = $settings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $setting): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php $setting_data[$setting->name]=$setting->value; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    <div class="form-group">
                        <label><?php echo app('translator')->getFromJson('admin.site_title'); ?></label>
                        <input type="text" name="site_title" class="form-control" value="<?php echo e($setting_data['site_title']); ?>" placeholder="<?php echo app('translator')->getFromJson('admin.site_title'); ?>" />
                    </div>

                    <div class="form-group">
                        <label><?php echo app('translator')->getFromJson('admin.site_description'); ?></label>
                        <input type="text" name="site_description" class="form-control" value="<?php echo e($setting_data['site_description']); ?>" placeholder="<?php echo app('translator')->getFromJson('admin.site_description'); ?>" />
                    </div>

                    <div class="form-group">
                        <label><?php echo app('translator')->getFromJson('admin.site_logo'); ?></label>
                        <img src="/images/logo.png?r=<?php echo e(Str::random(40)); ?>" class="img-responsive image_preview">
                        <input type="file" name="site_logo">
                    </div>

                    <div class="form-group">
                        <label><?php echo app('translator')->getFromJson('admin.use_text_logo'); ?> </label><br />
                        <input type="checkbox" name="use_text_logo" <?php echo e($setting_data['use_text_logo'] == 1 ? 'checked' : ''); ?>>
                    </div>

                    <div class="row">

                        <div class="col-md-6">
                            <div class="form-group">
                                <label><?php echo app('translator')->getFromJson('admin.site_language'); ?></label>
                                <select title="<?php echo app('translator')->getFromJson('admin.site_language'); ?>" name="site_language" class="form-control selectpicker" data-live-search="true">
                                    <?php $__currentLoopData = $language_translation; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang => $language): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($lang); ?>" <?php echo e($setting_data['site_language'] == $lang ? ' selected' : ''); ?>><?php echo e($language); ?>

                                    </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label><?php echo app('translator')->getFromJson('admin.navbar_color'); ?></label>
                                <select title="<?php echo app('translator')->getFromJson('admin.navbar_color'); ?>" name="navbar_color" class="form-control selectpicker" data-live-search="true">
                                    <?php $__currentLoopData = $navbar_colors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang => $language): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($lang); ?>" <?php echo e($setting_data['navbar_color'] == $lang ? ' selected' : ''); ?>>
                                        <?php echo e($language); ?>

                                    </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label><?php echo app('translator')->getFromJson('admin.facebook_page_url'); ?></label>
                                <input type="text" name="facebook_page" class="form-control" value="<?php echo e($setting_data['facebook_page']); ?>" placeholder="<?php echo app('translator')->getFromJson('admin.facebook_page_url'); ?>" />
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label><?php echo app('translator')->getFromJson('admin.twitter_account_url'); ?></label>
                                <input type="text" name="twitter_account" class="form-control" value="<?php echo e($setting_data['twitter_account']); ?>" placeholder="<?php echo app('translator')->getFromJson('admin.twitter_account_url'); ?>" />
                            </div>
                        </div>

                        <div class="col-md-6">

                            <div class="form-group">
                                <label><?php echo app('translator')->getFromJson('admin.screenshot_count'); ?></label>
                                <input type="text" name="screenshot_count" class="form-control" value="<?php echo e($setting_data['screenshot_count']); ?>" placeholder="<?php echo app('translator')->getFromJson('admin.screenshot_count'); ?>" />
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label><?php echo app('translator')->getFromJson('admin.time_before_redirect'); ?></label>
                                <input type="text" name="time_before_redirect" class="form-control" value="<?php echo e($setting_data['time_before_redirect']); ?>" placeholder="<?php echo app('translator')->getFromJson('admin.time_before_redirect'); ?>" />
                            </div>
                        </div>

                    </div>

                    <div class="form-group">
                        <label><?php echo app('translator')->getFromJson('admin.favicon'); ?></label>
                        <img src="/images/favicon.png?r=<?php echo e(Str::random(40)); ?>" class="img-responsive image_preview">
                        <input type="file" name="favicon">
                    </div>

                    <div class="form-group">
                        <label><?php echo app('translator')->getFromJson('admin.default_app_image'); ?> <span class="label label-success">200x200</span></label>
                        <img src="/images/no_image.png?r=<?php echo e(Str::random(40)); ?>" class="img-responsive image_preview">
                        <input type="file" name="default_app_image">
                    </div>

                    <div class="form-group">
                        <label><?php echo app('translator')->getFromJson('admin.default_share_image'); ?> <span class="label label-success">600x315</span></label>
                        <img src="/images/default_share_image.png?r=<?php echo e(Str::random(40)); ?>" class="img-responsive image_preview">
                        <input type="file" name="default_share_image">
                    </div>

                    <div class="form-group">
                        <label><?php echo app('translator')->getFromJson('admin.html_code_before_head'); ?></label>
                        <textarea class="form-control" name="before_head_tag" rows="3"><?php echo e($setting_data['before_head_tag']); ?></textarea>
                    </div>

                    <div class="form-group">
                        <label><?php echo app('translator')->getFromJson('admin.html_code_after_body'); ?></label>
                        <textarea class="form-control" name="after_head_tag" rows="3"><?php echo e($setting_data['after_head_tag']); ?></textarea>
                    </div>

                    <div class="form-group">
                        <label><?php echo app('translator')->getFromJson('admin.html_code_before_body_end'); ?></label>
                        <textarea class="form-control" name="before_body_end_tag" rows="3"><?php echo e($setting_data['before_body_end_tag']); ?></textarea>
                    </div>

                    <div class="form-group">
                        <label><?php echo app('translator')->getFromJson('admin.auto_submission_crontab_link'); ?> <a href="?generate=submission_crontab"><u><?php echo app('translator')->getFromJson('admin.generate_another_link'); ?></u></a></label>
                        <input type="text" class="form-control" value="<?php echo e(request()->getSchemeAndHttpHost()); ?>/crawler/<?php echo e($setting_data['submission_crontab_code']); ?>" placeholder="<?php echo app('translator')->getFromJson('admin.auto_submission_crontab_link'); ?>" readonly />
                    </div>

                    <div class="form-group">
                        <label><?php echo app('translator')->getFromJson('admin.crontab_link'); ?> <a href="?generate=crontab"><u><?php echo app('translator')->getFromJson('admin.generate_another_link'); ?></u></a></label>
                        <input type="text" class="form-control" value="<?php echo e(request()->getSchemeAndHttpHost()); ?>/crontab/<?php echo e($setting_data['crontab_code']); ?>" placeholder="<?php echo app('translator')->getFromJson('admin.crontab_link'); ?>" readonly />
                    </div>

                    <div class="form-group">
                        <label><?php echo app('translator')->getFromJson('admin.hourly_crontab_link'); ?> <a href="?generate=hourly-crontab"><u><?php echo app('translator')->getFromJson('admin.generate_another_link'); ?></u></a></label>
                        <input type="text" class="form-control" value="<?php echo e(request()->getSchemeAndHttpHost()); ?>/hourly-crontab/<?php echo e($setting_data['hourly_crontab_code']); ?>" placeholder="<?php echo app('translator')->getFromJson('admin.hourly_crontab_link'); ?>" readonly />
                    </div>

                    <div class="form-group">
                        <label><?php echo app('translator')->getFromJson('admin.recommended_terms'); ?></label>
                        <input type="text" name="recommended_terms" class="form-control" data-role="tagsinput" placeholder="Tags" value="<?php echo e($setting_data['recommended_terms']); ?>" />
                    </div>

                    <div class="row">

                        <div class="col-md-4">

                            <div class="form-group">
                                <label><?php echo app('translator')->getFromJson('admin.google_play_country'); ?></label>
                                <input type="text" name="google_play_default_country" class="form-control" value="<?php echo e($setting_data['google_play_default_country']); ?>" placeholder="<?php echo app('translator')->getFromJson('admin.google_play_default_country'); ?>" />
                            </div>
                        </div>

                        <div class="col-md-4">

                            <div class="form-group">
                                <label><?php echo app('translator')->getFromJson('admin.google_play_language'); ?></label>
                                <input type="text" name="google_play_default_language" class="form-control" value="<?php echo e($setting_data['google_play_default_language']); ?>" placeholder="<?php echo app('translator')->getFromJson('admin.google_play_default_language'); ?>" />
                            </div>
                        </div>

                        <div class="col-md-4">

                            <div class="form-group">
                                <label><?php echo app('translator')->getFromJson('admin.schema_org_price_currency'); ?></label>
                                <input type="text" name="schema_org_price_currency" class="form-control" value="<?php echo e($setting_data['schema_org_price_currency']); ?>" placeholder="<?php echo app('translator')->getFromJson('admin.schema_org_price_currency'); ?>" />
                            </div>
                        </div>

                    </div>

                    <div class="row">

                        <div class="col-md-4">
                            <div class="form-group">
                                <label><?php echo app('translator')->getFromJson('admin.enable_cache'); ?></label><br />
                                <input type="checkbox" name="enable_cache" <?php echo e($setting_data['enable_cache'] == 1 ? 'checked' : ''); ?>>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label><?php echo app('translator')->getFromJson('admin.auto_submission'); ?></label><br />
                                <input type="checkbox" name="auto_submission" <?php echo e($setting_data['auto_submission'] == 1 ? 'checked' : ''); ?>>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label><?php echo app('translator')->getFromJson('admin.ping_google'); ?></label><br />
                                <input type="checkbox" name="ping_google" <?php echo e($setting_data['ping_google'] == 1 ? 'checked' : ''); ?>>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label><?php echo app('translator')->getFromJson('admin.auto_comment_approval'); ?></label><br />
                                <input type="checkbox" name="auto_comment_approval" <?php echo e($setting_data['auto_comment_approval'] == 1 ? 'checked' : ''); ?>>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label><?php echo app('translator')->getFromJson('admin.show_cookie_bar'); ?></label><br />
                                <input type="checkbox" name="show_cookie_bar" <?php echo e($setting_data['show_cookie_bar'] == 1 ? 'checked' : ''); ?>>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label><?php echo app('translator')->getFromJson('admin.cloudflare_ip'); ?></label><br />
                                <input type="checkbox" name="cloudflare_ip" <?php echo e($setting_data['cloudflare_ip'] == 1 ? 'checked' : ''); ?>>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label><?php echo app('translator')->getFromJson('admin.breadcrumbs'); ?> </label><br />
                                <input type="checkbox" name="breadcrumbs" <?php echo e($setting_data['breadcrumbs'] == 1 ? 'checked' : ''); ?>>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label><?php echo app('translator')->getFromJson('admin.schema_breadcrumbs'); ?></label><br />
                                <input type="checkbox" name="schema_breadcrumbs" <?php echo e($setting_data['schema_breadcrumbs'] == 1 ? 'checked' : ''); ?>>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label><?php echo app('translator')->getFromJson('admin.show_submission_form'); ?></label><br />
                                <input type="checkbox" name="show_submission_form" <?php echo e($setting_data['show_submission_form'] == 1 ? 'checked' : ''); ?>>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label><?php echo app('translator')->getFromJson('admin.reading_time'); ?></label><br />
                                <input type="checkbox" name="reading_time" <?php echo e($setting_data['reading_time'] == 1 ? 'checked' : ''); ?>>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label><?php echo app('translator')->getFromJson('admin.rss_link'); ?></label><br />
                                <input type="checkbox" name="show_rss_feed" <?php echo e($setting_data['show_rss_feed'] == 1 ? 'checked' : ''); ?>>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label><?php echo app('translator')->getFromJson('admin.random_app_link'); ?> </label><br />
                                <input type="checkbox" name="random_app_link" <?php echo e($setting_data['random_app_link'] == 1 ? 'checked' : ''); ?>>
                            </div>
                        </div>

                    </div>

                </div>
                <!-- /.box-body -->

                <div class="box-footer">
                    <button type="submit" class="btn btn-primary"><?php echo app('translator')->getFromJson('admin.submit'); ?></button>
                </div>

            </form>
            <!-- /.form -->

        </div>
        <!-- /.general form elements -->

    </div>
    <!-- /.col -->

</div>
<!-- /.box -->

<?php $__env->stopSection(); ?>
<?php echo $__env->make('adminlte::page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/cariazlj/prod.foxart.co/lapp/resources/views/vendor/adminlte/settings/site.blade.php ENDPATH**/ ?>