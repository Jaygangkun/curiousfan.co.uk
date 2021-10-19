<?php $__env->startSection('seo_title'); ?> <?php echo app('translator')->get('navigation.my-subscribers'); ?> - <?php $__env->stopSection(); ?>

<?php $__env->startSection( 'account_section' ); ?>

<div>


<div class="shadow-sm card add-padding">
	<h2 class="mt-3 ml-2 mb-4">
		<i class="fas fa-user-lock mr-1"></i> <?php echo app('translator')->get('navigation.my-subscribers'); ?>
	</h2>

	<?php
if (! isset($_instance)) {
    $dom = \Livewire\Livewire::mount('user-subscribers-list', [ 'subscribers' => $subscribers ])->dom;
} elseif ($_instance->childHasBeenRendered('EXwkPx8')) {
    $componentId = $_instance->getRenderedChildComponentId('EXwkPx8');
    $componentTag = $_instance->getRenderedChildComponentTagName('EXwkPx8');
    $dom = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('EXwkPx8');
} else {
    $response = \Livewire\Livewire::mount('user-subscribers-list', [ 'subscribers' => $subscribers ]);
    $dom = $response->dom;
    $_instance->logRenderedChild('EXwkPx8', $response->id, \Livewire\Livewire::getRootElementTagName($dom));
}
echo $dom;
?>

	<br>

</div>

<br/><br/>
</div><!-- /.white-smoke-bg -->
<?php $__env->stopSection(); ?>
<?php echo $__env->make( 'account' , \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/jr5az3t0ng0l/public_html/resources/views/profile/my-subscribers.blade.php ENDPATH**/ ?>