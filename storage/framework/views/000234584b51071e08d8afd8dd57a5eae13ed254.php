
<?php if( $feed->count() ): ?>

	<?php $__currentLoopData = $feed; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
		<?php $__env->startComponent( 'posts.single', [ 'post' => $post ] ); ?> <?php echo $__env->renderComponent(); ?>
	<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

<?php else: ?>
	<div class="card shadow p-4 mb-4 text-center" style="padding: 10px;
            border: 2px solid #FFFFFF;
            border-radius: 11px;">
		<h3 class="text-secondary">
			<i class="fas fa-comment-slash"></i> <?php echo app('translator')->get( 'post.noPosts', [ 'handle' => $profile->handle ] ); ?>
		</h3>
	</div>
<?php endif; ?><?php /**PATH /home/ay8h3a64vt1a/public_html/resources/views/posts/feed.blade.php ENDPATH**/ ?>