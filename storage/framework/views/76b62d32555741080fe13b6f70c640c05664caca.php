<form id="createPostFrm" name="createPostFrm" method="POST" enctype="multipart/form-data" action="<?php echo e(route('savePost')); ?>">
<?php echo csrf_field(); ?>

<div class="card mb-4 p-4">
<div class="row">

	<div class="col-sm-2 d-md-block d-none d-sm-none">
		<div class="profilePicSmall mt-0 ml-0 mr-2 mb-2 ml-md-3 profilePicOnlineSm shadow">
			<img src="<?php echo e(secure_image($profile->profilePic, 75, 75)); ?>" alt="" class="img-fluid">
		</div>
	</div>
	<div class="col-12 col-sm-10" id="belowCreatePost">
		<textarea name="text_content" id="createPost" rows="1" class="form-control" placeholder="<?php echo app('translator')->get('post.writeSomething'); ?>" required="required"></textarea>

		<br>
		  <input type="hidden" class="postType" name="lock_type" value="Paid">

		  <div class="row">
          	<div class="col-12 col-sm-12 col-md-8">
				<a href="javascript:void(0);" class="mr-2 noHover text-danger imageUploadLink" data-toggle="tooltip" title="<?php echo app('translator')->get('post.imageUpload'); ?>">
					<h5 class="d-inline"><i class="fas fa-image"></i></h5>
				</a>

				<a href="javascript:void(0);" class="mr-2 noHover text-info videoUploadLink" data-toggle="tooltip" title="<?php echo app('translator')->get('post.videoUpload'); ?>">
					<h5 class="d-inline"><i class="fas fa-video"></i></h5>
				</a>

				<a href="javascript:void(0);" class="mr-2 noHover text-secondary audioUploadLink" data-toggle="tooltip" title="<?php echo app('translator')->get('post.audioUpload'); ?>">
					<h5 class="d-inline"><i class="fas fa-music"></i></h5>
				</a>

				<a href="javascript:void(0);" class="ml-1 mr-2 noHover text-dark zipUploadLink" data-toggle="tooltip" title="<?php echo app('translator')->get('v16.zipUpload'); ?>">
					<h5 class="d-inline"><i class="fas fa-file-archive"></i></h5>
				</a>
				
				<a href="javascript:void(0);" class="togglePostType noHover d-none" data-switch-to="paid" data-toggle="tooltip" title="<?php echo app('translator')->get('post.freePost'); ?>">
					<h5 class="d-inline"><i class="fas fa-lock-open text-success"></i></h5>
				</a>

				<a href="javascript:void(0);" class="togglePostType noHover" data-switch-to="free" data-toggle="tooltip" title="<?php echo app('translator')->get('post.paidPost'); ?>">
					<h5 class="d-inline"><i class="fas fa-lock text-warning"></i></h5>
				</a>

				<input type="file" name="imageUpload[]" class="multipleImgUpload with-preview d-none" accept="image/*" data-maxfile="10240" maxlength="5" data-maxsize="5120">
				<input type="file" name="videoUpload" accept="video/mp4,video/webm,video/ogg,video/quicktime" class=" videoFileUpload d-none" >
				<input type="file" name="audioUpload" accept="audio/mp3,audio/ogg,audio/wav" class=" audioFileUpload d-none" >
				<input type="file" name="zipUpload" accept="zip,application/zip,application/x-zip,application/x-zip-compressed,.zip" class=" zipFileUpload d-none" >
			</div>
		
			<div class="col-12 col-sm-12 col-md-4 text-right">
			<button type="submit" class="btn btnCreatePost btn-primary mr-0 mb-2">
				<i class="far fa-paper-plane mr-1"></i> <?php echo app('translator')->get('post.savePost'); ?>
			</button>
			</div>
		</div>

	</div>

	<div class="uploadName col-12">
		<div class="fVideoName"></div>
		<div class="fAudioName"></div>
		<div class="fZipName"></div>
	</div>

</div><!-- .row -->

<div class="progress-wrapper mt-5 mb-3 d-none" id="progress">
<div class="progress-info">
  <div class="progress-percentage text-center">
    <span class="percent text-primary">0%</span>
  </div>
</div>
<div class="progress progress-xs">
  <div class="progress-bar progress-bar-striped" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
</div>
</div>

</div><!-- ./card -->
</form>

<?php $__env->startPush('extraJS'); ?>
<script src="<?php echo e(asset('js/jquery.MultiFile.min.js')); ?>"></script>
<script>
	
	$(function() {

		$(".zipUploadLink").click(function () {
			$("input[name=zipUpload]").trigger('click');
		});

		$(".imageUploadLink").click(function () {
			$(".multipleImgUpload").trigger('click');
		});

		$('.multipleImgUpload').MultiFile({
			accept:'gif|jpg|png|jpeg', 
			max:10, 
			STRING: { 
				remove:'X', 
				selected:'$file', 
				denied:'Not allowed $ext!', 
				duplicate:'Already selected:\n$file!'
			}
		});

	});

</script>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('extraCSS'); ?>
<style>
	.MultiFile-preview {
		border-radius: 6px;
		display: block;
	}
	.MultiFile-remove, .MultiFile-title {
		display: none;
	}
</style>
<?php $__env->stopPush(); ?><?php /**PATH /home/jr5az3t0ng0l/public_html/resources/views/posts/create-post.blade.php ENDPATH**/ ?>