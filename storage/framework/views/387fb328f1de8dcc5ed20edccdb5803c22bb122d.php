

<?php $__env->startSection('section_title'); ?>   
<strong>Manage Ads</strong>
<a href="/admin/ads/create" class="btn btn-primary pull-right"> <i class="fa fa-plus" aria-hidden="true"></i> Advertisement</a>  
<?php $__env->stopSection(); ?>

<?php $__env->startSection('section_body'); ?> 

<div class="row">
    <div class="col-md-12">
        <?php if($advertisements): ?>
        <table class="table table-striped table-bordered table-responsive dataTable">
            <thead>
            <tr>
                <th>ID</th>
                <th>Provider</th>                
                <th>Status</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <?php $__currentLoopData = $advertisements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $e): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td>
                        <?php echo e($e->id); ?>

                    </td>
                    <td>
                        <?php echo e($e->ad_provider); ?>

                    </td>                    
                    <td>
                        <?php if($e->ad_status == 1): ?>
                            <span style="color:green;font-weight:bold;">Enabled</span>
                        <?php else: ?>
                            <span style="color:red;font-weight:bold;">Disabled</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <div class="btn-group">
                            <a class="btn btn-primary btn-sm" href="/admin/ads/<?php echo e($e->id); ?>/edit">
                                <i class="glyphicon glyphicon-pencil"></i>
                            </a>
                            <a href="#" onclick="return confirm('Are you sure you want to remove this category from database?');" data-formid="#submitForm_<?php echo e($e->id); ?>" class="btn btn-danger btn-sm submitForm">
                                <i class="glyphicon glyphicon-trash"></i>
                            </a>
                            <form action="/admin/ads/<?php echo e($e->id); ?>" method="post" id="submitForm_<?php echo e($e->id); ?>">
                                <?php echo e(csrf_field()); ?>

                                <?php echo e(method_field('DELETE')); ?>

                            </form>
                        </div>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    <?php else: ?>
        No messages in database.
    <?php endif; ?>
    </div>
</div>
 <script>
        $(document).ready(function() {
            $('.submitForm').on('click', function (){
                let getFormid = $(this).data('formid');
                $(getFormid).submit();
            })
        });
    </script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.base', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/ay8h3a64vt1a/public_html/resources/views/admin/ads_list.blade.php ENDPATH**/ ?>