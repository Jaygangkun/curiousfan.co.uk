<?php $__env->startSection('seo_title'); ?> <?php echo app('translator')->get('v14.report-content'); ?> - <?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="container mt-5 mb-5">
    <div class="row">
        <div class="col-12 col-sm-12 col-md-8 offset-0 offset-sm-0 offset-md-2">
            <div class="card shadow p-3">
            <h3><?php echo app('translator')->get('v14.report-content'); ?></h3>
            <hr>
            <div class="alert alert-secondary"><?php echo app('translator')->get('v14.report-content-description'); ?>.</div>

            <form method="POST" action="<?php echo e(route('storeReport')); ?>" name="report-content-form">
                <?php echo csrf_field(); ?>

                <div class="d-none">
                    <input type="text" name="the_field" />
                </div>

                <strong><label><?php echo app('translator')->get('v14.your-name'); ?></label></strong>
                <div class="row">
                    <div class="col-12 col-sm-12 col-md-6">
                        <input type="text" name="reporter_name" placeholder="<?php echo app('translator')->get('Name'); ?>" class="form-control" value="<?php echo e(old('reporter_name')); ?>"/>
                    </div>
                </div>
                <br>

                <strong><label><?php echo app('translator')->get('v14.your-email'); ?></label></strong>
                <div class="row">
                    <div class="col-12 col-sm-12 col-md-6">
                        <input type="text" name="reporter_email" placeholder="<?php echo app('translator')->get('v14.your-email'); ?>" class="form-control" value="<?php echo e(old('reporter_email')); ?>"/>
                    </div>
                </div>
                <br>

                <strong><label><?php echo app('translator')->get('v14.reported_url'); ?></label></strong>
                <div class="row">
                    <div class="col-12 col-sm-12">
                        <input type="text" name="reported_url" placeholder="<?php echo e(route('home')); ?>/...." class="form-control" value="<?php echo e(old('reported_url')); ?>"/>
                    </div>
                </div>
                <br>

                <strong><label><?php echo app('translator')->get('v14.your_message'); ?></label></strong>
                <div class="row">
                    <div class="col-12">
                        <textarea name="report_message" class="form-control" rows="6"/><?php echo e(old('report_message')); ?></textarea>
                    </div>
                </div>

                <br>

                <strong><label><?php echo app('translator')->get('v14.math_question'); ?> <?php echo e($no1 . '+' . $no2); ?>?</label></strong>
                <div class="row">
                    <div class="col-12 col-sm-12 col-md-2">
                        <input type="number" name="reported_math" class="form-control" value="<?php echo e(old('reported_math')); ?>" />
                    </div>
                </div>

                <br>

                <input type="submit" name="reportSbtn" value="<?php echo app('translator')->get('v14.submit-report'); ?>" class="btn btn-danger">
                    

            </form>

            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('welcome', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/jr5az3t0ng0l/public_html/resources/views/report-content-form.blade.php ENDPATH**/ ?>