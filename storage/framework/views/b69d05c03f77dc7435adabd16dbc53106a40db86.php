<?php $__env->startSection('section_title'); ?>
<strong>Add your own custom CSS / JS to be loaded on front-end</strong>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('section_body'); ?>

<form method="POST" action="/admin/saveExtraCSSJS">
<?php echo e(csrf_field()); ?>

    
<div class="row">
    <div class="col-xs-12 col-md-4">
        <h4>Extra CSS <small>without <?php echo e('<style>'); ?> tags</small></h4>
        <textarea name="admin_extra_CSS" class="form-control" rows="25"><?php echo e(opt('admin_extra_CSS')); ?></textarea>
    </div>
    <div class="col-xs-12 col-md-4">
        <h4>Extra JS <small>without <?php echo e('<script>'); ?> tags</small></h4>
        <textarea name="admin_extra_JS" class="form-control" rows="25"><?php echo e(opt('admin_extra_JS')); ?></textarea>
    </div>
    <div class="col-xs-12 col-md-4">
        <h4>Raw JS <small>accepts <?php echo e('<script>'); ?> tags (ie. google analytics)</small></h4>
        <textarea name="admin_raw_JS" class="form-control" rows="25"><?php echo e(opt('admin_raw_JS')); ?></textarea>
    </div>
</div>
<br>
<div class="text-center">
    <input type="submit" name="sb_settings" value="Save Extra JS/CSS" class="btn btn-primary">	
</div>
</form>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.base', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/ay8h3a64vt1a/public_html/resources/views/admin/cssjs.blade.php ENDPATH**/ ?>