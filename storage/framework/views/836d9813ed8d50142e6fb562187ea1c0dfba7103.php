<?php $__env->startComponent('mail::message'); ?>
<?php if($emailBody): ?>
    <?php echo $emailBody; ?>

<?php else: ?>
<p>Hello There,</p>
<p>Please click the button below to verify your email address.</p>
<p><a href="<?php echo e($verifyUrl); ?>">Verify Your Email</a></p>
<p>Regards,<br /><?php echo e(env('APP_NAME')); ?></p>
<hr />
<p>If you&rsquo;re having trouble clicking the "Verify Now" button, copy and paste the URL below into your web browser:&nbsp;<a href="<?php echo e($verifyUrl); ?>"><?php echo e($verifyUrl); ?></a></p>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?><?php /**PATH /home/ay8h3a64vt1a/public_html/resources/views/emails/emailVerifyMail.blade.php ENDPATH**/ ?>