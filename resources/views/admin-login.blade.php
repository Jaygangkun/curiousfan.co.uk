@extends('welcome')


@section('content')
<div class="container mt-5">
<div class="col-12 offset-0 col-sm-6 offset-sm-3">
	<div class="card p-3">
        <!-- <h3 class="heading"><i class="glyphicon glyphicon-lock"></i> Login</h3> -->
        <div class="form-logo">
			@if($logo = opt('form_logo'))
				<img src="{{ asset($logo) }}" alt="logo" width="100%" height="100%"/>
			@else
			{{ opt( 'site_title' ) }}
			@endif
		</div>
        @if( isset( $message ) AND !empty( $message ) )
        <div class="alert alert-info">
        	{{ $message }}
        </div>
        @endif

		<form method="POST" action="{{  route('adminLogin') }}">
		    {{ csrf_field() }}

		    <div>
		        Administrator
		        <input type="text" name="ausername" class="form-control">
		    </div>

		    <div>
		        Password
		        <input type="password" name="apassword" class="form-control">
		    </div>

		    <div>
		    	<br />
		        <button type="submit" class="btn btn-primary">Login</button>
		    </div>
		</form>

		<hr>
		<a class="btn btn-link" href="{{ url('/password/reset') }}">Forgot Your Password?</a>
	</div>

</div>
</div>
@endsection