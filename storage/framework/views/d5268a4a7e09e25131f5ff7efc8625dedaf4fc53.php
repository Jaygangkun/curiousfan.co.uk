<div>

    <?php if($tab == 'Pending'): ?>
        <h5><?php echo app('translator')->get('general.createWithdrawRequest'); ?></h5>
        <?php if(auth()->user()->balance >= opt('withdraw_min', 20)): ?>

        <?php if(isset($withdrawals) && (is_object($withdrawals) AND count($withdrawals))): ?>
            <?php echo app('translator')->get('general.waitUntilPending'); ?>
        <?php else: ?>
        <div class="alert alert-warning">
            <?php echo app('translator')->get('general.youCanWithdraw', ['balance' => opt('payment-settings.currency_symbol') . auth()->user()->balance ]); ?>
        </div>
        <div class="form-group">
            <label class="sr-only" for="exampleInputAmount">Amount (in Swiss Francs)</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon1"><?php echo e(opt('payment-settings.currency_symbol')); ?></span>
                </div>
                <input type="number" id="request_amount_input" wire:model.lazy="requestAmount" wire:loading.class="disabled" min="0.00" max="<?php echo e(auth()->user()->balance); ?>" step="0.05" value="1.00" onchange="" class="form-control" placeholder="Amount">
                <a href="javascript:void(0)" wire:click="sendRequest" class="btn btn-primary" wire:loading.class="disabled">
                    <?php echo app('translator')->get('general.sendWithdrawalRequest'); ?>
                </a>
            </div>
        </div>

        <?php endif; ?>

        <br><br>

        <?php else: ?>
            <div class="alert alert-warning">
                <?php echo app('translator')->get('general.withdrawMin', ['minWithdrawAmount' => opt( 'payment-settings.currency_symbol' ) . opt('withdraw_min', 20)]); ?>
            </div>
        <?php endif; ?>
    <?php endif; ?>

    <ul class="nav nav-tabs">
		<li class="nav-item">
            <a href="javascript:void(0)" class="nav-link <?php if($tab == 'Pending'): ?> active <?php endif; ?>" wire:click='tab("Pending")'>
                <?php echo app('translator')->get('general.pendingWithdrawals'); ?>
            </a>
        </li>
		<li class="nav-item">
            <a href="javascript:void(0)" class="nav-link <?php if($tab == 'Paid'): ?> active <?php endif; ?>" wire:click='tab("Paid")'>
                <?php echo app('translator')->get('general.paidWithdrawals'); ?>
            </a>
        </li>
        <li class="nav-item">
            <a href="javascript:void(0)" class="nav-link <?php if($tab == 'Cancelled'): ?> active <?php endif; ?>" wire:click='tab("Cancelled")'>
                <?php echo app('translator')->get('general.canceledWithdrawals'); ?>
            </a>
        </li>
    </ul>

    <?php if(isset($withdrawals) && (is_object($withdrawals) AND count($withdrawals))): ?>

    <div class="table-responsive">
    <table class="table table-striped">
    <thead>
        <tr>
            <th><?php echo app('translator')->get('general.withdrawId'); ?></th>
            <th><?php echo app('translator')->get('general.withdrawAmount'); ?></th>
            <th><?php echo app('translator')->get('general.withdrawDate'); ?></th>
            <th><?php echo app('translator')->get('general.withdrawStatus'); ?></th>
            <?php if($tab == 'Pending'): ?>
                <th><?php echo app('translator')->get('general.cancelWithdraw'); ?></th>
            <?php endif; ?>
        </tr>
    </thead>
    <tbody>
    <?php $__currentLoopData = $withdrawals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $w): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <tr>
            <td><?php echo e($w->id); ?></td>
            <td><?php echo e(opt('payment-settings.currency_symbol') . number_format($w->amount,2)); ?></td>
            <td><?php echo e(niceShort($w->updated_at)); ?></td>
            <td>
                <?php if($tab == 'Pending'): ?>
                    <?php echo app('translator')->get('general.pendingWithdrawals'); ?>
                <?php elseif($tab == 'Cancelled'): ?>
                    <?php echo app('translator')->get('general.canceledWithdrawals'); ?>
                <?php else: ?>
                    <?php echo app('translator')->get('general.paidWithdrawals'); ?>
                <?php endif; ?>
            </td>
            <?php if($tab == 'Pending'): ?>
                <td>
                    <a href="javascript:void(0)" wire:click="cancelPending('<?php echo e($w->id); ?>')">
                        <?php echo app('translator')->get('general.cancelWithdraw'); ?>
                    </a>
                </td>
            <?php endif; ?>
        </tr>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </tbody>
    </table>
    </div>
    
    <?php echo e($withdrawals->links()); ?>


    <?php else: ?>
        <div class="alert alert-light mt-2">
            <?php echo app('translator')->get('general.noWithdrawalRequests', ['type' => $tab]); ?>
        </div>
    <?php endif; ?>
    
</div>
<?php /**PATH /home/ay8h3a64vt1a/public_html/resources/views/livewire/withdrawals.blade.php ENDPATH**/ ?>