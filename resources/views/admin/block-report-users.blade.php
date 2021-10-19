@extends('admin.base')

@section('section_title')
<strong>Block & Report Users Management</strong>
@endsection

@section('section_body')
	
	<table class="table dataTable">
    <thead>
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Email</th>
        <th>Request Type</th>
        <th>Content</th>
		<th>Requester Name</th>
        <th>Reqeuster Email</th>
        <th>Request Date</th>
        <th>Actions</th>
    </tr>
    </thead>
    <tbody>
    @foreach( $reportUsers as $u )
    <tr>
        <td>{{ $u->id }}</td>
        <td>{{ $u->user->name }}</td>
        <td>{{ $u->user->email }}</td>
        <td>{{ $u->report_type }}</td>
        <td>{{ $u->report_content }}</td>
        <td>{{ $u->reported_user->name }}</td>
        <td>{{ $u->reported_user->email }}</td>
        <td>{{ $u->created_at->format( 'jS F Y' ) }}</td>
        <td>
            <a href="/admin/block-report-users/delete/{{ $u->id }}" onclick="return confirm('Are you sure you want to delete this report?')" class="text-danger">Delete & Clear this report</a>
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