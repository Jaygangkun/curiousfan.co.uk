<div>

	<ul class="nav nav-tabs mb-3">
	<li class="nav-item">
		<a class="nav-link <?php if($tab == 'Free'): ?> active <?php endif; ?>" href="javascript:void(0);" wire:click="tab('Free')">
			<?php echo app('translator')->get('general.freeSubscribers'); ?>
		</a>
	</li>
	<li class="nav-item">
		<a class="nav-link <?php if($tab == 'Paid'): ?> active <?php endif; ?>" href="javascript:void(0);" wire:click="tab('Paid')">
			<?php echo app('translator')->get('general.paidSubscribers'); ?>
		</a>
	</li>
	</ul>

<?php if( $subscribers->count() ): ?>

	<div class="row">

	<?php if($tab == 'Paid'): ?>

		<?php $__currentLoopData = $subscribers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

		<div class="col-6 col-sm-2 mb-3">
			<div class="profilePicSmall mt-0 ml-0 mr-2 mb-2 <?php if($s->subscriber->isOnline()): ?> profilePicOnlineSm <?php else: ?> profilePicOfflineSm <?php endif; ?> shadow">
			<a href="<?php echo e($s->subscriber->profile->url); ?>">
				<img src="<?php echo e(secure_image($s->subscriber->profile->profilePic, 75, 75)); ?>" alt="" class="img-fluid">
			</a>
			</div>
		</div>
		<div class="col-6 col-sm-4 mb-3 profileFollowerList">
			<?php echo e($s->subscriber->profile->name); ?><br>
			<a href="<?php echo e($s->subscriber->profile->url); ?>"><?php echo e($s->subscriber->profile->handle); ?></a>
			<br>
			<small>
				<em class="badge badge-secondary">
					<?php echo app('translator')->get('general.expires'); ?> <?php echo e($s->subscription_expires->diffForHumans()); ?>

				</em><br>
			</small>
		</div>

		<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

	<?php elseif($tab == 'Free'): ?>

		<?php $__currentLoopData = $subscribers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

		<div class="col-6 col-sm-2 mb-3">
			<div class="profilePicSmall mt-0 ml-0 mr-2 mb-2 <?php if($s->isOnline()): ?> profilePicOnlineSm <?php else: ?> profilePicOfflineSm <?php endif; ?> shadow">
			<a href="<?php echo e($s->profile->url); ?>">
				<img src="<?php echo e(secure_image($s->profile->profilePic, 75, 75)); ?>" alt="" class="img-fluid">
			</a>
			</div>
		</div>
		<div class="col-6 col-sm-4 mb-3 profileFollowerList">
			<?php echo e($s->profile->name); ?><br>
			<a href="<?php echo e($s->profile->url); ?>"><?php echo e($s->profile->handle); ?></a>
			<br>
		</div>

		<br>
		<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

	<?php endif; ?>
	

	<?php echo e($subscribers->links()); ?>


	</div>
	<?php else: ?>
		<h3 class="text-secondary text-center"><i class="far fa-surprise"></i> <?php echo app('translator')->get( 'profile.noSubscriptions' ); ?></h3>
	<?php endif; ?>


</div><?php /**PATH /home/ay8h3a64vt1a/public_html/resources/views/livewire/user-subscribers-list.blade.php ENDPATH**/ ?>