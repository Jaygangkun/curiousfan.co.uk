<?php $__currentLoopData = $media->groupBy('message_id'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $msgMedia): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

    <?php if($msgMedia->first()->lock_type == 'Free' ||
        $msgMedia->first()->lock_type == ''  ||
        empty($msgMedia->first()->lock_type)  ||
        auth()->id() == $msg->from_id ||
        App\Unlock::where('message_id', $msg->id)->where('payment_status', 'Paid')->where('tipper_id', auth()->id())->exists()): ?>

        <div class="row">
            <?php if($msgMedia->first()->lock_type == 'Paid' && auth()->id() == $msg->from_id): ?>
            <style>
                .paidAttachment{
                    position: absolute;
                    z-index: 9999;
                    width:auto;
                    padding: 0 10px;
                    height:30px;
                    <?php if($utype == 'fromUser'): ?>
                    margin-left:-25px;
                    top:0;
                    <?php else: ?>
                    right:10px;
                    top:-10px;
                    <?php endif; ?>
                    background: #dc3545;
                    border-radius: 10px;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    color:#FFFFFF;
                    font-size: 14px;
                }
                @media(max-width:767px){
                    .paidAttachment{font-size:10px;}
                }
            </style>
            <div class="paidAttachment">Paid Attachment (<?php echo e(opt('payment-settings.currency_symbol') . number_format($msgMedia->first()->lock_price,2)); ?>)</div>
                <?php elseif($msgMedia->first()->lock_type == 'Free' && auth()->id() == $msg->from_id): ?>
                <style>
                    .freeAttachment{
                        position: absolute;
                        z-index: 9999;
                        width:auto;
                        padding:0 10px;
                        height:30px;
                        <?php if($utype == 'fromUser'): ?>
                        margin-left:-25px;
                        top:0;
                        <?php else: ?>
                        right:10px;
                        top:-10px;
                        <?php endif; ?>
                        background: #4caf50;
                        border-radius: 10px;
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        color:#FFFFFF;
                        font-size: 14px;
                    }
                    @media(max-width:767px){
                        .freeAttachment{font-size:10px;}
                    }
                </style>
                <div class="freeAttachment">Free Attachment</div>
            <?php endif; ?>
            <?php $__currentLoopData = $msgMedia; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mm): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php echo $__env->make('messages.single-media', ['media' => $mm], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

    <?php elseif($msgMedia->first()->lock_type == 'Paid' && $msgMedia->first()->lock_price > 0): ?>
        <?php if($msgMedia->first()->lock_type == 'Paid'): ?>
        <?php endif; ?>
    <div class="dropdown show z-9999">

        <a href="javascript:void(0)" class="btn btn-primary btn-sm mb-2 dropdown-toggle" id="premiumPostsLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <?php echo app('translator')->get('v19.unlockLinkTitle'); ?> <?php echo e(opt('payment-settings.currency_symbol') . number_format($msgMedia->first()->lock_price,2)); ?>

        </a>

        <div class="dropdown-menu" aria-labelledBy="premiumPostsLink">

            
            <?php if(opt('card_gateway', 'Stripe') == 'Stripe'): ?>
                <?php if(auth()->check() && opt('stripeEnable', 'No') == 'Yes' && auth()->user()->paymentMethods()->count()): ?>
                    <a class="dropdown-item" href="<?php echo e(route('unlockMessage', [ 'gateway' => 'Card', 'message' => $msg->id ])); ?>">
                        <?php echo app('translator')->get('general.creditCard'); ?>
                    </a>
                <?php elseif(auth()->check() && !auth()->user()->paymentMethods()->count() && opt('stripeEnable', 'No') == 'Yes'): ?>
                    <a class="dropdown-item" href="<?php echo e(route('billing.cards')); ?>">
                        <?php echo app('translator')->get('general.addNewCard'); ?>
                    </a>
                <?php elseif(opt('stripeEnable', 'No') == 'Yes'): ?>
                    <a class="dropdown-item" href="<?php echo e(route('login')); ?>">
                        <?php echo app('translator')->get('general.creditCard'); ?>
                    </a>
                <?php endif; ?>
            <?php endif; ?>

            
            <?php if(opt('card_gateway', 'Stripe') == 'CCBill'): ?>
                <a class="dropdown-item" href="<?php echo e(route('unlockMessage', [ 'gateway' => 'Card', 'message' => $msg->id ])); ?>">
                    <?php echo app('translator')->get('general.creditCard'); ?>
                </a>
            <?php endif; ?>

            
            <?php if(opt('card_gateway', 'Stripe') == 'PayStack'): ?>
                <?php if(auth()->check() && auth()->user()->paymentMethods()->count()): ?>
                    <a class="dropdown-item" href="<?php echo e(route('unlockMessage', [ 'gateway' => 'Card', 'message' => $msg->id ])); ?>">
                        <?php echo app('translator')->get('general.creditCard'); ?>
                    </a>
                <?php elseif(auth()->check() && !auth()->user()->paymentMethods()->count()): ?>
                    <a class="dropdown-item" href="<?php echo e(route('billing.cards')); ?>">
                        <?php echo app('translator')->get('general.addNewCard'); ?>
                    </a>
                <?php else: ?>
                    <a class="dropdown-item" href="<?php echo e(route('login')); ?>">
                        <?php echo app('translator')->get('general.creditCard'); ?>
                    </a>
                <?php endif; ?>
            <?php endif; ?>

            
            <?php if(opt('card_gateway', 'Stripe') == 'MercadoPago'): ?>
                <a class="dropdown-item" href="<?php echo e(route('unlockMessage', [ 'gateway' => 'Card', 'message' => $msg->id ])); ?>">
                    <?php echo app('translator')->get('general.creditCard'); ?>
                </a>
            <?php endif; ?>

            
            <?php if(opt('card_gateway', 'Stripe') == 'TransBank'): ?>
                <a class="dropdown-item" href="<?php echo e(route('unlockMessage', [ 'gateway' => 'Card', 'message' => $msg->id ])); ?>">
                    <?php echo app('translator')->get('general.creditCard'); ?>
                </a>
            <?php endif; ?>

            
            <?php if(opt('paypalEnable', 'No') == 'Yes'): ?>
                <a class="dropdown-item" href="<?php echo e(route('unlockMessage', [ 'gateway' => 'PayPal', 'message' => $msg->id ])); ?>">
                    <?php echo app('translator')->get('general.PayPal'); ?>
                </a>
            <?php endif; ?>
        </div>
    </div>

    <?php endif; ?>

<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php /**PATH /home/ay8h3a64vt1a/public_html/resources/views/messages/message-media.blade.php ENDPATH**/ ?>