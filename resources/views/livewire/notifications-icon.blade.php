<div>
    <a class="nav-link" href="{{ route('notifications.index') }}">
        <i class="fa fa-bell" aria-hidden="true"></i> @lang('navigation.myNotifications') 
        
		<small class="navNotificationCounters text-danger text-bold" data-count="{{auth()->user()->unreadNotifications()->count()}}">{{ auth()->user()->unreadNotifications()->count() }}</small>
    </a>
</div>
