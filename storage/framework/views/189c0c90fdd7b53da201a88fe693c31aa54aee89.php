<div>
    <a href="javascript:void(0);" class="btn btn-danger btn-sm" style="border-radius:16px; padding:6px 15px;" wire:click="toggleFollow">
	<i class="fas fa-hand-sparkles mr-1"></i> <span class="follow-text">
	<?php if( auth()->check() && !auth()->user()->isFollowing( $this->profile->user->id ) ): ?>
		 <?php echo app('translator')->get( 'profile.subscribe' ); ?>
	<?php elseif( auth()->check() && auth()->user()->isFollowing( $this->profile->user->id ) ): ?>
		 <?php echo app('translator')->get( 'profile.unsubscribe' ); ?>
	<?php else: ?>
		<?php echo app('translator')->get( 'profile.subscribe' ); ?>
	<?php endif; ?>
	</span>
	</a>
	<div wire:loading wire:target="toggleFollow">
        <i class="fas fa-spinner fa-spin"></i> <?php echo app('translator')->get( 'profile.pleaseWait' ); ?>
    </div>
</div>
<?php /**PATH /home/ay8h3a64vt1a/public_html/resources/views/livewire/followbutton.blade.php ENDPATH**/ ?>