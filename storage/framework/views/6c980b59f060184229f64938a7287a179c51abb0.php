<?php $__env->startSection('seo_title'); ?> <?php echo app('translator')->get('dashboard.accountSettings'); ?> - <?php $__env->stopSection(); ?>

<?php $__env->startSection( 'account_section' ); ?>


<div>
<form method="POST" action="<?php echo e(route( 'saveAccountSettings' )); ?>">
<?php echo csrf_field(); ?>
<div class="shadow-sm card add-padding">

<br/>
<h2 class="ml-2"><i class="fa fa-cog mr-2"></i><?php echo app('translator')->get('dashboard.accountSettings'); ?></h2>
<?php echo app('translator')->get( 'profile.profileSettingsText' ); ?>
<hr>

<div class="row">
	<div class="col-sm-8 col-12">
		<label><strong><?php echo app('translator')->get('dashboard.yourName'); ?></strong></label><br>
		<input type="text" name="name" class="form-control" value="<?php echo e(auth()->user()->name); ?>" required>
	</div>
</div>
<br>

<div class="row">
	<div class="col-sm-8 col-12">
		<label><strong><?php echo app('translator')->get('profile.email'); ?></strong></label><br>
		<input type="email" name="email" class="form-control" value="<?php echo e(auth()->user()->email); ?>" required>
	</div>
</div>
<br>

<div class="row">
	<div class="col-sm-8 col-12">
		<label><strong>New Password</strong> <small><?php echo app('translator')->get('profile.leaveEmpty'); ?></small></label><br>
		<input type="password" name="password" class="form-control">
	</div>
</div>
<br>

<div class="row">
	<div class="col-sm-8 col-12">
		<label><strong>Confirm New Password</strong> <small><?php echo app('translator')->get('profile.leaveEmpty'); ?></small></label><br>
		<input type="password" name="password_confirmation" class="form-control">
	</div>
</div>
<br>
<br>

<label><strong><?php echo app('translator')->get( 'profile.bankDetails' ); ?> <small><?php echo app('translator')->get('profile.ifBank'); ?></small></strong></label>
<div class="row">
	<?php
	$bank_name = '';
	$account_name = '';
	$sort_code = '';
	$account_number = '';

	$bank_details = explode('\n', $p->payout_details);
	if(count($bank_details) == 4)
	{
		$bank_name = explode(':', $bank_details[0])[1];
		$account_name = explode(':', $bank_details[1])[1];
		$sort_code = explode(':', $bank_details[2])[1];
		$account_number = explode(':', $bank_details[3])[1];
	}
	?>
	<div class="col-sm-8 col-12">
		<label for="bank_name">Bank Name</label>
		<input type="text" class="form-control" name="bank_name" id="bank_name" value="<?php echo e($bank_name); ?>" />
	</div>			
	<div class="col-sm-8 col-12">
		<label for="account_name">Account Name</label>				
		<input type="text" class="form-control" name="bank_account_name" id="account_name" value="<?php echo e($account_name); ?>" />
	</div>			
	<div class="col-sm-8 col-12">
		<label for="sort_code">Sort Code</label>				
		<input type="text" class="form-control" name="bank_sort_code" id="sort_code" value="<?php echo e($sort_code); ?>" />
	</div>
	<div class="col-sm-8 col-12">
		<label for="account_number">Account Number</label>				
		<input type="text" class="form-control" name="bank_account_number" id="account_number" value="<?php echo e($account_number); ?>" />
	</div>
</div>

</div><!-- /.white-bg -->
<br>

<div class="text-center">
  <input type="submit" name="sbStoreProfile" class="btn btn-lg btn-primary" value="<?php echo app('translator')->get('profile.saveAccountSettings'); ?>">
</div><!-- /.white-bg add-padding -->

</form>
<br/><br/>
</div><!-- /.white-smoke-bg -->
<?php $__env->stopSection(); ?>
<?php echo $__env->make( 'account' , \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/ay8h3a64vt1a/public_html/resources/views/profile/account-settings.blade.php ENDPATH**/ ?>