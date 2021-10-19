<div>

    <div class="alert alert-secondary mt-2" wire:loading>
        <i class="fas fa-spinner fa-spin"></i> <?php echo app('translator')->get( 'profile.pleaseWait' ); ?>
    </div>

    <?php if($cards->count()): ?>

    <div class="alert alert-danger mb-2 <?php echo e($displayConfirm); ?>">
        <?php echo app('translator')->get('general.confirmCardDelete'); ?><br>
        <a href="javascript:void(0);" wire:click="removeCard('<?php echo e($confirmDeleteCardId); ?>')">
            Yes
        </a>
         / 
        <a href="javascript:void(0);" wire:click="cancelCardRemoval">
            No
        </a>
    </div>

    <div class="table-responsive">
    <table class="table">
    <thead>
        <tr>
            <th><?php echo app('translator')->get('general.card'); ?></th>
            <th><?php echo app('translator')->get('general.expiry'); ?></th>
            <th><?php echo app('translator')->get('general.isDefault'); ?></th>
            <th><?php echo app('translator')->get('general.remove'); ?></th>
        </tr>
    </thead>
    <tbody>
    <?php $__currentLoopData = $cards; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <tr>
        <td>
            <?php if($c->gateway == 'PayStack'): ?>
                **** **** **** <?php echo e($c->p_meta['last4']); ?>

            <?php elseif($c->gateway == 'Stripe'): ?>
                **** **** **** <?php echo e($c->p_meta['ending']); ?>

            <?php endif; ?>
        </td>
        <td>
            <?php if($c->gateway == 'PayStack'): ?>
                <?php echo e($c->p_meta['exp_month'] .'/'. $c->p_meta['exp_year']); ?>

            <?php elseif($c->gateway == 'Stripe'): ?>
                <?php echo e($c->p_meta['expiry']); ?>

            <?php endif; ?>
        </td>
        <td>
            <?php if($c->is_default == 'Yes'): ?>
                <i class="fas fa-check text-success text-bold"></i>
            <?php else: ?>
                <a href="javascript:void(0);" wire:click="setDefault('<?php echo e($c->id); ?>')">
                    <?php echo app('translator')->get('general.setAsDefaultCard'); ?>
                </a>
            <?php endif; ?>
        </td>
        <td>
            <a href="javascript:void(0);" wire:click="confirmDelete('<?php echo e($c->id); ?>')">
                <i class="far fa-trash-alt"></i>
            </a>
        </td>
    </tr>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </tbody>
    </table>
    </div>
    <?php endif; ?>
</div>
<?php /**PATH /home/ay8h3a64vt1a/public_html/resources/views/livewire/user-cards.blade.php ENDPATH**/ ?>