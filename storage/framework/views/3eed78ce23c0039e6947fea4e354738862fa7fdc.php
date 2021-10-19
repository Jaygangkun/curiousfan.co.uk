<?php $__env->startSection('seo_title'); ?> <?php echo app('translator')->get('navigation.cards'); ?> - <?php $__env->stopSection(); ?>

<?php $__env->startSection( 'account_section' ); ?>


<?php echo csrf_field(); ?>
<div class="shadow-sm card add-padding">

<br/>
<h2 class="ml-2">
    <i class="fas fa-credit-card mr-1"></i> <?php echo app('translator')->get('navigation.cards'); ?></h2>
<hr>

<?php if(opt('card_gateway', 'Stripe') == 'Stripe'): ?>
    <a href="<?php echo e(route('addStripeCard')); ?>">+<?php echo app('translator')->get('general.addNewCard'); ?></a><br>
<?php elseif(opt('card_gateway', 'Stripe') == 'PayStack'): ?>
    <a href="<?php echo e(route('addPayStackCard')); ?>">+<?php echo app('translator')->get('general.addNewCard'); ?></a><br>
<?php endif; ?>

<?php
if (! isset($_instance)) {
    $dom = \Livewire\Livewire::mount('user-cards')->dom;
} elseif ($_instance->childHasBeenRendered('KF9pCSA')) {
    $componentId = $_instance->getRenderedChildComponentId('KF9pCSA');
    $componentTag = $_instance->getRenderedChildComponentTagName('KF9pCSA');
    $dom = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('KF9pCSA');
} else {
    $response = \Livewire\Livewire::mount('user-cards');
    $dom = $response->dom;
    $_instance->logRenderedChild('KF9pCSA', $response->id, \Livewire\Livewire::getRootElementTagName($dom));
}
echo $dom;
?>

<br/><br/>
</div><!-- /.white-smoke-bg -->
<?php $__env->stopSection(); ?>
<?php echo $__env->make( 'account' , \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/jr5az3t0ng0l/public_html/resources/views/billing/cards.blade.php ENDPATH**/ ?>