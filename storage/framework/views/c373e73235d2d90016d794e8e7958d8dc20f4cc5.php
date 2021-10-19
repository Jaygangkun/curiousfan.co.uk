<?php $__env->startSection( 'content' ); ?>
<div class="white-smoke-bg">
<br/>

<div class="container add-padding">
<div class="row">
    <div class="col-md-12">
        <?php if( isset( $p ) AND $p->isVerified != 'Yes' ): ?>
                <?php if( $p->isVerified == 'No' ): ?>
                <div class="alert alert-danger" role="alert"> <?php echo app('translator')->get( 'dashboard.not-verified' ); ?> <a href="<?php echo e(route( 'profile.verifyProfile' )); ?>"><?php echo app('translator')->get('dashboard.verify-profile'); ?></a></div>
                <?php elseif( $p->isVerified = 'Pending' ): ?>
                <div class="alert alert-warning" role="alert"><?php echo app('translator')->get( 'dashboard.verification-pending' ); ?></div>
                <?php endif; ?>

        <?php endif; ?>
        <?php if(session('resent')): ?>
            <div class="alert alert-success" role="alert">
                <?php echo e(__('A new verification link has been sent to your email address.')); ?>

            </div>
        <?php endif; ?>
        <?php if(!auth()->user()->hasVerifiedEmail()): ?>
            <div class="alert alert-danger" role="alert">
                Please verify your email address, <a href="#" onclick="event.preventDefault(); document.getElementById('email-form').submit();">click here</a> to verify now.
                <form id="email-form" action="<?php echo e(route('verification.resend')); ?>" method="POST" style="display: none;"><?php echo csrf_field(); ?></form>
            </div>
        <?php endif; ?>
    </div>
</div>
<div class="row">
<div class="col-md-4 d-block d-sm-none mb-3">
<a class="btn btn-dark" data-toggle="collapse" href="#mobileAccountNavi" role="button" aria-expanded="false" aria-controls="collapseExample">
    <i class="fas fa-list mr-1"></i> <?php echo app('translator')->get('navigation.accountNavigation'); ?>
  </a>
<div class="collapse mt-2" id="mobileAccountNavi">
    <?php echo $__env->make( 'partials/dashboardnavi' , \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</div>
</div><!-- /.col-md-3 -->

<div class="col-md-8">
<?php echo $__env->yieldContent( 'account_section' ); ?>
</div><!-- /.col-md-8 -->

<div class="col-md-4 d-none d-sm-block">
<?php echo $__env->make( 'partials/dashboardnavi' , \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</div><!-- /.col-md-3 -->

</div><!-- ./row ( main ) -->
</div><!-- /.container -->
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make( 'welcome' , \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/ay8h3a64vt1a/public_html/resources/views/account.blade.php ENDPATH**/ ?>