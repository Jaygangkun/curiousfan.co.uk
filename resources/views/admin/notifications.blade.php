@extends('admin.base')

@section('section_title')
<strong>Send Notification to All users or Individual user</strong>
@endsection

@section('section_body')

<form method="POST" action="/admin/send_notification">
{{ csrf_field() }}
    
<dl>
<dt>Notification Title</dt>
<dd><input type="text" name="notification_title" class="form-control" required="required" ></dd>
<br>
<dt>Notification Content</dt>
<dd><textarea name="notification_content" class="form-control" rows="8"></textarea></dd>
<dt>&nbsp;</dt>
<br>

<dd>
    <input type="radio" name="target_type" value="1" id="all" > <label for="all" >All</label>  &nbsp;&nbsp;&nbsp;<input type="radio" name="target_type" value="0" id="individual"> <label for="individual" >Individual User</label> 
    <select name="user" id="users_list" disabled>
        @foreach( $users as $u )
            <option value="{{ $u->id }}">
                {{ $u->name }} - ( {{ $u->email }} )
            </option>
        @endforeach
    </select>
</dd> 
<br>
<dd><input type="submit" name="sb_page" class="btn btn-primary" value="Send Notification"></dd>
</dl>

</form>
 
<script type='text/javascript'>
	
	$(function() {
	    $("#individual").click(function(){
	        $("#users_list").prop('disabled', false)
	    })
	    
	    $("#all").click(function(){
	        $("#users_list").prop('disabled', true)
	    })
	});

</script> 

 
@endsection


