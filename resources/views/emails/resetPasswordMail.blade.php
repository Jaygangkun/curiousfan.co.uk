@component('mail::message')
@if($emailBody)
    {!! $emailBody !!}
@else
<p>You are receiving this email because we received a password reset request for your account.</p>
<p><a href="{{ $resetURL }}">Reset Password</a></p>
<p>If you did not request a password reset, no further action is required.</p>
@endif
@endcomponent