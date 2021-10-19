<?php $__env->startSection('seo_title'); ?> <?php echo app('translator')->get('navigation.login'); ?> - <?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="guest_forms">
        <div class="form_content">
            <div class="guest_row">
                <div class="phones-col">
                    <div class="guest_swiper_wrapper">
                        <div style="padding: 80px 19px 100px 112px;">
                            <div class="owl-carousel owl-theme" id="carousel3">
                                <div class="item">
                                    <img src="/images/slide-2.jpg" alt="image1"> </div>
                                <div class="item">
                                    <img src="/images/slide-3.jpg" alt="image2"> </div>
                                <div class="item">
                                    <img src="/images/slide-4.jpg" alt="image3"> </div>
                                <div class="item">
                                    <img src="/images/slide-5.jpg" alt="image4"> </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-col">
                    <div class="login-form">
                        <div class="form-logo">
                            <?php if($logo = opt('form_logo')): ?>
                                <img src="<?php echo e(asset($logo)); ?>" alt="logo" width="100%" height="100%"/>
                            <?php else: ?>
                                <?php echo e(opt( 'site_title' )); ?>

                            <?php endif; ?>
                        </div>

                        <div class="text-center mb-3"><strong>Verify Your Email Address</strong></div><!-- /.text-center -->

                        <div class="card-body">
                            <?php if(session('resent')): ?>
                                <div class="alert alert-success" role="alert">
                                    <?php echo e(__('A new verification link has been sent to your email address.')); ?>

                                </div>
                            <?php endif; ?>

                            <?php echo e(__('Please check your email for a verification link.')); ?>

                            <?php echo e(__('If you did not receive the email')); ?>, <br> <br> <a href="#" class="btn btn-primary form-control" onclick="event.preventDefault(); document.getElementById('email-form').submit();"><?php echo e(__('Click here to request another one')); ?></a>
                            <form id="email-form" action="<?php echo e(route('verification.resend')); ?>" method="POST" style="display: none;"><?php echo csrf_field(); ?></form>
                        </div>

                        
                    </div>
                </div>
            </div>
        </div>


    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('welcome', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/ay8h3a64vt1a/public_html/resources/views/auth/verify.blade.php ENDPATH**/ ?>