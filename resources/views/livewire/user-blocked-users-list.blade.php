<div>

@if( $blockedUsers->count() )

	<div class="row">

	@foreach($blockedUsers as $b)

		<div class="col-6 col-sm-2 mb-3">
			<div class="profilePicSmall mt-0 ml-0 mr-2 mb-2 @if($b->user->isOnline()) profilePicOnlineSm @else profilePicOfflineSm @endif shadow">
			<a href="{{ $b->user->profile->url }}">
				<img src="{{ secure_image($b->user->profile->profilePic, 75, 75) }}" alt="" class="img-fluid">
			</a>
			</div>
		</div>
		<div class="col-6 col-sm-4 mb-3 profileFollowerList">
			{{ $b->user->profile->name }}<br>
			<br>
			<small>
                <a href="javascript:void(0);" wire:click="confirmCancellation({{$b->id}})" class='text-danger'>
                    @lang('general.unBlock')
                </a>
			</small>
		</div>

		@endforeach
	

	{{ $blockedUsers->links() }}

	</div>
	@else
		<h3 class="text-secondary text-center"><i class="far fa-surprise"></i> @lang( 'profile.noBlockedUsers' )</h3>
	@endif


</div>