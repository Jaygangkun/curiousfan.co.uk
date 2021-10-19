

<?php $__env->startSection('section_title'); ?>   
    <strong>Manage Ads</strong>  
<?php $__env->stopSection(); ?>

<?php $__env->startSection('section_body'); ?> 

<div class="row">
    <div class="col-md-12">
        <form method="POST" action="/admin/ads/<?php echo e($advertisement->id); ?>/edit">
        <?php echo e(csrf_field()); ?>

            <div class="row">                
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="ad_provider">Ad Provider</label>
                        <input type="text" name="ad_provider" id="ad_provider" value ="<?php echo e($advertisement->ad_provider); ?>" placeholder="Google Adsense" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="ad_script">Ad Code Script</label>
                        <textarea class="form-control" rows="5" id="ad_script" name="ad_script">
                            <?php echo e(htmlspecialchars_decode($advertisement->ad_script)); ?>

                        </textarea>
                    </div>                    
                    <div class="form-group">
                        <label>Status</label>
                        <div class="radio">
                            <label class="radio-inline"><input type="radio" value="1" <?php echo e($advertisement->ad_status == 1 ? 'checked' : ''); ?> name="ad_status">ON</label>
                            <label class="radio-inline"><input type="radio" value="0" name="ad_status" <?php echo e($advertisement->ad_status == 0 ? 'checked' : ''); ?>>OFF</label>
                        </div>
                    </div>                  

                </div>                                       
            </div>                                                  

            <button type="submit" class="btn btn-primary pull-right">Save</button>
        </form>
    </div>
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.base', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/ay8h3a64vt1a/public_html/resources/views/admin/ads_edit.blade.php ENDPATH**/ ?>