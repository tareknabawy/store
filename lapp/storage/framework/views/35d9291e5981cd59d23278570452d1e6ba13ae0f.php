<?php $__env->startSection('content'); ?>

<?php $__env->startSection('content_header', __('admin.edit_application')); ?>

<!-- box -->
<div class="row">

    <!-- col -->
    <div class="col-md-12">

        <?php if(count($errors) > 0): ?>
        <div class="alert alert-danger">
            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <p><?php echo e($error); ?></p>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        <?php endif; ?> <?php if(Session::has('success')): ?>
        <div class="alert alert-success">
            <p><?php echo e(Session::get('success')); ?></p>
        </div>
        <?php endif; ?>

        <!-- general form elements -->
        <div class="box">

            <!-- form -->
            <form method="POST" enctype="multipart/form-data" action="<?php echo e(action('ApplicationController@update', $id)); ?>">
                <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>

                <!-- box-body -->
                <div class="box-body">

                    <div class="form-group">
                        <label><?php echo app('translator')->getFromJson('admin.app_title'); ?> <span class="text-danger">*</span></label>
                        <input type="text" name="title" class="form-control" value="<?php echo e($app->title); ?>" placeholder="<?php echo app('translator')->getFromJson('admin.app_title'); ?>" />
                    </div>

                    <div class="form-group">
                        <img src="<?php if(empty($app->image)): ?><?php echo e(asset('images/no_image.png')); ?><?php else: ?><?php echo e(asset('images')); ?>/<?php echo e($app->image); ?><?php endif; ?>" class="app-image">
                        <label><?php echo app('translator')->getFromJson('admin.image'); ?></label><br />
                        <label class="btn btn-outline btn-sm" id="browse-color-image"><?php echo app('translator')->getFromJson('admin.browse'); ?><input type="file" name="image" class="hidden"></label>
                    </div>

                    <div class="form-group">
                        <label><?php echo app('translator')->getFromJson('admin.app_description'); ?> <span class="text-danger">*</span></label>
                        <input type="text" name="description" class="form-control" value="<?php echo e($app->description); ?>" placeholder="<?php echo app('translator')->getFromJson('admin.app_description'); ?>" />
                    </div>

                    <div class="form-group">
                        <label><?php echo app('translator')->getFromJson('admin.tags'); ?></label>
                        <input type="text" name="tags" class="form-control" data-role="tagsinput" value="<?php $__currentLoopData = $app->tags; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php echo e($tag->name); ?><?php if(!$loop->last): ?>,<?php endif; ?> <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>" placeholder="<?php echo app('translator')->getFromJson('admin.tags'); ?>" />
                    </div>

                    <!-- row -->
                    <div class="row">

                        <div class="col-md-4">
                            <div class="form-group">
                                <label><?php echo app('translator')->getFromJson('admin.app_category'); ?> <span class="text-danger">*</span></label>
                                <select title="<?php echo app('translator')->getFromJson('admin.select_category'); ?>" name="category" class="form-control selectpicker" data-live-search="true">
                                    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option data-icon="<?php echo e($category->fa_icon); ?>" value="<?php echo e($category->id); ?>" <?php echo e($app->category == $category->id ? ' selected' : ''); ?>><?php echo e($category->title); ?>

                                    </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label><?php echo app('translator')->getFromJson('admin.app_platform'); ?> <span class="text-danger">*</span></label>
                                <select title="<?php echo app('translator')->getFromJson('admin.select_platform'); ?>" name="platform" class="form-control selectpicker" data-live-search="true">
                                    <?php $__currentLoopData = $platforms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $platform): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option data-icon="<?php echo e($platform->fa_icon); ?>" value="<?php echo e($platform->id); ?>" <?php echo e($app->platform == $platform->id ? ' selected' : ''); ?>><?php echo e($platform->title); ?>

                                    </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label><?php echo app('translator')->getFromJson('admin.app_button_title'); ?> <span class="text-danger">*</span></label>
                                <select title="<?php echo app('translator')->getFromJson('admin.select_button'); ?>" name="type" class="form-control selectpicker" data-live-search="true">
                                    <option data-icon="fas fa-download" value="1" <?php echo e($app->type == 1 ? ' selected' : ''); ?>><?php echo app('translator')->getFromJson('admin.download_now'); ?>
                                    </option>
                                    <option data-icon="fas fa-external-link-alt" value="2" <?php echo e($app->type == 2 ? ' selected' : ''); ?>><?php echo app('translator')->getFromJson('admin.visit_page'); ?>
                                    </option>
                                </select>
                            </div>
                        </div>

                    </div>
                    <!-- /.row -->

                    <!-- row -->
                    <div class="row">

                        <div class="col-md-4">
                            <div class="form-group">
                                <label><?php echo app('translator')->getFromJson('admin.slug'); ?> <span class="text-danger">*</span></label>
                                <input type="text" name="slug" class="form-control" value="<?php echo e($app->slug); ?>" placeholder="<?php echo app('translator')->getFromJson('admin.slug'); ?>" />
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label><?php echo app('translator')->getFromJson('admin.custom_meta_description'); ?></label>
                                <input type="text" name="custom_description" class="form-control" value="<?php echo e($app->custom_description); ?>" placeholder="<?php echo app('translator')->getFromJson('admin.custom_meta_description'); ?>" />
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label><?php echo app('translator')->getFromJson('admin.app_developer'); ?> <span class="text-danger">*</span></label>
                                <input type="text" name="developer" class="form-control" value="<?php echo e($app->developer); ?>" placeholder="Developer" />
                            </div>
                        </div>

                    </div>
                    <!-- /.row -->

                    <!-- row -->
                    <div class="row">

                        <div class="col-md-4">
                            <div class="form-group">
                                <label><?php echo app('translator')->getFromJson('admin.app_license'); ?></label>
                                <input type="text" name="license" class="form-control" value="<?php echo e($app->license); ?>" placeholder="License" />
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label><?php echo app('translator')->getFromJson('admin.app_file_size'); ?></label>
                                <input type="text" name="file_size" class="form-control" value="<?php echo e($app->file_size); ?>" placeholder="File Size" />
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label><?php echo app('translator')->getFromJson('admin.app_counter'); ?> <span class="text-danger">*</span></label>
                                <input type="text" name="counter" class="form-control" value="<?php echo e($app->counter); ?>" placeholder="Download Counter" />
                            </div>
                        </div>

                    </div>
                    <!-- /.row -->

                    <!-- row -->
                    <div class="row">

                        <div class="col-md-4">
                            <div class="form-group">
                                <label><?php echo app('translator')->getFromJson('admin.app_buy_url'); ?></label>
                                <input type="text" name="buy_url" class="form-control" value="<?php echo e($app->buy_url); ?>" placeholder="<?php echo app('translator')->getFromJson('admin.app_buy_url'); ?>" />
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label><?php echo app('translator')->getFromJson('admin.app_download_page_url'); ?> <span class="text-danger">*</span></label>
                                <input type="text" name="url" class="form-control" value="<?php echo e($app->url); ?>" placeholder="Download/Page URL" />
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>File</label><br />
                                <label class="btn btn-outline btn-sm" id="browse-color-file"><?php echo app('translator')->getFromJson('admin.browse'); ?><input type="file" name="file" id="import-file-select" class="hidden"></label>
                            </div>
                        </div>

                    </div>
                    <!-- /.row -->

                    <!-- row -->
                    <div class="row">

                        <div class="col-md-3">
                            <div class="form-group">
                                <label><?php echo app('translator')->getFromJson('admin.featured'); ?></label><br />
                                <input type="checkbox" name="featured" <?php echo e($app->featured == 1 ? 'checked' : ''); ?>>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label><?php echo app('translator')->getFromJson('admin.pinned'); ?></label><br />
                                <input type="checkbox" name="pinned" <?php echo e($app->pinned == 1 ? 'checked' : ''); ?>>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label><?php echo app('translator')->getFromJson('admin.editors_choice'); ?></label><br />
                                <input type="checkbox" name="editors_choice" <?php echo e($app->editors_choice == 1 ? 'checked' : ''); ?>>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label><?php echo app('translator')->getFromJson('admin.must_have'); ?></label><br />
                                <input type="checkbox" name="must_have" <?php echo e($app->must_have == 1 ? 'checked' : ''); ?>>
                            </div>
                        </div>

                    </div>
                    <!-- /.row -->

                    <!-- row -->
                    <div class="row">


                    </div>
                    <!-- /.row -->

                    <div class="form-group">
                        <label><?php echo app('translator')->getFromJson('admin.app_detailed_description'); ?></label>
                        <textarea class="textarea textarea-style" name="details" placeholder="<?php echo app('translator')->getFromJson('admin.app_detailed_description'); ?>"><?php echo e($app->details); ?></textarea>
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

<!-- general form elements -->
<div class="box">

    <!-- box-body -->
    <div class="box-body" id="screenshots" data-content-deleted="<?php echo app('translator')->getFromJson('admin.content_deleted'); ?>" data-succesfully-deleted="<?php echo app('translator')->getFromJson('admin.content_succesfully_deleted'); ?>">

        <form method="post" action="<?php echo e(route('upload', ['app_id'=>$app->id])); ?>" id="screenshot_form" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <div class="form-group">
                <label><?php echo app('translator')->getFromJson('admin.screenshots'); ?></label><br />
                <label class="btn btn-outline btn-sm" id="browse-color-image"><?php echo app('translator')->getFromJson('admin.browse'); ?><input type="file" name="file[]" id="file" accept="image/*" class="hidden" multiple /></label>
            </div>

                <input type="submit" name="upload" value="<?php echo app('translator')->getFromJson('admin.upload'); ?>" class="btn btn-primary mb-10" />
        </form>

        <div class="progress">
            <div class="progress-bar" aria-valuenow="" aria-valuemin="0" aria-valuemax="100">
                0%
            </div>
        </div>

        <div id="success" class="row">
            <?php
            if ($app->screenshots != "") {

            $mysplit = explode(',', $app->screenshots);
            $screenshot_data = array_reverse($mysplit);

            $image_code_s = '';
            foreach($screenshot_data as $screenshot) {
            $image_code_s .= '<div class="col-md-2 mb-10 text-center"><img src="/screenshots/'.$screenshot.'" class="img-thumbnail" /><button type="button" data-name="'.$screenshot.'" data-app-id="'.$app->id.'" class="btn btn-danger mt-10 remove_screenshot">' . __('admin.delete') . '</button></div>';
            }
            echo $image_code_s;
            } else {
            echo '<div class="text-center"><b>' . __('admin.no_screenshots_yet') . '</b></div><br />';
            }
            ?>
        </div>

    </div>
    <!-- /.box -->

</div>
<!-- /.general form elements -->

<?php $__env->stopSection(); ?>
<?php echo $__env->make('adminlte::page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/cariazlj/prod.foxart.co/lapp/resources/views/vendor/adminlte/apps/edit.blade.php ENDPATH**/ ?>