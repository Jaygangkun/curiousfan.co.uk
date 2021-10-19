<?php $__env->startSection('seo_title'); ?> <?php echo app('translator')->get('navigation.billing'); ?> - <?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="container mt-5">
    <div class="row">

        <div class="col-12 col-sm-12 col-md-6 offset-0 offset-sm-0 offset-md-3">
            <div class="card shadow-sm p-3 mb-3">
                
                <div class="alert alert-secondary text-center">
                    <h5>
                        <i class="fas fa-spinner fa-spin"></i>
                        <?php echo app('translator')->get('general.redirectingToStripe'); ?>
                    </h5>
                </div>
            
			    <input type="submit" class="btn btn-primary" value="<?php echo app('translator')->get('general.goToStripe'); ?>" id="checkout-button">

				<hr>
				<div class="row">
				<div class="col-12 col-sm-8">
				<img src="<?php echo e(asset('images/powered-by-stripe.png')); ?>" alt='stripe' class="img-fluid"/>
				</div>
				</div>

                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>


<?php $__env->startPush('extraJS'); ?>

<script src="https://js.stripe.com/v3/"></script>
<script>
	var stripe = Stripe('<?php echo e(opt('STRIPE_PUBLIC_KEY')); ?>');
	var checkoutButton = document.getElementById('checkout-button');
	
	checkoutButton.addEventListener('click', function() {
		stripe.redirectToCheckout({
			sessionId: '<?php echo e($stripeSession); ?>'
		}).then(function (result) {

			swal({
				title: result.error.message,
				message: '',
				icon: 'error'
			});

			console.log("Stripe result");
			console.log(result);
			
		});
    });
    
    checkoutButton.click(); 
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('welcome', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/jr5az3t0ng0l/public_html/resources/views/billing/stripe-add-card.blade.php ENDPATH**/ ?>