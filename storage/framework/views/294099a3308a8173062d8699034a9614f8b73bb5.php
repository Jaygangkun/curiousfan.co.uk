<?php $__env->startSection('seo_title'); ?> <?php echo app('translator')->get('navigation.signUp'); ?> - <?php $__env->stopSection(); ?>

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
                <div class="register-form">
                    <div class="form-logo">
                        <?php if($logo = opt('form_logo')): ?>
                            <img src="<?php echo e(asset($logo)); ?>" alt="logo" width="100%" height="100%"/>
                        <?php else: ?>
                            <?php echo e(opt( 'site_title' )); ?>

                        <?php endif; ?>
                    </div>
                    
                    <div class="text-center mb-3"><strong><?php echo app('translator')->get('auth.signUpText'); ?></strong></div><!-- /.text-center -->

                    <form method="POST" action="<?php echo e(route('register')); ?>">
                        <?php echo csrf_field(); ?>

                        <div class="form-group row">
                            <input id="name" type="text" placeholder="<?php echo app('translator')->get('auth.name'); ?>" class="form-control<?php echo e($errors->has('name') ? ' is-invalid' : ''); ?>" name="name" value="<?php echo e(old('name')); ?>" required autofocus>

                            <?php if($errors->has('name')): ?>
                                <span class="invalid-feedback" role="alert">
                                    <strong><?php echo e($errors->first('name')); ?></strong>
                                </span>
                            <?php endif; ?>
                            
                        </div>

                        <div class="form-group row">
                            <input id="email" type="email" placeholder="<?php echo app('translator')->get('auth.email'); ?>" class="form-control<?php echo e($errors->has('email') ? ' is-invalid' : ''); ?>" name="email" value="<?php echo e(old('email')); ?>" required>
                            <?php if($errors->has('email')): ?>
                                <span class="invalid-feedback" role="alert">
                                    <strong><?php echo e($errors->first('email')); ?></strong>
                                </span>
                            <?php endif; ?>
                        </div>

                        <div class="form-group row">
                            <select id="isCreating" name="isCreating" class="form-control">
                                <option value="No">Supporters Account</option>
                                <option value="Yes">Creators Account</option>
                            </select>
                        </div>

                        <div class="form-group row">
                            <input id="password" type="password" placeholder="<?php echo app('translator')->get('auth.password'); ?>" class="form-control<?php echo e($errors->has('password') ? ' is-invalid' : ''); ?>" name="password" required>

                            <?php if($errors->has('password')): ?>
                                <span class="invalid-feedback" role="alert">
                                    <strong><?php echo e($errors->first('password')); ?></strong>
                                </span>
                            <?php endif; ?>
                        </div>

                        <div class="form-group row">
                            <input id="password-confirm" type="password" class="form-control" placeholder="<?php echo app('translator')->get('auth.confirmPassword'); ?>" name="password_confirmation" required>
                        </div>
                        <div class="form-group row" style="margin-bottom: 40px;">
                            
                            <button type="submit" class="btn btn-primary form-control">
                                <?php echo app('translator')->get( 'navigation.signUp' ); ?>
                            </button>
                            
                        </div>
                    </form>
                    <?php if(session('b_msg')): ?>
                    <div class="alert alert-danger text-center mt-2">
                        <?php echo e(session('b_msg')); ?>

                    </div>
                    <?php endif; ?>
                    <div class="bottomer-border"></div>

                    <label class="form-check-label" style="margin-top: 20px;">
                        <?php echo app('translator')->get( 'auth.haveAccount' ); ?>
                    </label>
                    <br/>
                    <a class="btn btn-link" href="<?php echo e(route('login')); ?>">
                        <?php echo app('translator')->get( 'auth.signInText' ); ?>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('welcome', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/ay8h3a64vt1a/public_html/resources/views/auth/register.blade.php ENDPATH**/ ?>