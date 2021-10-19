

<?php $__env->startSection('seo_title'); ?> <?php echo app('translator')->get('navigation.my-blocked-users'); ?> - <?php $__env->stopSection(); ?>

<?php $__env->startSection( 'account_section' ); ?>

<div>


<div class="shadow-sm card add-padding">
	<h2 class="mt-3 ml-2 mb-4">
		<i class="fas fa-user-edit mr-1"></i> <?php echo app('translator')->get('navigation.my-blocked-users'); ?>
	</h2>

	<?php
if (! isset($_instance)) {
    $dom = \Livewire\Livewire::mount('user-blocked-users-list')->dom;
} elseif ($_instance->childHasBeenRendered('r4tPaHz')) {
    $componentId = $_instance->getRenderedChildComponentId('r4tPaHz');
    $componentTag = $_instance->getRenderedChildComponentTagName('r4tPaHz');
    $dom = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('r4tPaHz');
} else {
    $response = \Livewire\Livewire::mount('user-blocked-users-list');
    $dom = $response->dom;
    $_instance->logRenderedChild('r4tPaHz', $response->id, \Livewire\Livewire::getRootElementTagName($dom));
}
echo $dom;
?>
	
</div>

<br/><br/>
</div><!-- /.white-smoke-bg -->
<?php $__env->stopSection(); ?>
<?php echo $__env->make( 'account' , \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/ay8h3a64vt1a/public_html/resources/views/profile/my-blocked-users.blade.php ENDPATH**/ ?>