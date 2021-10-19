@component('mail::message')
@if($emailBody)
    {!! $emailBody !!}
@else
Hi {{ $withdraw->user->name }},<br><br>

Good news, your payment request of {{ opt('payment-settings.currency_symbol') .  $withdraw->amount }} was processed<br>

It may take up 17 business days to show up on your account depending on your payout method.
<br><br>

<strong>Payout Gateway</strong>:<br>
{{ $withdraw->user->profile->payout_gateway }}
<br>
<strong>Payout Details</strong>:<br>
{{-- please note, escaped using "e()" laravel function --}}
{!! nl2br(e(str_replace('\n', ' ', $withdraw->user->profile->payout_details))) !!}

<br><br>

Regards,<br>
{{ env('APP_NAME') }}
@endif
@endcomponent