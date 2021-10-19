<?php $__env->startComponent('mail::message'); ?>
<?php if($emailBody): ?>
    <?php echo $emailBody; ?>

<?php else: ?>
Hi <?php echo e($withdraw->user->name); ?>,<br><br>

Good news, your payment request of <?php echo e(opt('payment-settings.currency_symbol') .  $withdraw->amount); ?> was processed<br>

It may take up 17 business days to show up on your account depending on your payout method.
<br><br>

<strong>Payout Gateway</strong>:<br>
<?php echo e($withdraw->user->profile->payout_gateway); ?>

<br>
<strong>Payout Details</strong>:<br>

<?php echo nl2br(e(str_replace('\n', ' ', $withdraw->user->profile->payout_details))); ?>


<br><br>

Regards,<br>
<?php echo e(env('APP_NAME')); ?>

<?php endif; ?>
<?php echo $__env->renderComponent(); ?><?php /**PATH /home/ay8h3a64vt1a/public_html/resources/views/emails/paymentRequestPaid.blade.php ENDPATH**/ ?>