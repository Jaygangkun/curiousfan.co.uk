<?php $__env->startSection('seo_title'); ?> <?php echo app('translator')->get('navigation.myNotifications'); ?> - <?php $__env->stopSection(); ?>

<?php $__env->startSection( 'section_title' ); ?>
<i class="fa fa-code"></i> <?php echo app('translator')->get( 'navigation.myNotifications' ); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection( 'account_section' ); ?>

<?php echo $__env->yieldContent( 'account_section' ); ?>

<?php
if (! isset($_instance)) {
    $dom = \Livewire\Livewire::mount('notifications-page')->dom;
} elseif ($_instance->childHasBeenRendered('96pzlMD')) {
    $componentId = $_instance->getRenderedChildComponentId('96pzlMD');
    $componentTag = $_instance->getRenderedChildComponentTagName('96pzlMD');
    $dom = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('96pzlMD');
} else {
    $response = \Livewire\Livewire::mount('notifications-page');
    $dom = $response->dom;
    $_instance->logRenderedChild('96pzlMD', $response->id, \Livewire\Livewire::getRootElementTagName($dom));
}
echo $dom;
?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make( 'account' , \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/ay8h3a64vt1a/public_html/resources/views/profile/notifications.blade.php ENDPATH**/ ?>