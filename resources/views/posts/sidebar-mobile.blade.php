<div class="col-12 col-md-3 mb-4  d-none d-sm-none d-md-none d-lg-block">
	{{-- @livewire('creators-sidebar') --}}
	<div class="sticky-top">
		<div class="card left-sidebar">
			<a class="mycount-icon" href="{{  route('accountSettings') }}" data-toggle="tooltip" title="@lang('navigation.account')">
				<i class="fas fa-cog fa-2x"></i>
			</a>
			<center>
				<div class="profilePicSmall mt-3 ml-0">
					<img src="{{ secure_image(auth()->user()->profile->profilePic, 75, 75) }}" alt="" class="img-fluid">
				</div>
			</center>
			<div class="text-center text-secondary">
				<h4 style="mt-1">
					{{auth()->user()->profile->name}}
				</h4>
				@if(auth()->user())
				<small>{{ '(' . opt('payment-settings.currency_symbol') . number_format(auth()->user()->balance,2) . ')' }}</small>
				@endif
			</div>
			<div class="border-top pt-3 pb-3">
				<div class="text-center">
					
					@if (auth()->user()->isCreating == "Yes") 
						<B>@lang('post.creator')</B>
					@else
						<B>@lang('post.supporter')</B>
					@endif
				</div>
			</div>
			<div class="border-top pt-3 pb-3">
				<div class="text-center">
					<button id = "newPostBtn" class="btn  btn-primary mr-0 mb-2" style="padding: 5px 20px 5px 20px; font-size: 16px; border-radius: 16px;">
						<i class="fas fa-plus mr-1"></i> @lang('post.newPost')
					</button>
				</div>
			</div>
		</div>
	</div>
</div>