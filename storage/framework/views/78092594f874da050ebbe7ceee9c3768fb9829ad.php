<div class="col-12 col-md-3 d-none d-sm-none d-md-none d-lg-block">
	<div class="sticky-top">
	
	<?php if( isset($feed) && $feed->count() ): ?>
		<div class="lastId d-none"><?php echo e($feed->last()->id); ?></div>
	<?php endif; ?>

	<?php
if (! isset($_instance)) {
    $dom = \Livewire\Livewire::mount('creators-sidebar')->dom;
} elseif ($_instance->childHasBeenRendered('MRdVyLU')) {
    $componentId = $_instance->getRenderedChildComponentId('MRdVyLU');
    $componentTag = $_instance->getRenderedChildComponentTagName('MRdVyLU');
    $dom = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('MRdVyLU');
} else {
    $response = \Livewire\Livewire::mount('creators-sidebar');
    $dom = $response->dom;
    $_instance->logRenderedChild('MRdVyLU', $response->id, \Livewire\Livewire::getRootElementTagName($dom));
}
echo $dom;
?>

	<br>
	</div>
</div><?php /**PATH /home/ay8h3a64vt1a/public_html/resources/views/posts/sidebar-desktop.blade.php ENDPATH**/ ?>