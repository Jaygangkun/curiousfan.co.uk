@extends( 'account' )

@section('seo_title') @lang('dashboard.accountSettings') - @endsection

@section( 'account_section' )


<div>
<form method="POST" action="{{ route( 'saveAccountSettings' ) }}">
@csrf
<div class="shadow-sm card add-padding">

<br/>
<h2 class="ml-2"><i class="fa fa-cog mr-2"></i>@lang('dashboard.accountSettings')</h2>
@lang( 'profile.profileSettingsText' )
<hr>

<div class="row">
	<div class="col-sm-8 col-12">
		<label><strong>@lang('dashboard.yourName')</strong></label><br>
		<input type="text" name="name" class="form-control" value="{{ auth()->user()->name }}" required>
	</div>
</div>
<br>

<div class="row">
	<div class="col-sm-8 col-12">
		<label><strong>@lang('profile.email')</strong></label><br>
		<input type="email" name="email" class="form-control" value="{{ auth()->user()->email }}" required>
	</div>
</div>
<br>

<div class="row">
	<div class="col-sm-8 col-12">
		<label><strong>New Password</strong> <small>@lang('profile.leaveEmpty')</small></label><br>
		<input type="password" name="password" class="form-control">
	</div>
</div>
<br>

<div class="row">
	<div class="col-sm-8 col-12">
		<label><strong>Confirm New Password</strong> <small>@lang('profile.leaveEmpty')</small></label><br>
		<input type="password" name="password_confirmation" class="form-control">
	</div>
</div>
<br>
<br>

<label><strong>@lang( 'profile.bankDetails' ) <small>@lang('profile.ifBank')</small></strong></label>
<div class="row">
	<?php
	$bank_name = '';
	$account_name = '';
	$sort_code = '';
	$account_number = '';

	$bank_details = explode('\n', $p->payout_details);
	if(count($bank_details) == 4)
	{
		$bank_name = explode(':', $bank_details[0])[1];
		$account_name = explode(':', $bank_details[1])[1];
		$sort_code = explode(':', $bank_details[2])[1];
		$account_number = explode(':', $bank_details[3])[1];
	}
	?>
	<div class="col-sm-8 col-12">
		<label for="bank_name">Bank Name</label>
		<input type="text" class="form-control" name="bank_name" id="bank_name" value="{{ $bank_name }}" />
	</div>			
	<div class="col-sm-8 col-12">
		<label for="account_name">Account Name</label>				
		<input type="text" class="form-control" name="bank_account_name" id="account_name" value="{{ $account_name }}" />
	</div>			
	<div class="col-sm-8 col-12">
		<label for="sort_code">Sort Code</label>				
		<input type="text" class="form-control" name="bank_sort_code" id="sort_code" value="{{ $sort_code }}" />
	</div>
	<div class="col-sm-8 col-12">
		<label for="account_number">Account Number</label>				
		<input type="text" class="form-control" name="bank_account_number" id="account_number" value="{{ $account_number }}" />
	</div>
</div>

</div><!-- /.white-bg -->
<br>

<div class="text-center">
  <input type="submit" name="sbStoreProfile" class="btn btn-lg btn-primary" value="@lang('profile.saveAccountSettings')">
</div><!-- /.white-bg add-padding -->

</form>
<br/><br/>
</div><!-- /.white-smoke-bg -->
@endsection