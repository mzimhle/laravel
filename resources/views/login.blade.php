@extends('include.layout')
@section('content')
<h3>Login</h3>
<form action="{{ route('auth.submitlogin') }}" method="POST">
	@csrf
	 <div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12">
			<div class="form-group">
				<strong>Email:</strong>
				<input type="text" name="email" value="" class="form-control" placeholder="Email">
				@error('email')
				<div class="alert alert-danger">{{ $message }}</div>
				@enderror					
			</div>
		</div>
		<div class="col-xs-12 col-sm-12 col-md-12">
			<div class="form-group">
				<strong>Password:</strong>
				<input type="password" name="password" value="" class="form-control" placeholder="Password">
				@error('password')
					<div class="alert alert-danger">{{ $message }}</div>
				@enderror						
			</div>
		</div>		
		<div class="col-xs-12 col-sm-12 col-md-12 text-center">
		  <button type="submit" class="btn btn-primary">Submit</button>
		</div>
	</div>
</form>
@endsection