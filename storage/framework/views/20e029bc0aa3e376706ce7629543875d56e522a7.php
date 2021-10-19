<div>
    <a class="nav-link" href="<?php echo e(route('notifications.index')); ?>">
        <?php echo app('translator')->get('navigation.myNotifications'); ?> 
        
		<small class="navNotificationCounters text-danger text-bold" data-count="<?php echo e(auth()->user()->unreadNotifications()->count()); ?>"><?php echo e(auth()->user()->unreadNotifications()->count()); ?></small>
    </a>
</div>
<?php /**PATH /home/jr5az3t0ng0l/public_html/resources/views/livewire/notifications-icon.blade.php ENDPATH**/ ?>