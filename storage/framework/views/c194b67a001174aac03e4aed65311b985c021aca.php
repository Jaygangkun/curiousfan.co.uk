<a wire:poll.3000ms class="nav-link waves-effect waves-light" href="<?php echo e(route('messages.inbox')); ?>">
    <?php if($count != 0): ?>
    <span class="badge badge-danger ml-2"><?php echo e($count); ?></span>
    <?php endif; ?>
    <i class="fas fa-envelope"></i>
</a><?php /**PATH /home/ay8h3a64vt1a/public_html/resources/views/livewire/unread-messages-count.blade.php ENDPATH**/ ?>