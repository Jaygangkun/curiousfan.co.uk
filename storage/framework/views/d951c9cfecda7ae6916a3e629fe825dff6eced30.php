<?php $__env->startPush( 'extraJS' ); ?>
<script>
// audience size slider
AUDIENCE_MIN = <?php echo e(opt('SL_AUDIENCE_MIN', 10)); ?>;
AUDIENCE_MAX = <?php echo e(opt('SL_AUDIENCE_MAX', 9000)); ?>;
AUDIENCE_PREDEFINED_NO = <?php echo e(opt('SL_AUDIENCE_PRE_NUM', 100)); ?>;
AUDIENCE_SL_STEP = <?php echo e(opt('SL_AUDIENCE_STEP', 100)); ?>;

// membership fee slider
MEMBERSHIP_FEE_MIN = <?php echo e(opt('MSL_MEMBERSHIP_FEE_MIN', 9)); ?>;
MEMBERSHIP_FEE_MAX = <?php echo e(opt('MSL_MEMBERSHIP_FEE_MAX', 999)); ?>;
MEMBERSHIP_FEE_PRESET = <?php echo e(opt('MSL_MEMBERSHIP_FEE_PRESET', 9)); ?>;
MEMBERSHIP_FEE_STEP = <?php echo e(opt('MSL_MEMBERSHIP_FEE_STEP', 1)); ?>;
</script>

<script src="<?php echo e(asset('js/homepage-sliders.js')); ?>?v=<?php echo e(microtime()); ?>"></script>
<?php $__env->stopPush(); ?>

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
                    
                    <div class="text-center mb-3"><strong><?php echo app('translator')->get('auth.signInText'); ?></strong></div><!-- /.text-center -->

                    <form method="POST" action="<?php echo e(route('login')); ?>">
                        <?php echo csrf_field(); ?>
                        <div class="form-group row">
                            <input id="email" type="email" class="form-control<?php echo e($errors->has('email') ? ' is-invalid' : ''); ?>" placeholder="<?php echo app('translator')->get('auth.email'); ?>" name="email" value="<?php echo e(old('email')); ?>" required autofocus>
                                <?php if($errors->has('email')): ?>
                                    <span class="invalid-feedback" role="alert">
                                        <strong><?php echo e($errors->first('email')); ?></strong>
                                    </span>
                                <?php endif; ?>
                        </div>
                        <div class="form-group row">
                            <input id="password" type="password" class="form-control<?php echo e($errors->has('password') ? ' is-invalid' : ''); ?>" placeholder="<?php echo app('translator')->get('auth.password'); ?>" name="password" required>
                            <?php if($errors->has('password')): ?>
                                <span class="invalid-feedback" role="alert">
                                    <strong><?php echo e($errors->first('password')); ?></strong>
                                </span>
                            <?php endif; ?>
                        </div>
                        <div class="form-group row">
                            
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember" <?php echo e(old('remember') ? 'checked' : ''); ?>>

                                <label class="form-check-label" for="remember">
                                    <?php echo app('translator')->get( 'auth.rememberMe' ); ?>
                                </label>
                            </div>
                            
                        </div>

                        <div class="form-group row">
                            <button type="submit" class="btn btn-primary form-control">
                                <?php echo app('translator')->get( 'auth.login' ); ?>
                            </button>
                            <?php if(Route::has('password.request')): ?>
                                <a class="btn btn-link" href="<?php echo e(route('password.request')); ?>">
                                    <?php echo app('translator')->get( 'auth.forgotPassword' ); ?>
                                </a>
                            <?php endif; ?>
                        </div>
                    </form>
                    <?php if(session('b_msg')): ?>
                    <div class="alert alert-danger text-center mt-2">
                        <?php echo e(session('b_msg')); ?>

                    </div>
                    <?php endif; ?>
                    <div class="bottomer-border"></div>

                    <label class="form-check-label" style="margin-top: 20px;">
                        <?php echo app('translator')->get( 'auth.donotHaveAccount' ); ?>
                    </label>
                    <br/>
                    <a class="btn btn-link" href="<?php echo e(route('register')); ?>">
                        <?php echo app('translator')->get( 'auth.signUpText' ); ?>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <?php if(opt('hideEarningsSimulator', 'Show') == 'Show'): ?> 
      <div class="container" style="margin-top: 150px;">
        <h2 class="bold text-center"><?php echo app('translator')->get( 'homepage.earningsSimulator' ); ?></h2>
        <br/>

        <div class="row">
        <div class="col-md-4 offset-md-2">
            <h5><?php echo app('translator')->get( 'homepage.audienceSize' ); ?> <span class="text-muted audience-size">1000</span></h5>
            <div id="slider-audience"></div>
        </div><!-- /.col-md-3 ( audience size ) -->

        <div class="col-md-1">&nbsp;</div><!-- /.col-md-1 -->

        <div class="col-md-4">
            <h5><?php echo app('translator')->get( 'homepage.membershipFee' ); ?> <span class="text-muted package-price"><?php echo e(opt( 'payment-settings.currency_symbol' )); ?>9</span></h5>
            <div id="slider-package"></div>
        </div><!-- /.col-md-3 ( audience size ) -->

        <div class="col-md-1">&nbsp;</div><!-- /.col-md-1 -->

        <div class="col-md-1">&nbsp;</div><!-- /.col-md-1 -->
            
        </div><!-- /.row -->
        
        <br/>
        <hr/>
        <div class="text-center">
        <h3 class="bold">
        <span class="per-month"><?php echo e(opt( 'payment-settings.currency_symbol' )); ?>85.5</span> <?php echo app('translator')->get( 'homepage.perMonth' ); ?>
        </h3><!-- /.bold -->    

        <?php echo e(__('homepage.calcNote', [ 'site_fee' => opt('payment-settings.site_fee').'%'])); ?>

        
        <br/><br/>
        <a href="<?php echo e(route('startMyPage')); ?>" class="btn btn-danger"><?php echo app('translator')->get('homepage.startCreatorProfile'); ?></a>
        </div><!-- /.text-center -->

        <br/><br/>

      </div><!-- /.container -->
    <?php endif; ?>

</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('welcome', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/ay8h3a64vt1a/public_html/resources/views/auth/login.blade.php ENDPATH**/ ?>