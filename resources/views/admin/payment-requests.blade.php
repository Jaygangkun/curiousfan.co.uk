@extends('admin.base')

@section('section_title')
	<strong>Payment Requests (Payouts)</strong>
@endsection

@section('section_body')

<div class="alert alert-secondary">
    When you mark a payment request as paid, you have to actually pay the user first manually to their bank account or paypal. This does NOT happen automatically.
</div>

@if($reqs)
	<table class="table table-striped table-bordered table-responsive dataTable">
	<thead>
	<tr>
		<th>Email</th>
		<th>Name</th>
		<th>Profile</th>
        <th>Amount</th>
        <th>Payout Gateway</th>
		<th>Bank Name</th>
        <th>Account Name</th>
		<th>Sort Code</th>
		<th>Account Number</th>
		<th>Date</th>
		<th>Actions</th>
	</tr>
	</thead>
	<tbody>
		@foreach( $reqs as $v )
		<tr>
			<?php
			$bank_name = '';
			$account_name = '';
			$account_code = '';
			$account_number = '';
			
			$bank_details = explode('\n', $v->user->profile->payout_details);
			if(count($bank_details) == 4)
			{
				$bank_name = explode(':', $bank_details[0])[1];
				$account_name = explode(':', $bank_details[1])[1];
				$account_code = explode(':', $bank_details[2])[1];
				$account_number = explode(':', $bank_details[3])[1];
			}
			?>
			<td>
				{{ $v->user->email }}
			</td>
			<td>
				{{ $v->user->name }}<br>
			</td>
			<td>
                <a href="{{ route('profile.show', ['username' => $v->user->profile->username]) }}" target="_blank">
                    {{ $v->user->profile->handle }}
                </a>
			</td>
			<td>
				{{ opt('payment-settings.currency_symbol') . $v->amount }}
			</td>
			<td>
				{{ $v->user->profile->payout_gateway }}
            </td>
            <td>
				{!! $bank_name !!}
			</td>
			<td>
				{!! $account_name !!}
			</td>
			<td>
				{!! $account_code !!}
			</td>
			<td>
				{{ $account_number }}
			</td>
			<td>
                 {{ $v->created_at->format('jS F Y') }}<br>
                 {{ $v->created_at->format('H:ia') }}
            </td>
            <td>
                <a href="/admin/payment-requests/markAsPaid/{{ $v->id }}">
                    Mark as Paid
                </a>
            </td>
		</tr>
		@endforeach
	</tbody>
	</table>
@else
	No verification requests in database.
@endif

@endsection