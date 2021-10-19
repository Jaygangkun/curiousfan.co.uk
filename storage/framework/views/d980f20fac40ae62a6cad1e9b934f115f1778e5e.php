<?php $__env->startSection('seo_title'); ?> <?php echo app('translator')->get('navigation.my-subscriptions'); ?> - <?php $__env->stopSection(); ?>

<?php $__env->startSection( 'account_section' ); ?>

<div>


<div class="shadow-sm card add-padding">
	<h2 class="mt-3 ml-2 mb-4">
		<i class="fas fa-user-edit mr-1"></i> <?php echo app('translator')->get('navigation.my-subscriptions'); ?>
	</h2>

	<?php
if (! isset($_instance)) {
    $dom = \Livewire\Livewire::mount('user-subscriptions-list')->dom;
} elseif ($_instance->childHasBeenRendered('CVIp0C5')) {
    $componentId = $_instance->getRenderedChildComponentId('CVIp0C5');
    $componentTag = $_instance->getRenderedChildComponentTagName('CVIp0C5');
    $dom = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('CVIp0C5');
} else {
    $response = \Livewire\Livewire::mount('user-subscriptions-list');
    $dom = $response->dom;
    $_instance->logRenderedChild('CVIp0C5', $response->id, \Livewire\Livewire::getRootElementTagName($dom));
}
echo $dom;
?>
	
</div>

<br/><br/>
</div><!-- /.white-smoke-bg -->
<?php $__env->stopSection(); ?>
<?php echo $__env->make( 'account' , \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/jr5az3t0ng0l/public_html/resources/views/profile/my-subscriptions.blade.php ENDPATH**/ ?>