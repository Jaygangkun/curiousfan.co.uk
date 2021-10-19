<div>
    <a class="nav-link" href="<?php echo e(route('notifications.index')); ?>">
        <i class="fa fa-bell" aria-hidden="true"></i> <?php echo app('translator')->get('navigation.myNotifications'); ?> 
        
		<small class="navNotificationCounters text-danger text-bold" data-count="<?php echo e(auth()->user()->unreadNotifications()->count()); ?>"><?php echo e(auth()->user()->unreadNotifications()->count()); ?></small>
    </a>
</div>
<?php /**PATH /home/ay8h3a64vt1a/public_html/resources/views/livewire/notifications-icon.blade.php ENDPATH**/ ?>