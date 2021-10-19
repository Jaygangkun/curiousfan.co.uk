<?php $__env->startSection('section_title'); ?>
    <strong>Verify User</strong>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('section_body'); ?>
    
    <div class="row">
        <div class="col-md-12">
                <form method="POST" action="/admin/verifications/new/verify/<?php echo e($p->user_id); ?>"  enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?php echo e($p->id); ?>">
                    <input type="hidden" name="user_id" value="<?php echo e($p->user_id); ?>">
                    <?php echo e(csrf_field()); ?>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><strong><?php echo app('translator')->get('dashboard.yourCountry'); ?></strong></label>
                                <select name="country" class="form-control" required>
                                    <option value=""><?php echo app('translator')->get('profile.selectCountry'); ?></option>
                                    <?php $__currentLoopData = $countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $country): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($country); ?>" <?php if(@$user_meta['country'] == $country): ?> selected <?php endif; ?>><?php echo e($country); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                            <label for="city"><?php echo app('translator')->get('dashboard.yourCity'); ?></label>
                            <input type="text" name="city" id="city" value="<?php echo e(@$user_meta['city'] ?? old( 'city' )); ?>" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                            <label for="address"><?php echo app('translator')->get('dashboard.yourFullAddress'); ?></label>
                            <textarea name="address" id="address" class="form-control" required><?php echo e(@$user_meta['address'] ?? old( 'address' )); ?></textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                            <label for="profile_image"><?php echo app('translator')->get('dashboard.idUpload'); ?></label>
                                <input type="file" name="idUpload" accept="image/*" required>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <br>
                            <input type="submit" name="sb" value="Verify Now" class="btn btn-primary">
                        </div>
                    </div>

                </form>
        </div><!-- /.col-xs-12 col-md-6 -->
    </div><!-- /.row -->


<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.base', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/ay8h3a64vt1a/public_html/resources/views/admin/new-verification.blade.php ENDPATH**/ ?>