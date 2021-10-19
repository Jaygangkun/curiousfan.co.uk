<?php $__env->startSection('section_title'); ?>
	<strong>Payments Settings</strong>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('section_body'); ?>

<?php
if (! isset($_instance)) {
    $dom = \Livewire\Livewire::mount('admin-payment-settings')->dom;
} elseif ($_instance->childHasBeenRendered('Kfpxj05')) {
    $componentId = $_instance->getRenderedChildComponentId('Kfpxj05');
    $componentTag = $_instance->getRenderedChildComponentTagName('Kfpxj05');
    $dom = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('Kfpxj05');
} else {
    $response = \Livewire\Livewire::mount('admin-payment-settings');
    $dom = $response->dom;
    $_instance->logRenderedChild('Kfpxj05', $response->id, \Livewire\Livewire::getRootElementTagName($dom));
}
echo $dom;
?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.base', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/jr5az3t0ng0l/public_html/resources/views/admin/payments-setup.blade.php ENDPATH**/ ?>