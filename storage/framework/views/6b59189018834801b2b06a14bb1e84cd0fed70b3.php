<?php $__env->startSection('seo_title'); ?> <?php echo app('translator')->get('v18.contact-us'); ?> - <?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="container mt-5 mb-5">
    <div class="row">
        <div class="col-12 col-sm-12 col-md-8 offset-0 offset-sm-0 offset-md-2">
            <div class="card shadow p-3">
            <h3><?php echo app('translator')->get('v18.contact-us'); ?></h3>
            <hr>
            <div class="alert alert-secondary"><?php echo app('translator')->get('v18.contact-us-description'); ?>.</div>

            <form method="POST" action="<?php echo e(route('contact-form-process')); ?>" name="report-content-form">
                <?php echo csrf_field(); ?>

                <div class="d-none">
                    <input type="text" name="the_field" />
                </div>

                <strong><label><?php echo app('translator')->get('v14.your-name'); ?></label></strong>
                <div class="row">
                    <div class="col-12 col-sm-12 col-md-6">
                        <input type="text" name="your_name" placeholder="<?php echo app('translator')->get('Name'); ?>" class="form-control" value="<?php echo e(old('your_name')); ?>"/>
                    </div>
                </div>
                <br>

                <strong><label><?php echo app('translator')->get('v14.your-email'); ?></label></strong>
                <div class="row">
                    <div class="col-12 col-sm-12 col-md-6">
                        <input type="text" name="your_email" placeholder="<?php echo app('translator')->get('Email'); ?>" class="form-control" value="<?php echo e(old('your_email')); ?>"/>
                    </div>
                </div>
                <br>

                <strong><label><?php echo app('translator')->get('v18.subject'); ?></label></strong>
                <div class="row">
                    <div class="col-12 col-sm-12 col-md-6">
                        <input type="text" name="your_subject" placeholder="<?php echo app('translator')->get('Subject'); ?>" class="form-control" value="<?php echo e(old('your_subject')); ?>"/>
                    </div>
                </div>
                <br>

                <strong><label><?php echo app('translator')->get('v18.your_message'); ?></label></strong>
                <div class="row">
                    <div class="col-12">
                        <textarea name="your_message" class="form-control" rows="6"/><?php echo e(old('your_message')); ?></textarea>
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
<?php echo $__env->make('welcome', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/ay8h3a64vt1a/public_html/resources/views/contact-page.blade.php ENDPATH**/ ?>