<div wire:poll.3000ms>
    <a class="nav-link" href="<?php echo e(route('messages.inbox')); ?>">
        <?php echo app('translator')->get('navigation.messages'); ?>
        
		<small class="navNotificationCounters text-danger text-bold" data-count="<?php echo e($count); ?>">
            <?php echo e($count); ?>

        </small>
		<!--<small class="d-none d-sm-none d-md-inline-block"> <?php echo app('translator')->get('messages.newMessages'); ?></small>-->
    </a>
</div>
<?php /**PATH /home/jr5az3t0ng0l/public_html/resources/views/livewire/unread-messages-count.blade.php ENDPATH**/ ?>