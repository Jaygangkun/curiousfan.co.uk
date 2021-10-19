<?php $__env->startSection('seo_title'); ?> <?php echo app('translator')->get('navigation.myNotifications'); ?> - <?php $__env->stopSection(); ?>

<?php $__env->startSection( 'section_title' ); ?>
<i class="fa fa-code"></i> <?php echo app('translator')->get( 'navigation.myNotifications' ); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection( 'account_section' ); ?>

<?php echo $__env->yieldContent( 'account_section' ); ?>

<?php
if (! isset($_instance)) {
    $dom = \Livewire\Livewire::mount('notifications-page')->dom;
} elseif ($_instance->childHasBeenRendered('r9SEgKN')) {
    $componentId = $_instance->getRenderedChildComponentId('r9SEgKN');
    $componentTag = $_instance->getRenderedChildComponentTagName('r9SEgKN');
    $dom = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('r9SEgKN');
} else {
    $response = \Livewire\Livewire::mount('notifications-page');
    $dom = $response->dom;
    $_instance->logRenderedChild('r9SEgKN', $response->id, \Livewire\Livewire::getRootElementTagName($dom));
}
echo $dom;
?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make( 'account' , \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/jr5az3t0ng0l/public_html/resources/views/profile/notifications.blade.php ENDPATH**/ ?>