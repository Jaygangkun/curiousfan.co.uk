<div class="col-12 col-md-3 d-none d-sm-none d-md-none d-lg-block">
	<div class="sticky-top">
		<div class="right-sidebar">
			@if( isset($feed) && $feed->count() )
				<div class="lastId d-none">{{ $feed->last()->id }}</div>
			@endif

			@livewire('creators-sidebar')

			<div class="card mt-3">
				<div class="card-header">View Your Profile</div>
				<div class="card-body">
					<p>Make a great first impression of yourself.</p>
					<div class="text-center">
						<a href="/{{ auth()->user()->profile->username }}" class="btn btn-primary" style="padding: 5px 20px 5px 20px; font-size: 16px; border-radius: 16px;">View Profile</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>