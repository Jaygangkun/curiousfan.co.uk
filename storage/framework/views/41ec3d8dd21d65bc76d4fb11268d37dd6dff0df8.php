<div>

<?php if( $blockedUsers->count() ): ?>

	<div class="row">

	<?php $__currentLoopData = $blockedUsers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $b): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

		<div class="col-6 col-sm-2 mb-3">
			<div class="profilePicSmall mt-0 ml-0 mr-2 mb-2 <?php if($b->user->isOnline()): ?> profilePicOnlineSm <?php else: ?> profilePicOfflineSm <?php endif; ?> shadow">
			<a href="<?php echo e($b->user->profile->url); ?>">
				<img src="<?php echo e(secure_image($b->user->profile->profilePic, 75, 75)); ?>" alt="" class="img-fluid">
			</a>
			</div>
		</div>
		<div class="col-6 col-sm-4 mb-3 profileFollowerList">
			<?php echo e($b->user->profile->name); ?><br>
			<br>
			<small>
                <a href="javascript:void(0);" wire:click="confirmCancellation(<?php echo e($b->id); ?>)" class='text-danger'>
                    <?php echo app('translator')->get('general.unBlock'); ?>
                </a>
			</small>
		</div>

		<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
	

	<?php echo e($blockedUsers->links()); ?>


	</div>
	<?php else: ?>
		<h3 class="text-secondary text-center"><i class="far fa-surprise"></i> <?php echo app('translator')->get( 'profile.noBlockedUsers' ); ?></h3>
	<?php endif; ?>


</div><?php /**PATH /home/ay8h3a64vt1a/public_html/resources/views/livewire/user-blocked-users-list.blade.php ENDPATH**/ ?>