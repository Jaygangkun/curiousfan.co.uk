<?php $__env->startSection('content'); ?>

<div class="container">
<div class="card shadow p-3 mt-5">
    <h3 class="p-5">
        <i class="fas fa-network-wired"></i> <?php echo app('translator')->get('v17.pwaOffline'); ?>
    </h3>
</div>
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('welcome', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/ay8h3a64vt1a/public_html/resources/views/pwa/offline.blade.php ENDPATH**/ ?>