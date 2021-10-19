<div class="col-12 col-md-3 mb-4  d-none d-sm-none d-md-none d-lg-block">
	
	<div class="sticky-top">
		<div class="card left-sidebar">
			<a class="mycount-icon" href="<?php echo e(route('accountSettings')); ?>" data-toggle="tooltip" title="<?php echo app('translator')->get('navigation.account'); ?>">
				<i class="fas fa-cog fa-2x"></i>
			</a>
			<center>
				<div class="profilePicSmall mt-3 ml-0">
					<img src="<?php echo e(secure_image(auth()->user()->profile->profilePic, 75, 75)); ?>" alt="" class="img-fluid">
				</div>
			</center>
			<div class="text-center text-secondary">
				<h4 style="mt-1">
					<?php echo e(auth()->user()->profile->name); ?>

				</h4>
				<?php if(auth()->user()): ?>
				<small><?php echo e('(' . opt('payment-settings.currency_symbol') . number_format(auth()->user()->balance,2) . ')'); ?></small>
				<?php endif; ?>
			</div>
			<div class="border-top pt-3 pb-3">
				<div class="text-center">
					
					<?php if(auth()->user()->isCreating == "Yes"): ?> 
						<B><?php echo app('translator')->get('post.creator'); ?></B>
					<?php else: ?>
						<B><?php echo app('translator')->get('post.supporter'); ?></B>
					<?php endif; ?>
				</div>
			</div>
			<div class="border-top pt-3 pb-3">
				<div class="text-center">
					<button id = "newPostBtn" class="btn  btn-primary mr-0 mb-2" style="padding: 5px 20px 5px 20px; font-size: 16px; border-radius: 16px;">
						<i class="fas fa-plus mr-1"></i> <?php echo app('translator')->get('post.newPost'); ?>
					</button>
				</div>
			</div>
		</div>
	</div>
</div><?php /**PATH /home/ay8h3a64vt1a/public_html/resources/views/posts/sidebar-mobile.blade.php ENDPATH**/ ?>