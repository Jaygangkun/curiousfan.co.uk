
@if( $feed->count() )

	@foreach( $feed as $post )
		@component( 'posts.single', [ 'post' => $post ] ) @endcomponent
	@endforeach

@else
	<div class="card shadow p-4 mb-4 text-center" style="padding: 10px;
            border: 2px solid #FFFFFF;
            border-radius: 11px;">
		<h3 class="text-secondary">
			<i class="fas fa-comment-slash"></i> @lang( 'post.noPosts', [ 'handle' => $profile->handle ] )
		</h3>
	</div>
@endif