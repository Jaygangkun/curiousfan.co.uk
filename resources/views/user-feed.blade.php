@extends( 'welcome' )

@section('seo_title') @lang('navigation.feed') - @endsection

@section( 'content' )
<div class="white-smoke-bg pt-4 pb-3">
<div class="container add-padding" >
	<div class="row">
		<div class="col-12">
			<div class="alert alert-success alert-dismissible" id="sendBecomeCreatorRequestSuccess" style="display:none">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
				<p><strong>Request Sent.</strong></p>
				<p>You will receive a email when your account have been upgraded. </p>
			</div>
		</div>
	</div>
<div class="row">

@include('posts.sidebar-mobile', [ 'user' => auth()->user(), 'profile' => auth()->user()->profile ])

<div class="col-12 col-lg-6">

@if( auth()->check() )
	@include('posts.create-post', [ 'user' => auth()->user(), 'profile' => auth()->user()->profile,'display'=>'none' ])
@endif

@if( $feed->count() )
	
<div class="postsList">
	@foreach( $feed as $post )
		@component( 'posts.single', [ 'post' => $post ] ) @endcomponent
	@endforeach
</div>

<div class="text-center loadingPostsMsg d-none">
  <h3 class="text-secondary"><i class="fas fa-spinner fa-spin mr-2"></i> @lang( 'post.isLoading' )</h3>
</div>

<div class="text-center noMorePostsMsg d-none">
	<div class="card shadow p-3">
		<h3 class="text-secondary">@lang( 'post.noMorePosts' )</h3>
	</div>
</div>
@endif
<div id="noPostMsg" class="card mb-4 p-2 p-md-5" 
	@if( $feed->count() != 0) 
		style="display: none" 
	@endif
>
	<div class="row">
		<div class="col text-center">
			<p class="p-3 p-md-0">
				@lang( 'post.findCreator' )
			</p>
			<a class="btn btn-primary find-creator-btn" href="{{ route('browseCreators') }}">@lang('post.findCreatorButton')</a>
		</div>
	</div>
	<img class="p-md-4 mt-3 mt-md-0" src="{{ asset('images/no-feed-background.jpg') }}" alt="Snow">
</div>
</div>

@include('posts.sidebar-desktop')

</div><!-- paddin top 5-->
</div><!-- ./container -->
</div><!-- .swhite-smoke -->
@endsection

{{-- attention, this is dynamically appended using stack() and push() functions of BLADE --}}
@push( 'extraJS' )
<script>
    $('div.mdits').css("display","none");
	$( function() {
        
        
		@if( auth()->check() )
		// auto expand textarea
		// document.getElementById('creatEditablePost').addEventListener('keyup', function() {
		//     this.style.overflow = 'hidden';
		//     this.style.height = 0;
		//     this.style.height = this.scrollHeight + 'px';
		// }, false);
		@endif
		
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

				$.getJSON( '{{ route( 'loadMorePosts', [ 'lastId' => '/' ]) }}/' + lastId, function( resp ) {

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
		
		$(document).on('click', '#sendBecomeCreatorRequestBtn', function() {
			$.ajax({
				url: '{{ route("sendBecomeCreatorRequest")}}',
				type: 'POST',
				headers: {
					'X-CSRF-TOKEN': '{{ csrf_token() }}'
				},
				data: {

				},
				dataType: 'json',
				success: function(resp) {
					if(resp.success) {
						$("#sendBecomeCreatorRequestSuccess").fadeTo(2000, 500).slideUp(500, function(){
							$("#sendBecomeCreatorRequestSuccess").slideUp(500);
						});
					}
				}
			})
		})
	});
</script>
@endpush