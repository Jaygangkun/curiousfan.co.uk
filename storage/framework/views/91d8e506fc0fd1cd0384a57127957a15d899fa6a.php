<?php $__env->startSection('seo_title'); ?> <?php echo app('translator')->get('dashboard.profileVerified'); ?> - <?php $__env->stopSection(); ?>

<?php $__env->startSection( 'account_section' ); ?>

<div>


<div class="shadow-sm card add-padding">
	<h2>
		<h2 class="ml-2"><i class="fas fa-user-check mr-2"></i><?php echo app('translator')->get('dashboard.verify-profile'); ?></h2>
	</h2>
	<hr>

	<div class="alert alert-success">
		<i class="fas fa-check-circle"></i> <?php echo app('translator')->get( 'dashboard.profileVerified' ); ?>
	</div>

	<p class="text-center">
		
		<?php echo app('translator')->get( 'dashboard.startSettingPayments' ); ?>
		<br><br>

		<a href="<?php echo e(route( 'profile.setFee' )); ?>" class="btn btn-primary btn-sm">
			<?php echo app('translator')->get('dashboard.creatorSetup'); ?>
		</a>

	</p>

	<br>

</div>

<br/><br/>
</div><!-- /.white-smoke-bg -->
<?php $__env->stopSection(); ?>
<?php echo $__env->make( 'account' , \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/ay8h3a64vt1a/public_html/resources/views/profile/verified.blade.php ENDPATH**/ ?>