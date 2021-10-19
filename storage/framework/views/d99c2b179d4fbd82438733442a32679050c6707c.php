<div class="col-12 col-md-4 d-none d-sm-none d-md-none d-lg-block">
	<div class="sticky-top sticky-sidebar">
	
	<?php if( isset($feed) && $feed->count() ): ?>
		<div class="lastId d-none"><?php echo e($feed->last()->id); ?></div>
	<?php endif; ?>

	<?php
if (! isset($_instance)) {
    $dom = \Livewire\Livewire::mount('creators-sidebar')->dom;
} elseif ($_instance->childHasBeenRendered('C7MJzAW')) {
    $componentId = $_instance->getRenderedChildComponentId('C7MJzAW');
    $componentTag = $_instance->getRenderedChildComponentTagName('C7MJzAW');
    $dom = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('C7MJzAW');
} else {
    $response = \Livewire\Livewire::mount('creators-sidebar');
    $dom = $response->dom;
    $_instance->logRenderedChild('C7MJzAW', $response->id, \Livewire\Livewire::getRootElementTagName($dom));
}
echo $dom;
?>

	<br>
	</div>
</div><?php /**PATH /home/jr5az3t0ng0l/public_html/resources/views/posts/sidebar-desktop.blade.php ENDPATH**/ ?>