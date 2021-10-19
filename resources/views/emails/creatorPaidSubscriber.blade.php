@component('mail::message')
@if($emailBody)
    {!! $emailBody !!}
@else
Hi <em><strong>{{ $notifiable->name }}</strong></em>,<br>

Congratulations, <br>

<strong>{{ $subscriber->name }}</strong> just subscribed to your premium content!<br>

Checkout <a href="{{ route('profile.show', ['username' => $subscriber->profile->username]) }}">
{{ $subscriber->profile->handle }}</a> profile

<br>

@component('mail::button', ['url' => route('mySubscribers'), 'color' => 'primary'])
View My Subscribers
@endcomponent

<br><br>

Regards,<br>
{{ env('APP_NAME') }}
@endif
@endcomponent