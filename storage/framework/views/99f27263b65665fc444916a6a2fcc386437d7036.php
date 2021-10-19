<?php $__env->startSection('seo_title'); ?> <?php echo app('translator')->get('navigation.billing'); ?> - <?php $__env->stopSection(); ?>

<?php $__env->startSection( 'account_section' ); ?>


<?php echo csrf_field(); ?>
<div class="shadow-sm card add-padding">

<br/>
<h2 class="ml-2">
    <i class="fas fa-file-invoice-dollar mr-1"></i> <?php echo app('translator')->get('navigation.billing'); ?></h2>
<hr>

<?php if(!$invoices->count()): ?>

<div class="alert alert-secondary">
    <?php echo app('translator')->get('general.noInvoices'); ?>
</div>

<?php else: ?>

<div class="table-responsive">
<table class="table table-alt">
<thead>
    <tr>
        <th><?php echo app('translator')->get('general.amount'); ?></th>
        <th><?php echo app('translator')->get('general.details'); ?></th>

        <?php if(opt('card_gateway', 'Stripe') == 'Stripe'): ?>
            <th><?php echo app('translator')->get('general.viewInvoice'); ?></th>
        <?php endif; ?>

        <th><?php echo app('translator')->get('general.status'); ?></th>
        <th><?php echo app('translator')->get('general.date'); ?></th>
    </tr>
</thead>
<tbody>
    <?php $__currentLoopData = $invoices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <tr>
        <td><?php echo e(opt('payment-settings.currency_symbol') . $i->amount); ?></td>
        <td>
            <?php echo app('translator')->get('general.subscriptionDetails', [
                'creator' => '<a href="'.route('profile.show', ['username' => $i->subscription->creator->profile->username]).'">'.$i->subscription->creator->profile->handle.'</a>'
            ]); ?>
        </td>
        <td>
            <?php if(opt('card_gateway', 'Stripe') == 'Stripe'): ?>
                <a href="<?php echo e($i->invoice_url); ?>" target="_blank"><?php echo app('translator')->get('general.view_invoice'); ?></a>
            <?php endif; ?>
        </td>
        <td>
            <?php if($i->payment_status == 'Created'): ?>
                <?php echo app('translator')->get('general.statusCreated'); ?>
            <?php elseif($i->payment_status == 'Paid'): ?>
                <?php echo app('translator')->get('general.statusPaid'); ?>
            <?php elseif($i->payment_status == 'Action Required'): ?>
                <?php echo app('translator')->get('general.statusRequiresAction'); ?>
            <?php endif; ?>
        </td>
        <td>
            <?php echo e($i->created_at->format('jS F Y')); ?><br>
            <?php echo e($i->created_at->format('H:i A')); ?>

        </td>
    </tr>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</tbody>
</table>
</div>

<?php echo e($invoices->links()); ?>


<?php endif; ?>

<br/><br/>
</div><!-- /.white-smoke-bg -->
<?php $__env->stopSection(); ?>
<?php echo $__env->make( 'account' , \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/jr5az3t0ng0l/public_html/resources/views/billing/history.blade.php ENDPATH**/ ?>