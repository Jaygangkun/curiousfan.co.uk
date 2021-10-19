<?php $__env->startComponent('mail::message'); ?>

Hi <?php echo e($withdraw->user->name); ?>,<br><br>

Good news, your payment request of <?php echo e(opt('payment-settings.currency_symbol') .  $withdraw->amount); ?> was processed<br>

It may take up 17 business days to show up on your account depending on your payout method.
<br><br>

<strong>Payout Gateway</strong>:<br>
<?php echo e($withdraw->user->profile->payout_gateway); ?>

<br>
<strong>Payout Details</strong>:<br>

<?php echo nl2br(e($withdraw->user->profile->payout_details)); ?>


<br><br>

Regards,<br>
<?php echo e(env('APP_NAME')); ?>


<?php echo $__env->renderComponent(); ?><?php /**PATH /home/jr5az3t0ng0l/public_html/resources/views/emails/paymentRequestPaid.blade.php ENDPATH**/ ?>