<div class="right-sidebar">
    <div class="row">
        <div class="col-md-12">
            <strong style="font-size: 20px;margin-bottom: 10px;display: block;color: #7f7f7f;">SUGGESTIONS</strong>
        </div>
    </div>
    <?php echo $__env->make('creators.loop', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</div>
<?php /**PATH /home/ay8h3a64vt1a/public_html/resources/views/livewire/creators-sidebar.blade.php ENDPATH**/ ?>