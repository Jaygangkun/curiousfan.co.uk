@extends('welcome')

@section('title', $profile->name)
@section('description', $profile->creating)
@section('image', config('app.url') . '/public/uploads/' . $profile->profilePic)

@section('content')
<div class="white-smoke-bg white-smoke-bg-profile-page">
<div class="white-bg shadow-sm p-0">
<div class="container add-padding">
	<div class="row">
		<div class="col-md-12">
			<div class="coverPic" style="border-radius: 0 0 12px 12px;">
				@if($profile->user_id == auth()->user()->id)
				<div class="coverPic-wrap">
					<div id="coverPic"></div>
				</div>
				<div class="text-center uploadBtn btn" style="padding:6px 6px 6px 16px; position: absolute; right: 10px; bottom: 10px;background-color: #FFF;color:#000;z-index: 99;">
					<span><i class="far fa-edit mr-1"></i></span>
					<input type="file" id="uploadCoverPic" value="Choose a file" accept="image/*" />
				</div>
				<button class="text-center saveCoverPic btn btn-success" style="position: absolute; right: 70px; bottom: 10px;z-index: 99;">Save Cover Picture</button>
				@else
					<a class="coverPic" data-fancybox href="{{ asset('public/uploads/' . $profile->coverPicture) }}"></a>
				@endif
			</div>
		</div>
	</div>
<div class="row">
<div class="col-12 col-sm-4 col-md-3 col-lg-2 mb-1 mb-sm-0">
	<div class="customdv " style="position: relative">
		
		@if($profile->user->isOnline()) 
			<div class = "profilePicOnline " data-toggle="tooltip" title="I'm online!">
		    </div>
	
		@endif 
			@if($profile->user_id == auth()->user()->id)
				<div class="profileCameraIcon">
					<a href="#" data-toggle="modal" data-target="#uploadProfileImageModel">
						<img style="border-color:#3a3b3c" src="{{ config('app.url') }}/images/photo-camera.png">
					</a>
				</div>
			@endif
			<div class="profilePic shadow">
				<a data-fancybox href="{{ config('app.url') }}/public/uploads/{{ $profile->profilePic }}">
					<img src="{{ config('app.url') }}/public/uploads/{{ $profile->profilePic }}" alt="profile pic" class="img-fluid profilePicUpdate">
					<!--img src="{{ config('app.url') }}/public/uploads/profilePics/default-profile-pic.png" alt="profile pic" class="img-fluid profilePicUpdate"-->
				</a>

				
			</div>
		
	</div>

</div>

<div class="col-12 col-sm-8 col-md-9 col-lg-10 text-center text-sm-left">
	<div class="row">
		<div class="col-12 col-sm-6">
			<h4 class="profile-name">
				<a href="{{ $profile->url }}">
					{{ $profile->name }}
				</a>
				@if($profile->user_id == auth()->user()->id)
					<a class="" style="border-radius:16px; margin-left: 10px" href="/my-profile" role="button"><i style="font-size: 18px" class="far fa-edit"></i></a>
				@endif
			</h4>
			<a href="{{ $profile->url }}">
				{{ $profile->handle }} @if($profile->isVerified == 'Yes') <i class="fas fa-check-circle text-primary"></i> @endif  
			</a>
			<br><br>
			@php
              	$customD = json_decode($profile->custom_data);
			@endphp
			<div>
				<i class="far fa-grin-stars mr-1"></i> @if(@$customD->fans && $customD->fans > @$profile->fans_count){{ @$customD->fans + $profile->fans_count }} @else {{ $profile->fans_count }} @endif @lang('general.paid-fans')&nbsp;&nbsp;
				<i class="fas fa-users"></i> @if(@$customD->subscribers && @$customD->subscribers > $profile->followers->count()){{ @$customD->subscribers + $profile->followers->count()  }} @else {{ @$profile->followers->count() }} @endif @lang('general.free-subscribers')&nbsp;&nbsp;
			</div>
			<div>
				<i class="fas fa-align-left" data-toggle="tooltip" title="Total Posts"></i> {{ $profile->posts->count() }} &nbsp;&nbsp;
				<i class="fas fa-image" data-toggle="tooltip" title="Images"></i> {{ $profile->posts->where('media_type', 'Image')->count() }} &nbsp;
				<i class="fas fa-music" data-toggle="tooltip" title="Audios"></i> {{ $profile->posts->where('media_type', 'Audio')->count() }} &nbsp;
				<i class="fas fa-video" data-toggle="tooltip" title="Videos"></i> {{ $profile->posts->where('media_type', 'Video')->count() }} 
			</div>
		</div>

		<div class="col-12 col-sm-5">

			<h4 class="profile-name">
				@lang( 'profile.follow' )
			</h4>

			@if($profile->monthlyFee)

				@if(auth()->check() && auth()->user()->hasSubscriptionTo($profile->user))
					<a href="{{  route('mySubscriptions') }}" style="border-radius:16px; padding:6px 15px;" class="btn btn-danger btn-sm mb-2"><i class="fas fa-eye"></i> @lang('general.viewSubscription')</a>
				@else
					<div class="dropdown show ">
					<a href="javascript:void(0)" class="btn btn-danger btn-sm mb-2 dropdown-toggle" style="border-radius:16px; padding:6px 15px;" id="premiumPostsLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<i class="fa fa-unlock mr-1"></i> @lang( 'profile.unlock' ) - {{ opt('payment-settings.currency_symbol') . number_format($profile->monthlyFee,2) }}
					</a>
					<div class="dropdown-menu" aria-labelledBy="premiumPostsLink">

						{{-- Stripe Button --}}
						@if(opt('card_gateway', 'Stripe') == 'Stripe')
							@if(auth()->check() && opt('stripeEnable', 'No') == 'Yes' && auth()->user()->paymentMethods()->count())
								<a class="dropdown-item" href="{{ route('subscribeCreditCard', [ 'user' => $profile->user->id ]) }}">
									@lang('general.creditCard')
								</a>
							@elseif(auth()->check() && !auth()->user()->paymentMethods()->count() && opt('stripeEnable', 'No') == 'Yes')
								<a class="dropdown-item" href="{{ route('billing.cards') }}">
									@lang('general.addNewCard')
								</a>
							@elseif(opt('stripeEnable', 'No') == 'Yes')
								<a class="dropdown-item" href="{{ route('login') }}">
									@lang('general.creditCard')
								</a>
							@endif
						@endif

						{{-- CCBill Button --}}
						@if(opt('card_gateway', 'Stripe') == 'CCBill')
							<a class="dropdown-item" href="{{ route('subscribeCCBill', [ 'user' => $profile->user->id ]) }}">
								@lang('general.creditCard')
							</a>
						@endif

						{{-- PayStack Button --}}
						@if(opt('card_gateway', 'Stripe') == 'PayStack')
							@if(auth()->check() && auth()->user()->paymentMethods()->count())
								<a class="dropdown-item" href="{{ route('subscribePayStack', [ 'user' => $profile->user->id ]) }}">
									@lang('general.creditCard')
								</a>
							@elseif(auth()->check() && !auth()->user()->paymentMethods()->count())
								<a class="dropdown-item" href="{{ route('billing.cards') }}">
									@lang('general.addNewCard')
								</a>
							@else
								<a class="dropdown-item" href="{{ route('login') }}">
									@lang('general.creditCard')
								</a>
							@endif
						@endif

						{{-- MercadoPago Button --}}
						@if(opt('card_gateway', 'Stripe') == 'MercadoPago')
							@if(auth()->check())
								<a class="dropdown-item" href="{{ route('subscribeMercadoPago', [ 'user' => $profile->user->id ]) }}">
									@lang('general.creditCard')
								</a>
							@else
								<a class="dropdown-item" href="{{ route('login') }}">
									@lang('general.creditCard')
								</a>
							@endif
						@endif

						{{-- TransBank WebpayPlus Button --}}
						@if(opt('card_gateway', 'Stripe') == 'TransBank')
							<a class="dropdown-item" href="{{ route('subscribeWithWBPlus', [ 'user' => $profile->user->id ]) }}">
								@lang('general.creditCard')
							</a>
						@endif

						{{-- PayPal Button --}}
						@if(opt('paypalEnable', 'No') == 'Yes')
							<a class="dropdown-item" href="{{ route('subscribeViaPaypal', [ 'user' => $profile->user->id ]) }}">
								@lang('general.PayPal')
							</a>
						@endif
					</div>
					</div>
				@endif{{--  if not already subscribed --}}
			@endif {{-- if monthly fee --}}

			@livewire( 'followbutton', [ 'profileId' => $profile->id ] )
			
		</div>
		<div class="col-12 col-sm-1">
			@if($profile->user_id != auth()->user()->id)
				<div class="dropdown profile-action-dropdown">
					<button class="dropbtn dropdown-toggle" type="button" id="profile_action_dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<i class="fas fa-ellipsis-v"></i>
					</button>
					<div class="dropdown-menu" aria-labelledby="profile_action_dropdown">
						<a class="dropdown-item" href="javascript:reportBlockUser('Block', {{ $profile->user_id }}, '{{ $profile->name }}')" id="block_user_btn">Block User</a>
						<a class="dropdown-item" href="javascript:reportBlockUser('Report', {{ $profile->user_id }}, '{{ $profile->name }}')" id="report_user_btn">Report User</a>
						<a class="dropdown-item" href="javascript:reportBlockUser('Block & Report', {{ $profile->user_id }}, '{{ $profile->name }}')" id="block_and_report_user_btn">Block & Report User</a>
					</div>
				</div>
			@endif
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
@include( 'profile.sidebar' )
</div>

<div class="col-12 col-md-8">

	@if( auth()->check() AND auth()->user()->profile->id == $profile->id )
		@include('posts.create-post', [ 'user' => auth()->user() ])
	@endif

	<div class="postsList">
		@include( 'posts.feed', [ 'profile' => $profile ] )
	</div>

	<div class="text-center loadingPostsMsg d-none">
	  <h3 class="text-secondary"><i class="fas fa-spinner fa-spin mr-2"></i> @lang( 'post.isLoading' )</h3>
	</div>

	<div class="text-center noMorePostsMsg d-none mb-5" >
		<div class="card shadow p-3" style="padding: 10px;
            border: 2px solid #FFFFFF;
            border-radius: 11px;">
			<h3 class="text-secondary">@lang( 'post.noMorePosts' )</h3>
		</div>
	</div>

</div><!-- col-sm-8 col-12 -->

<div class="col-12 col-md-4 d-none d-sm-none d-md-block d-lg-block">
	<div class="sticky-top">

	@if( $feed->count() )
		<div class="lastId d-none">{{ $feed->last()->id }}</div>
	@endif

	@include( 'profile.sidebar' )
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
				<iframe src="{{config('app.url')}}/profile/updateProfilePic" width="100%%" height="600" frameborder="0"></iframe>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>
@endsection

@if($profile->coverPic && !empty( $profile->coverPic ))
@push( 'extraCSS' )
<link rel="Stylesheet" type="text/css" href="{{ config('app.url') }}/js/croppie/croppie.css" />
<style>
.coverPic {
	background-image: url('{{ asset('public/uploads/' . $profile->coverPicture) }}');
}
.viewCoverPic{width:100%;height:100%;display:block;}
</style>
@endpush
@endif
@if($profile->user_id == auth()->user()->id)
@push( 'extraCSS' )
<link rel="Stylesheet" type="text/css" href="{{ config('app.url') }}/js/croppie/croppie.css" />
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
@endpush
@endif

@push( 'extraJS' )
<script>
	$( function() {

		@if( auth()->check() AND auth()->user()->profile->id == $profile->id )
		// auto expand textarea
		// document.getElementById('creatEditablePost').addEventListener('keyup', function() {
		//     this.style.overflow = 'hidden';
		//     this.style.height = 0;
		//     this.style.height = this.scrollHeight + 'px';
		// }, false);
		@endif
		
		$(document.body).on('touchmove', onScroll); // for mobile
		$(window).on('scroll', onScroll);

		function onScroll() {

			if($(window).scrollTop() + $(window).height() >= $(document).height()) {

				// show spinner
				$( '.loadingPostsMsg' ).removeClass( 'd-none' );

				var lastId = $( '.lastId' ).html();

				$.getJSON( '{{ route( 'loadPostsForProfile', [ 'profile' => $profile->id, 'lastId' => '/' ]) }}/' + lastId, function( resp ) {

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
@if($profile->user_id == auth()->user()->id)
<script src="{{ config('app.url') }}/js/croppie/croppie.js"></script>
<script src="https://foliotek.github.io/Croppie/bower_components/exif-js/exif.js"></script>
<script>
	
	//added by yaro
	$("div.profilePic img").on("error", function () {
    	$(this).attr("src", "{{ config('app.url') }}/public/uploads/profilePics/default-profile-pic.png");
	});
	$("div.profilePicSmall img").on("error", function () {
    	$(this).attr("src", "{{ config('app.url') }}/public/uploads/profilePics/default-profile-pic.png");
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
				url:'{{ config('app.url') }}/profile/coverImageUpdate',
				type:'POST',
				data:{"coverPic":resp, "img_type":"cover_image", "_token": "{{ csrf_token() }}"},
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
@endif
@endpush