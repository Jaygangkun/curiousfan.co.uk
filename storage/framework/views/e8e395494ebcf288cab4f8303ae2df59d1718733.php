<?php $__env->startSection('seo_title'); ?> <?php echo app('translator')->get('navigation.feed'); ?> - <?php $__env->stopSection(); ?>

<?php $__env->startSection( 'content' ); ?>
<div class="white-smoke-bg pt-4 pb-3">
<div class="container add-padding" >
<div class="row">

<?php echo $__env->make('posts.sidebar-mobile', [ 'user' => auth()->user(), 'profile' => auth()->user()->profile ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<div class="col-12 col-lg-6">

<?php if( auth()->check() ): ?>
	<?php echo $__env->make('posts.create-post', [ 'user' => auth()->user(), 'profile' => auth()->user()->profile,'display'=>'none' ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php endif; ?>

<?php if( $feed->count() ): ?>
	
<div class="postsList">
	<?php $__currentLoopData = $feed; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
		<?php $__env->startComponent( 'posts.single', [ 'post' => $post ] ); ?> <?php echo $__env->renderComponent(); ?>
	<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>

<div class="text-center loadingPostsMsg d-none">
  <h3 class="text-secondary"><i class="fas fa-spinner fa-spin mr-2"></i> <?php echo app('translator')->get( 'post.isLoading' ); ?></h3>
</div>

<div class="text-center noMorePostsMsg d-none">
	<div class="card shadow p-3">
		<h3 class="text-secondary"><?php echo app('translator')->get( 'post.noMorePosts' ); ?></h3>
	</div>
</div>
<?php endif; ?>
<div id="noPostMsg" class="card mb-4 p-2 p-md-5" 
	<?php if( $feed->count() != 0): ?> 
		style="display: none" 
	<?php endif; ?>
>
	<div class="row">
		<div class="col text-center">
			<p class="p-3 p-md-0">
				<?php echo app('translator')->get( 'post.findCreator' ); ?>
			</p>
			<a class="btn btn-primary find-creator-btn" href="<?php echo e(route('browseCreators')); ?>"><?php echo app('translator')->get('post.findCreatorButton'); ?></a>
		</div>
	</div>
	<img class="p-md-4 mt-3 mt-md-0" src="<?php echo e(asset('images/no-feed-background.jpg')); ?>" alt="Snow">
</div>
</div>

<?php echo $__env->make('posts.sidebar-desktop', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

</div><!-- paddin top 5-->
</div><!-- ./container -->
</div><!-- .swhite-smoke -->
<?php $__env->stopSection(); ?>


<?php $__env->startPush( 'extraJS' ); ?>
<script>
    $('div.mdits').css("display","none");
	$( function() {
        
        
		<?php if( auth()->check() ): ?>
		// auto expand textarea
		// document.getElementById('creatEditablePost').addEventListener('keyup', function() {
		//     this.style.overflow = 'hidden';
		//     this.style.height = 0;
		//     this.style.height = this.scrollHeight + 'px';
		// }, false);
		<?php endif; ?>
		
		$(document.body).on('touchmove', onScroll); // for mobile
		$(window).on('scroll', onScroll);
        
        	//ADDED BY YARO 10.7
		$("#newPostBtn").click(function () {
			$('div.mdits').css("display","block");
		});
		//====================
		
		$(".btnCreatePost").click(function () {
			$('#noPostMsg').css("display", "none");
		});

		function onScroll() {

			if($(window).scrollTop() + $(window).height() >= $(document).height()) {

				// show spinner
				$( '.loadingPostsMsg' ).removeClass( 'd-none' );

				var lastId = $( '.lastId' ).html();

				$.getJSON( '<?php echo e(route( 'loadMorePosts', [ 'lastId' => '/' ])); ?>/' + lastId, function( resp ) {

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
<?php $__env->stopPush(); ?>
<?php echo $__env->make( 'welcome' , \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/ay8h3a64vt1a/public_html/resources/views/user-feed.blade.php ENDPATH**/ ?>