<?php $__env->startSection('section_title'); ?>
	<strong>Payments Settings</strong>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('section_body'); ?>

<?php
if (! isset($_instance)) {
    $dom = \Livewire\Livewire::mount('admin-payment-settings')->dom;
} elseif ($_instance->childHasBeenRendered('g6K49gm')) {
    $componentId = $_instance->getRenderedChildComponentId('g6K49gm');
    $componentTag = $_instance->getRenderedChildComponentTagName('g6K49gm');
    $dom = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('g6K49gm');
} else {
    $response = \Livewire\Livewire::mount('admin-payment-settings');
    $dom = $response->dom;
    $_instance->logRenderedChild('g6K49gm', $response->id, \Livewire\Livewire::getRootElementTagName($dom));
}
echo $dom;
?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.base', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/ay8h3a64vt1a/public_html/resources/views/admin/payments-setup.blade.php ENDPATH**/ ?>