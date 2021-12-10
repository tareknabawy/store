<?php $__env->startSection('content'); ?>

<?php $__env->startSection('content_header', __('admin.apps')); ?>

<!-- Info boxes -->
<div class="row">

    <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box">
            <span class="info-box-icon cpu-load"><i class="fas fa-chart-bar"></i></span>
            <div class="info-box-content">
                <span class="info-box-text"><?php echo app('translator')->getFromJson('admin.cpu_load'); ?> </span>
                <span class="info-box-number"><?php echo e($sload); ?><small>%</small></span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <!-- /.col -->

    <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box">
            <span class="info-box-icon cached-queries"><i class="fas fa-server"></i></span>

            <div class="info-box-content">
                <span class="info-box-text"><?php echo app('translator')->getFromJson('admin.cached_queries'); ?></span>
                <span class="info-box-number"><?php echo e(number_format($total_cached)); ?></span>
                <a href="<?php echo e(asset('/admin/settings/clear_cache')); ?>" id="clear-cache" class="clear-cache" data-cache-clear="<?php echo app('translator')->getFromJson('admin.cache_clear_message'); ?>"><?php echo app('translator')->getFromJson('admin.clear_cache'); ?></a>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <!-- /.col -->

    <!-- fix for small devices only -->
    <div class="clearfix visible-sm-block"></div>

    <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box">
            <span class="info-box-icon total-apps"><i class="fab fa-android"></i></span>

            <div class="info-box-content">
                <span class="info-box-text"><?php echo app('translator')->getFromJson('admin.total_apps'); ?></span>
                <span class="info-box-number"><?php echo e(number_format($total_apps)); ?></span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <!-- /.col -->

    <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box">
            <span class="info-box-icon total-downloads"><i class="fas fa-chart-pie"></i></span>

            <div class="info-box-content">
                <span class="info-box-text"><?php echo app('translator')->getFromJson('admin.total_hits'); ?></span>
                <span class="info-box-number"><?php echo e(number_format($total_downloads)); ?></span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <!-- /.col -->

</div>
<!-- /.row -->

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

            <!-- box-body -->
            <div class="box-body no-padding">

                <a href="<?php echo e(asset('/admin/apps/create')); ?>" class="btn bg-purple btn-flat margin"><i class="fas fa-plus-square"></i>
                    <?php echo app('translator')->getFromJson('admin.create_app'); ?></a>
                <div class="table-responsive">
                <table class="table table-striped" id="table" data-delete-prompt="<?php echo app('translator')->getFromJson('admin.delete_prompt'); ?>" data-yes="<?php echo app('translator')->getFromJson('admin.yes'); ?>" data-cancel="<?php echo app('translator')->getFromJson('admin.cancel'); ?>">
                        <tr>
                            <th class="col-md-1">ID</th>
                            <th class="col-md-7"><?php echo app('translator')->getFromJson('admin.app_title'); ?></th>
                            <th class="col-md-1"><?php echo app('translator')->getFromJson('admin.category'); ?></th>
                            <th class="col-md-1"><?php echo app('translator')->getFromJson('admin.platform'); ?></th>
                            <th class="col-md-1"><?php echo app('translator')->getFromJson('admin.edit'); ?></th>
                            <th class="col-md-1"><?php echo app('translator')->getFromJson('admin.delete'); ?></th>
                        </tr>
                        <?php $__currentLoopData = $apps; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($row['id']); ?></td>
                            <td><a href="<?php echo e(asset($settings['app_base'])); ?>/<?php echo e($row->slug); ?>" class="text-black" target="_blank"><?php echo e($row['title']); ?></a></td>
                            <td><?php echo e($row->category_title); ?></td>
                            <td><?php echo e($row->platform_title); ?></td>
                            <td><a href="<?php echo e(action('ApplicationController@edit', $row['id'])); ?>"
                                    class="btn btn-sm bg-purple"><i class="fas fa-edit"></i> <?php echo app('translator')->getFromJson('admin.edit'); ?></a>
                            </td>
                            <td>
                                <form id="delete_from_<?php echo e($row->id); ?>" method="POST"
                                    action="<?php echo e(action('ApplicationController@destroy', $row['id'])); ?>">
                                    <?php echo e(csrf_field()); ?>

                                    <?php echo e(method_field('DELETE')); ?>

                                    <a href="javascript:void(0);" data-id="<?php echo e($row->id); ?>" class="_delete_data">
                                        <span class="btn btn-sm bg-red"><i class="fas fa-ban"></i>
                                            <?php echo app('translator')->getFromJson('admin.delete'); ?></span>
                                    </a>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </table>
                </div>

            </div>
            <!-- /.box-body -->

        </div>
        <!-- /.general form elements -->

        <?php if($apps->isEmpty()): ?>
        <h6 class="alert alert-danger"><?php echo app('translator')->getFromJson('admin.no_record'); ?>.</h6>
        <?php endif; ?>

    </div>
    <!-- /.col -->

</div>
<!-- /.box -->

<?php echo e($apps->onEachSide(1)->links()); ?>


<?php $__env->stopSection(); ?>
<?php echo $__env->make('adminlte::page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/cariazlj/prod.foxart.co/lapp/resources/views/vendor/adminlte/apps/index.blade.php ENDPATH**/ ?>