@extends('admin.base')

@section('section_title')
<strong>Users Management</strong>
<a href="/admin/add-user/">Add New User</a>
@endsection

@section('section_body')
	
	<table class="table dataTable">
    <thead>
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Email</th>
        <th>Subscribers</th>
		<th>Fans</th>
        <th>Type</th>
        <th>Is Admin</th>
        <th>IP Address</th>
        <th>Join Date</th>
        <th>Actions</th>
    </tr>
    </thead>
    <tbody>
    @foreach( $users as $u )
    <tr>
        <td>{{ $u->id }}</td>
        <td>{{ $u->name }}</td>
        <td>
            {{ $u->email }}
            <br>
            @if($u->email_verified_at)
                <span style="color:green;font-weight:bold;">Email Verified</span>
            @else
                <span style="color:red;font-weight:bold;">Email Unverified</span><br />
                <a href="/admin/verify/email/{{ $u->id }}">Verify Email Now</a>
            @endif
            <br><br>
            @if($u->profile->isVerified == 'Yes')
                <span style="color:green;font-weight:bold;">ID Verified</span> | <span><a target="_blank" href="{{ @\Storage::disk($u->profile->user_meta['verificationDisk'])->url($u->profile->user_meta['id']) }}">View ID</a></span>
            @else
                <span style="color:red;font-weight:bold;">ID Unverified</span><br />
                <a href="/admin/verifications/new/{{ $u->id }}">Verify ID Now</a>
            @endif
        </td>
        @php
            $customD = json_decode($u->profile->custom_data);
        @endphp
        <td>
            {{ $u->followers_count }} (Original)<br>
            @if(@$customD->subscribers){{ @$customD->subscribers }} (Added by admin) @endif
        </td>
        <td>
            {{ $u->subscribers_count }} (Original)<br>
            @if(@$customD->fans){{ @$customD->fans }} (Added by admin) @endif
		</td>
		<td>
			@if($u->isCreating == 'Yes')
				Creator
			@else
				User
			@endif
        </td>
        <td>
            {{ $u->isAdmin }}
            <br>
            @if($u->isAdmin == 'Yes') 
                <a href="/admin/users/unsetadmin/{{ $u->id }}">Unset Admin Role</a>
            @elseif($u->isAdmin == 'No')
                <a href="/admin/users/setadmin/{{ $u->id }}">Set Admin Role</a>
            @endif
        </td>
        <td>
            {{ $u->ip ? $u->ip : 'N/A' }}
            <br>
            @if($u->isBanned == 'No')
				<a href="/admin/users/ban/{{$u->id}}">Ban</a>
            @elseif($u->isBanned == 'Yes')
				<a href="/admin/users/unban/{{$u->id}}">Unban</a>
            @endif
			<br>
			@if($u->bannedIP == 'YES')
				<a href="/admin/users/unbanip/{{$u->id}}">Unban IP</a>
				
            @elseif($u->bannedIP != 'Yes')
				<a href="/admin/users/banip/{{$u->id}}">Ban IP</a>
            @endif
			
        </td>
		<td>{{ $u->created_at->format( 'jS F Y' ) }}</td>
        <td>
            <a href="/admin/view-user/{{ $u->id}}">Edit User</a><br>
            <a href="/admin/add-plan/{{ $u->id}}">Add Plan Manually</a><br>
            {{--@if($u->isCreating == 'No')
                @if($u->isMessage == 'No')
                <a href="/admin/message/enable/{{ $u->id}}">Enable Creators Account Message</a><br>
                @else
                <a href="/admin/message/disable/{{ $u->id}}">Disable Creators Account Message</a><br>
                @endif
            @endif--}}
            <a href="/admin/loginAs/{{ $u->id }}" onclick="return confirm('This will log you out as an admin and login as a vendor. Continue?')">Login as User</a>

            <br>
            <br>
            <a href="/admin/users?remove={{ $u->id }}" onclick="return confirm('Are you sure you want to delete this user and his data? This is irreversible!!!')" class="text-danger">Delete User & His Data</a>
        </td>
    </tr>
    @endforeach
    </tbody>
	</table>

@endsection

@section('extra_bottom')
	@if (count($errors) > 0)
	    <div class="alert alert-danger">
	        <ul>
	            @foreach ($errors->all() as $error)
	                <li>{{ $error }}</li>
	            @endforeach
	        </ul>
	    </div>
	@endif
@endsection