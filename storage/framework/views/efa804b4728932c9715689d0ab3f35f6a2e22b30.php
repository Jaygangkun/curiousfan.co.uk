<?php $__env->startComponent('mail::message'); ?>
<?php if($emailBody): ?>
    <?php echo $emailBody; ?>

<?php else: ?>
<p>You are receiving this email because we received a password reset request for your account.</p>
<p><a href="<?php echo e($resetURL); ?>">Reset Password</a></p>
<p>If you did not request a password reset, no further action is required.</p>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?><?php /**PATH /home/ay8h3a64vt1a/public_html/resources/views/emails/resetPasswordMail.blade.php ENDPATH**/ ?>