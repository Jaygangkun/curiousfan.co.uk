@component('mail::message')
@if($emailBody)
    {!! $emailBody !!}
@else
<p>Hello There,</p>
<p>Please click the button below to verify your email address.</p>
<p><a href="{{ $verifyUrl }}">Verify Your Email</a></p>
<p>Regards,<br />{{ env('APP_NAME') }}</p>
<hr />
<p>If you&rsquo;re having trouble clicking the "Verify Now" button, copy and paste the URL below into your web browser:&nbsp;<a href="{{ $verifyUrl }}">{{ $verifyUrl }}</a></p>
@endif
@endcomponent