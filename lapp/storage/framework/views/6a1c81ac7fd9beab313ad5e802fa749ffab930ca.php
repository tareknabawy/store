<?php $__env->startSection('content'); ?>

<?php $__env->startSection('content_header', __('admin.categories')); ?>

<!-- box -->
<div class="row">

    <!-- col -->
    <div class="col-md-12">

        <?php if($message = Session::get('success')): ?>
        <div class="alert alert-success">
            <p><?php echo e($message); ?></p>
        </div>
        <?php endif; ?>

        <?php if($message = Session::get('error')): ?>
        <div class="alert alert-danger">
            <p><?php echo e($message); ?></p>
        </div>
        <?php endif; ?>

        <!-- general form elements -->
        <div class="box">

            <!-- box-body -->
            <div class="box-body no-padding">

                <a href="<?php echo e(asset('/admin/categories/create')); ?>" class="btn bg-purple btn-flat margin"><i
                        class="fas fa-plus-square"></i> <?php echo app('translator')->getFromJson('admin.create_category'); ?></a>
                <div class="table-responsive">
                <table class="table table-striped" id="table" data-delete-prompt="<?php echo app('translator')->getFromJson('admin.delete_prompt'); ?>" data-yes="<?php echo app('translator')->getFromJson('admin.yes'); ?>" data-cancel="<?php echo app('translator')->getFromJson('admin.cancel'); ?>" data-mark-unapproved="<?php echo app('translator')->getFromJson('admin.mark_unapproved'); ?>">
                        <thead>
                            <tr>
                                <th class="col-md-1">ID</th>
                                <th class="col-md-9"><?php echo app('translator')->getFromJson('admin.title'); ?></th>
                                <th class="col-md-1"><?php echo app('translator')->getFromJson('admin.edit'); ?></th>
                                <th class="col-md-1"><?php echo app('translator')->getFromJson('admin.delete'); ?></th>
                            </tr>
                        </thead>
                        <tbody class="sortable-posts" id="categories">
                            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr id="<?php echo e($row->id); ?>">
                                <td><?php echo e($row->id); ?></td>
                                <td><a href="<?php echo e(asset($settings['category_base'])); ?>/<?php echo e($row->slug); ?>" class="text-black" target="_blank"><?php echo e($row->title); ?></a></td>
                                <td><a href="<?php echo e(action('CategoryController@edit', $row->id)); ?>"
                                        class="btn btn-link btn-sm bg-purple"><i class="fas fa-edit"></i>
                                        <?php echo app('translator')->getFromJson('admin.edit'); ?>
                                    </a></td>
                                <td>
                                    <form id="delete_from_<?php echo e($row->id); ?>" method="POST"
                                        action="<?php echo e(action('CategoryController@destroy', $row['id'])); ?>">
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
                        </tbody>
                    </table>
                </div>

            </div>
            <!-- /.box-body -->

        </div>
        <!-- /.general form elements -->

        <?php if($categories->isEmpty()): ?>
        <h6 class="alert alert-danger"><?php echo app('translator')->getFromJson('admin.no_record'); ?>.</h6>
        <?php endif; ?>

    </div>
    <!-- /.col -->

</div>
<!-- /.box -->

<?php $__env->stopSection(); ?>
<?php echo $__env->make('adminlte::page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/cariazlj/prod.foxart.co/lapp/resources/views/vendor/adminlte/categories/index.blade.php ENDPATH**/ ?>