@extends('admin.base')

@section('section_title')
<strong>Become Creator Requests Management</strong>
@endsection

@section('section_body')
	
	<table class="table dataTable">
    <thead>
    <tr>
        <th>Name</th>
        <th>Email</th>
        <th>Approved</th>
        <th>Request Date</th>
        <th>Actions</th>
    </tr>
    </thead>
    <tbody>
    @foreach( $becomeCreatorRequests as $r )
    <tr>
        <td>{{ $r->user->name }}</td>
        <td>{{ $r->user->email }}</td>
        <td class="td-approved">{{ $r->approved }}</td>
        <td>{{ $r->created_at->format( 'jS F Y' ) }}</td>
        <td>
            @if( $r->approved == 'Yes' )
                <a href="javascript:void(0)" data-user-id="{{$r->user->id}}" data-request-id="{{$r->id}}" class="text-danger become-creator-request-decline-btn">Decline</a>
            @else 
                <a href="javascript:void(0)" data-user-id="{{$r->user->id}}" data-request-id="{{$r->id}}"  class="text-success become-creator-request-approve-btn">Approve</a>
            @endif
        </td>
    </tr>
    @endforeach
    </tbody>
	</table>

    <script>
        $(document).on('click', '.become-creator-request-approve-btn', function() {
            var instance = this;
            $.ajax({
				url: '{{ route("becomeCreatorRequestApprove")}}',
				type: 'POST',
				headers: {
					'X-CSRF-TOKEN': '{{ csrf_token() }}'
				},
				data: {
                    requestId: $(instance).attr('data-request-id'),
                    userId: $(instance).attr('data-user-id')
				},
                dataType: 'json',
				success: function(resp) {
                    if (resp.success) {
                        alert('Successed!');
                        $(instance).addClass('become-creator-request-decline-btn');
                        $(instance).addClass('text-danger');
                        $(instance).removeClass('become-creator-request-approve-btn');
                        $(instance).removeClass('text-success');
                        $(instance).text('Decline');

                        $(instance).parents('tr').find('.td-approved').text('Yes');
                    }
                    else {
                        alert('Failed!');
                    }
				}
			})
        })

        $(document).on('click', '.become-creator-request-decline-btn', function() {
            var instance = this;
            $.ajax({
				url: '{{ route("becomeCreatorRequestDecline")}}',
				type: 'POST',
				headers: {
					'X-CSRF-TOKEN': '{{ csrf_token() }}'
				},
				data: {
                    requestId: $(instance).attr('data-request-id'),
                    userId: $(instance).attr('data-user-id')
				},
                dataType: 'json',
				success: function(resp) {
                    if (resp.success) {
                        alert('Successed!');
                        $(instance).removeClass('become-creator-request-decline-btn');
                        $(instance).removeClass('text-danger');
                        $(instance).addClass('become-creator-request-approve-btn');
                        $(instance).addClass('text-success');
                        $(instance).text('Approve');

                        $(instance).parents('tr').find('.td-approved').text('No');
                    }
                    else {
                        alert('Failed!');
                    }
				}
			})
        })
    </script>
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