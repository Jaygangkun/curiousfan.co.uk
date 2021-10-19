

<?php $__env->startSection('title', $profile->name); ?>
<?php $__env->startSection('description', $profile->creating); ?>
<?php $__env->startSection('image', config('app.url') . '/public/uploads/' . $profile->profilePic); ?>

<?php $__env->startSection('content'); ?>
<div class="white-smoke-bg white-smoke-bg-profile-page">
<div class="white-bg shadow-sm p-0">
<div class="container add-padding">
	<div class="row">
		<div class="col-md-12">
			<div class="coverPic" style="border-radius: 0 0 12px 12px;">
				<?php if($profile->user_id == auth()->user()->id): ?>
				<div class="coverPic-wrap">
					<div id="coverPic"></div>
				</div>
				<div class="text-center uploadBtn btn" style="padding:6px 6px 6px 16px; position: absolute; right: 10px; bottom: 10px;background-color: #FFF;color:#000;z-index: 99;">
					<span><i class="far fa-edit mr-1"></i></span>
					<input type="file" id="uploadCoverPic" value="Choose a file" accept="image/*" />
				</div>
				<button class="text-center saveCoverPic btn btn-success" style="position: absolute; right: 70px; bottom: 10px;z-index: 99;">Save Cover Picture</button>
				<?php else: ?>
					<a class="coverPic" data-fancybox href="<?php echo e(asset('public/uploads/' . $profile->coverPicture)); ?>"></a>
				<?php endif; ?>
			</div>
		</div>
	</div>
<div class="row">
<div class="col-12 col-sm-4 col-md-3 col-lg-2 mb-1 mb-sm-0">
	<div class="customdv " style="position: relative">
		
		<?php if($profile->user->isOnline()): ?> 
			<div class = "profilePicOnline " data-toggle="tooltip" title="I'm online!">
		    </div>
	
		<?php endif; ?> 
			<?php if($profile->user_id == auth()->user()->id): ?>
				<div class="profileCameraIcon">
					<a href="#" data-toggle="modal" data-target="#uploadProfileImageModel">
						<img style="border-color:#3a3b3c" src="<?php echo e(config('app.url')); ?>/images/photo-camera.png">
					</a>
				</div>
			<?php endif; ?>
			<div class="profilePic shadow">
				<a data-fancybox href="<?php echo e(config('app.url')); ?>/public/uploads/<?php echo e($profile->profilePic); ?>">
					<img src="<?php echo e(config('app.url')); ?>/public/uploads/<?php echo e($profile->profilePic); ?>" alt="profile pic" class="img-fluid profilePicUpdate">
					<!--img src="<?php echo e(config('app.url')); ?>/public/uploads/profilePics/default-profile-pic.png" alt="profile pic" class="img-fluid profilePicUpdate"-->
				</a>

				
			</div>
		
	</div>
<?php if($profile->user_id == auth()->user()->id): ?>
<div class="text-center">
    <a class="btn btn-primary mt-4" style="border-radius:16px; padding:6px 15px;" href="/my-profile" role="button"><i class="far fa-edit mr-1"></i> Edit profile</a>
</div>
<?php endif; ?>
</div>

<div class="col-12 col-sm-8 col-md-9 col-lg-10 text-center text-sm-left">
	<div class="row">
		<div class="col-12 col-sm-6">
			<h4 class="profile-name">
				<a href="<?php echo e($profile->url); ?>">
					<?php echo e($profile->name); ?>

				</a>
			</h4>
			<a href="<?php echo e($profile->url); ?>">
				<?php echo e($profile->handle); ?> <?php if($profile->isVerified == 'Yes'): ?> <i class="fas fa-check-circle text-primary"></i> <?php endif; ?>  
			</a>
			<br><br>
			<?php
              	$customD = json_decode($profile->custom_data);
			?>
			<i class="far fa-grin-stars mr-1"></i> <?php if(@$customD->fans && $customD->fans > @$profile->fans_count): ?><?php echo e(@$customD->fans + $profile->fans_count); ?> <?php else: ?> <?php echo e($profile->fans_count); ?> <?php endif; ?> <?php echo app('translator')->get('general.paid-fans'); ?>
			<br>
			
			<i class="fas fa-users"></i> <?php if(@$customD->subscribers && @$customD->subscribers > $profile->followers->count()): ?><?php echo e(@$customD->subscribers + $profile->followers->count()); ?> <?php else: ?> <?php echo e(@$profile->followers->count()); ?> <?php endif; ?> <?php echo app('translator')->get('general.free-subscribers'); ?>
			<br>

			<i class="fas fa-align-left" data-toggle="tooltip" title="Total Posts"></i> <?php echo e($profile->posts->count()); ?> &nbsp;
			<i class="fas fa-image" data-toggle="tooltip" title="Images"></i> <?php echo e($profile->posts->where('media_type', 'Image')->count()); ?> &nbsp;
			<i class="fas fa-music" data-toggle="tooltip" title="Audios"></i> <?php echo e($profile->posts->where('media_type', 'Audio')->count()); ?> &nbsp;
			<i class="fas fa-video" data-toggle="tooltip" title="Videos"></i> <?php echo e($profile->posts->where('media_type', 'Video')->count()); ?> 
		</div>

		<div class="col-12 col-sm-5">

			<h4 class="profile-name">
				<?php echo app('translator')->get( 'profile.follow' ); ?>
			</h4>

			<?php if($profile->monthlyFee): ?>

				<?php if(auth()->check() && auth()->user()->hasSubscriptionTo($profile->user)): ?>
					<a href="<?php echo e(route('mySubscriptions')); ?>" style="border-radius:16px; padding:6px 15px;" class="btn btn-danger btn-sm mb-2"><i class="fas fa-eye"></i> <?php echo app('translator')->get('general.viewSubscription'); ?></a>
				<?php else: ?>
					<div class="dropdown show ">
					<a href="javascript:void(0)" class="btn btn-danger btn-sm mb-2 dropdown-toggle" style="border-radius:16px; padding:6px 15px;" id="premiumPostsLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<i class="fa fa-unlock mr-1"></i> <?php echo app('translator')->get( 'profile.unlock' ); ?> - <?php echo e(opt('payment-settings.currency_symbol') . number_format($profile->monthlyFee,2)); ?>

					</a>
					<div class="dropdown-menu" aria-labelledBy="premiumPostsLink">

						
						<?php if(opt('card_gateway', 'Stripe') == 'Stripe'): ?>
							<?php if(auth()->check() && opt('stripeEnable', 'No') == 'Yes' && auth()->user()->paymentMethods()->count()): ?>
								<a class="dropdown-item" href="<?php echo e(route('subscribeCreditCard', [ 'user' => $profile->user->id ])); ?>">
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
							<a class="dropdown-item" href="<?php echo e(route('subscribeCCBill', [ 'user' => $profile->user->id ])); ?>">
								<?php echo app('translator')->get('general.creditCard'); ?>
							</a>
						<?php endif; ?>

						
						<?php if(opt('card_gateway', 'Stripe') == 'PayStack'): ?>
							<?php if(auth()->check() && auth()->user()->paymentMethods()->count()): ?>
								<a class="dropdown-item" href="<?php echo e(route('subscribePayStack', [ 'user' => $profile->user->id ])); ?>">
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
							<?php if(auth()->check()): ?>
								<a class="dropdown-item" href="<?php echo e(route('subscribeMercadoPago', [ 'user' => $profile->user->id ])); ?>">
									<?php echo app('translator')->get('general.creditCard'); ?>
								</a>
							<?php else: ?>
								<a class="dropdown-item" href="<?php echo e(route('login')); ?>">
									<?php echo app('translator')->get('general.creditCard'); ?>
								</a>
							<?php endif; ?>
						<?php endif; ?>

						
						<?php if(opt('card_gateway', 'Stripe') == 'TransBank'): ?>
							<a class="dropdown-item" href="<?php echo e(route('subscribeWithWBPlus', [ 'user' => $profile->user->id ])); ?>">
								<?php echo app('translator')->get('general.creditCard'); ?>
							</a>
						<?php endif; ?>

						
						<?php if(opt('paypalEnable', 'No') == 'Yes'): ?>
							<a class="dropdown-item" href="<?php echo e(route('subscribeViaPaypal', [ 'user' => $profile->user->id ])); ?>">
								<?php echo app('translator')->get('general.PayPal'); ?>
							</a>
						<?php endif; ?>
					</div>
					</div>
				<?php endif; ?>
			<?php endif; ?> 

			<?php
if (! isset($_instance)) {
    $dom = \Livewire\Livewire::mount('followbutton', [ 'profileId' => $profile->id ])->dom;
} elseif ($_instance->childHasBeenRendered('yEqONMb')) {
    $componentId = $_instance->getRenderedChildComponentId('yEqONMb');
    $componentTag = $_instance->getRenderedChildComponentTagName('yEqONMb');
    $dom = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('yEqONMb');
} else {
    $response = \Livewire\Livewire::mount('followbutton', [ 'profileId' => $profile->id ]);
    $dom = $response->dom;
    $_instance->logRenderedChild('yEqONMb', $response->id, \Livewire\Livewire::getRootElementTagName($dom));
}
echo $dom;
?>
			
		</div>
		<div class="col-12 col-sm-1">
			<?php if($profile->user_id != auth()->user()->id): ?>
				<div class="three-dot-dropdown">
					<!-- three dots -->
					<ul class="dropbtn icons btn-right showLeft" id="profileExtraDropdownBtn">
						<li></li>
						<li></li>
						<li></li>
					</ul>
					<!-- menu -->
					<div id="profileExtraDropdown" class="three-dot-dropdown-content">
						<a href="javascript:reportBlockUser('Block', <?php echo e($profile->user_id); ?>, '<?php echo e($profile->name); ?>')" id="block_user_btn">Block User</a>
						<a href="javascript:reportBlockUser('Report', <?php echo e($profile->user_id); ?>, '<?php echo e($profile->name); ?>')" id="report_user_btn">Report User</a>
						<a href="javascript:reportBlockUser('Block & Report', <?php echo e($profile->user_id); ?>, '<?php echo e($profile->name); ?>')" id="block_and_report_user_btn">Block & Report User</a>
					</div>
				</div>
			<?php endif; ?>
		</div>
	</div>
	<br>
</div>
</div>
</div>
</div>
<br>
<div class="container add-padding">
<div class="row">

<div class="col-12 d-block d-sm-block d-md-none mb-4">
<?php echo $__env->make( 'profile.sidebar' , \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</div>

<div class="col-12 col-md-8">

	<?php if( auth()->check() AND auth()->user()->profile->id == $profile->id ): ?>
		<?php echo $__env->make('posts.create-post', [ 'user' => auth()->user() ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
	<?php endif; ?>

	<div class="postsList">
		<?php echo $__env->make( 'posts.feed', [ 'profile' => $profile ] , \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
	</div>

	<div class="text-center loadingPostsMsg d-none">
	  <h3 class="text-secondary"><i class="fas fa-spinner fa-spin mr-2"></i> <?php echo app('translator')->get( 'post.isLoading' ); ?></h3>
	</div>

	<div class="text-center noMorePostsMsg d-none mb-5" >
		<div class="card shadow p-3" style="padding: 10px;
            border: 2px solid #FFFFFF;
            border-radius: 11px;">
			<h3 class="text-secondary"><?php echo app('translator')->get( 'post.noMorePosts' ); ?></h3>
		</div>
	</div>

</div><!-- col-sm-8 col-12 -->

<div class="col-12 col-md-4 d-none d-sm-none d-md-block d-lg-block">
	<div class="sticky-top">

	<?php if( $feed->count() ): ?>
		<div class="lastId d-none"><?php echo e($feed->last()->id); ?></div>
	<?php endif; ?>

	<?php echo $__env->make( 'profile.sidebar' , \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
	</div>
	<br>
</div>

</div>	<!-- . posts -->

</div>
</div>

<br><br><br>
</div><!-- ./white-smoke bg-->
<!-- Modal -->
<div class="modal fade" id="uploadProfileImageModel" tabindex="-1" role="dialog" aria-labelledby="uploadProfileImageLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Upload Your Profile Picture</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<iframe src="<?php echo e(config('app.url')); ?>/profile/updateProfilePic" width="100%%" height="600" frameborder="0"></iframe>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>
<?php $__env->stopSection(); ?>

<?php if($profile->coverPic && !empty( $profile->coverPic )): ?>
<?php $__env->startPush( 'extraCSS' ); ?>
<link rel="Stylesheet" type="text/css" href="<?php echo e(config('app.url')); ?>/js/croppie/croppie.css" />
<style>
.coverPic {
	background-image: url('<?php echo e(asset('public/uploads/' . $profile->coverPicture)); ?>');
}
.viewCoverPic{width:100%;height:100%;display:block;}
</style>
<?php $__env->stopPush(); ?>
<?php endif; ?>
<?php if($profile->user_id == auth()->user()->id): ?>
<?php $__env->startPush( 'extraCSS' ); ?>
<link rel="Stylesheet" type="text/css" href="<?php echo e(config('app.url')); ?>/js/croppie/croppie.css" />
<style>
.uploadBtn input[type="file"] {
	cursor: pointer;
}
button:focus {
	outline: 0;
}

.uploadBtn {
	position: relative;
}
 .uploadBtn input[type="file"] {
	position: absolute;
	top: 0;
	left: 0;
	width: 100%;
	height: 100%;
	opacity: 0;
	cursor: pointer;
}
.coverPic .coverPic-wrap,
.coverPic .saveCoverPic,
.coverPic.ready .coverPic-msg {
	display: none;
}
.coverPic.ready .coverPic-wrap {
	display: block;
}
.coverPic.ready .saveCoverPic {
	display: inline-block;
}
.coverPic-wrap {
	width: 1200px;
	height: 480px;
	margin: 0 auto;
}
.coverPic.ready{
	display: block;
}
.coverPic.ready .saveButton {
	display: inline-block;
}
#coverPic {
	position: absolute;
	width: 1110px;
	height: 320px;
	border-radius: 0 0 12px 12px;
	z-index: 9;
}
.croppie-container .cr-slider-wrap{
	width:auto;
	margin: 0;
	border-radius: 5px;
	z-index: 99;
	position: absolute;
	left: 10px;
	bottom: 10px;
	background: rgba(58, 59, 60, 0.6);
	padding: 10px 10px 5px;
}
</style>
<?php $__env->stopPush(); ?>
<?php endif; ?>

<?php $__env->startPush( 'extraJS' ); ?>
<script>
	$( function() {

		<?php if( auth()->check() AND auth()->user()->profile->id == $profile->id ): ?>
		// auto expand textarea
		// document.getElementById('creatEditablePost').addEventListener('keyup', function() {
		//     this.style.overflow = 'hidden';
		//     this.style.height = 0;
		//     this.style.height = this.scrollHeight + 'px';
		// }, false);
		<?php endif; ?>
		
		$(document.body).on('touchmove', onScroll); // for mobile
		$(window).on('scroll', onScroll);

		function onScroll() {

			if($(window).scrollTop() + $(window).height() >= $(document).height()) {

				// show spinner
				$( '.loadingPostsMsg' ).removeClass( 'd-none' );

				var lastId = $( '.lastId' ).html();

				$.getJSON( '<?php echo e(route( 'loadPostsForProfile', [ 'profile' => $profile->id, 'lastId' => '/' ])); ?>/' + lastId, function( resp ) {

					if( resp.lastId != 0 ) {

						// append html
						$( '.postsList' ).append( resp.view );
						$('.lastId').html(resp.lastId);

					}else{

						// cancel scroll event
						$(window).off('scroll');

						$( '.noMorePostsMsg' ).removeClass( 'd-none' );
					}

					$( '.loadingPostsMsg' ).addClass( 'd-none' );

					window.livewire.rescan();

				});
			}
		}		

	});
</script>
<?php if($profile->user_id == auth()->user()->id): ?>
<script src="<?php echo e(config('app.url')); ?>/js/croppie/croppie.js"></script>
<script src="https://foliotek.github.io/Croppie/bower_components/exif-js/exif.js"></script>
<script>
	
	//added by yaro
	$("div.profilePic img").on("error", function () {
    	$(this).attr("src", "<?php echo e(config('app.url')); ?>/public/uploads/profilePics/default-profile-pic.png");
	});
	$("div.profilePicSmall img").on("error", function () {
    	$(this).attr("src", "<?php echo e(config('app.url')); ?>/public/uploads/profilePics/default-profile-pic.png");
	});
	//=====================
	function popupResult(result) {
		var html;
		if (result.html) {
			html = result.html;
		}
		if (result.src) {
			html = '<img src="' + result.src + '" />';
		}
		swal({
			title: '',
			html: true,
			text: html,
			allowOutsideClick: true
		});
		setTimeout(function(){
			$('.sweet-alert').css('margin', function() {
				var top = -1 * ($(this).height() / 2),
						left = -1 * ($(this).width() / 2);

				return top + 'px 0 0 ' + left + 'px';
			});
		}, 1);
	}
	var $uploadCrop;

	function readFile(input) {
		if (input.files && input.files[0]) {
			var reader = new FileReader();

			reader.onload = function (e) {
				$('.coverPic').addClass('ready');
				$uploadCrop.croppie('bind', {
					url: e.target.result
				}).then(function(){
					console.log('jQuery bind complete');
				});

			}

			reader.readAsDataURL(input.files[0]);
		}
		else {
			swal("Sorry - you're browser doesn't support the FileReader API");
		}
	}

	$uploadCrop = $('#coverPic').croppie({
		viewport: {
			width: 1110,
			height: 320
		},
		enableExif: true
	});

	$('#uploadCoverPic').on('change', function () { readFile(this); });
	$('.saveCoverPic').on('click', function (ev) {
		$uploadCrop.croppie('result', {
			type: 'canvas',
			size: 'viewport'
		}).then(function (resp) {
			/*popupResult({
				src: resp
			});*/
			$.ajax({
				url:'<?php echo e(config('app.url')); ?>/profile/coverImageUpdate',
				type:'POST',
				data:{"coverPic":resp, "img_type":"cover_image", "_token": "<?php echo e(csrf_token()); ?>"},
				success:function(data){
					$('#coverPic,.saveCoverPic').fadeOut();
					$('.coverPic').css('background-image', 'url("' + data.updated_pic + '")');
				}
			});
		});
	});
	window.closeModal = function(data){
		console.log(data);
		$('#uploadProfileImageModel').modal('hide');
		$('img.profilePicUpdate').attr('src',data);
	};
</script>
<?php endif; ?>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('welcome', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/ay8h3a64vt1a/public_html/resources/views/profile/user-profile.blade.php ENDPATH**/ ?>