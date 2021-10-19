<?php $__env->startComponent('mail::message'); ?>
<?php if($emailBody): ?>
    <?php echo $emailBody; ?>

<?php else: ?>
Hi,<br>

A new payment request of <?php echo e(opt('payment-settings.currency_symbol') .  $withdraw->amount); ?> was created by <?php echo e($withdraw->user->name); ?> <a href="<?php echo e(route('profile.show', ['username' => $withdraw->user->profile->username])); ?>"><?php echo e($withdraw->user->profile->handle); ?></a>

<br>

<a href="<?php echo e(route('admin.payment-requests')); ?>">
    View Payment Requests
</a>

<br><br>

Regards,<br>
<?php echo e(env('APP_NAME')); ?>

<?php endif; ?>
<?php echo $__env->renderComponent(); ?><?php /**PATH /home/ay8h3a64vt1a/public_html/resources/views/emails/paymentRequestCreated.blade.php ENDPATH**/ ?>