<form id="createPostFrm" name="createPostFrm" method="POST" enctype="multipart/form-data" action="{{ route('savePost') }}">
@csrf

@if(isset($display))
<div class="card mb-4 p-4 p-md-0 mdits" style="display:none">
@else
<div class="card mb-4 p-4 mdits" >
@endif
<div class="row ">
	<style>
		.emojionearea, .emojionearea.form-control{height:75px !important;}
		.mdits{
            padding: 10px;
            border: 2px solid #FFFFFF;
            border-radius: 15px;
		}
	</style>
	
	<div class="col-12 col-sm-12 " id="belowCreatePost">
		<div style="height:75px;">
		<div id="creatEditablePost" class="inputor" contentEditable="true" data-placeholder="Post something....."></div>
		<!-- <textarea name="text_content" id="createPost" rows="1" class="form-control" placeholder="@lang('post.writeSomething')" required="required" style="height:114px;display:none;"></textarea> -->
		</div>
		<br>
		<input type="hidden" class="postType" name="lock_type" value="Free">
		<input type="hidden" class="textContent" name="text_content" value="">
			<div class="row">
				<div class="col-12 col-sm-12 col-md-8">
					<a href="javascript:void(0);" class="mr-2 noHover text-danger imageUploadLink" data-toggle="tooltip" title="@lang('post.imageUpload')">
						<h5 class="d-inline"><i class="fas fa-image"></i></h5>
					</a>

					<a href="javascript:void(0);" class="mr-2 noHover text-info videoUploadLink" data-toggle="tooltip" title="@lang('post.videoUpload')">
						<h5 class="d-inline"><i class="fas fa-video"></i></h5>
					</a>

					<a href="javascript:void(0);" class="mr-2 noHover text-warning audioUploadLink" data-toggle="tooltip" title="@lang('post.audioUpload')">
						<h5 class="d-inline"><i class="fas fa-music"></i></h5>
					</a>

					<!--a href="javascript:void(0);" class="ml-1 mr-2 noHover text-dark zipUploadLink" data-toggle="tooltip" title="@lang('v16.zipUpload')">
						<h5 class="d-inline"><i class="fas fa-file-archive"></i></h5>
					</a-->
					@if(auth()->user()->canTakePayments())
					<a href="javascript:void(0);" class="togglePostType noHover d-none" data-switch-to="free" data-toggle="tooltip" title="@lang('post.paidPost')">
						<h5 class="d-inline"><i class="fas fa-lock text-warning"></i></h5>
					</a>
					<a href="javascript:void(0);" class="togglePostType noHover" data-switch-to="paid" data-toggle="tooltip" title="@lang('post.freePost')">
						<h5 class="d-inline"><i class="fas fa-lock-open text-success"></i></h5>
					</a>
					@else
					<a href="javascript:void(0);" class="noHover" data-switch-to="paid" data-toggle="tooltip" onclick='swal({text: "{{ auth()->user()->webAlertMessage(2) }}", icon: "info", timer: 2000, buttons: false})' title="@lang('post.freePost')">
						<h5 class="d-inline"><i class="fas fa-lock-open text-success"></i></h5>
					</a>
					@endif
					<input type="file" name="imageUpload[]" class="multipleImgUpload with-preview d-none" multiple="multiple" accept="image/*" data-maxfile="1073741824" data-maxsize="1073741824">
					<input type="file" name="videoUpload" accept="video/mp4,video/webm,video/ogg,video/quicktime" class=" videoFileUpload d-none" >
					<input type="file" name="audioUpload" accept="audio/mp3,audio/ogg,audio/wav" class=" audioFileUpload d-none" >
					<input type="file" name="zipUpload" accept="zip,application/zip,application/x-zip,application/x-zip-compressed,.zip" class=" zipFileUpload d-none" >
				</div>
			
				<div class="col-12 col-sm-12 col-md-4 text-right">
				<button type="submit" class="btn btnCreatePost btn-primary mr-0 mb-2">
					<i class="far fa-paper-plane mr-1"></i> @lang('post.savePost')
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
@push('extraJS')
<script src="{{ asset('js/jquery.MultiFile.min.js') }}"></script>
<script>
	
	$(function() {

		$(".zipUploadLink").click(function () {
			$("input[name=zipUpload]").trigger('click');
		});


		$('.multipleImgUpload').MultiFile({
			accept:'gif|jpg|png|jpeg', 
			separator:false, 
			STRING: { 
				remove:'X', 
				selected:'$file', 
				denied:'Not allowed $ext!', 
				duplicate:'Already selected:\n$file!'
			}
		});

		$.getJSON( '{{ route( 'getUsers') }}', function( resp ) {
			if( resp.users ) {
				var names = [];

				for(let i = 0; i < resp.users.length; i++){
					names.push({'id':resp.users[i].id,'name':resp.users[i].name,'url':resp.users[i].profile_url,'pic_url':resp.users[i].profile_pic_url});
				}

				var at_config = {
					at: "@",
					data: names,
					headerTpl: '<div class="atwho-header">People List<small>↑&nbsp;↓&nbsp;</small></div>',
					insertTpl: '<a href="${url}">${name}</a>',
					displayTpl: '<li><img src="${pic_url}" class="tag-profile-img">${name}</li>',
					limit: 200
				}
				$('#creatEditablePost').atwho(at_config);
				
			}else{
				console.log('error');
			}

			$('.btnCreatePost').click(function() {
				$('.textContent').val($('.inputor').html());
			});
		});
	});

</script>
@endpush

@push('extraCSS')
<style>
	.MultiFile-preview {
		border-radius: 6px;
		display: block;
	}
	.MultiFile-remove, .MultiFile-title {
		display: none;
	}
</style>
@endpush