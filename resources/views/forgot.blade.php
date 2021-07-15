@extends('include.layout')
@section('content')
	<h3>Forgot Password</h3>
    <form action="{{ route('auth.submitforgot') }}" method="POST">
        @csrf
         <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Email:</strong>
                    <input type="text" name="email" value="" class="form-control" placeholder="Email">
					@error('email')
						<div class="alert alert-danger">{{ $message }}</div>
					@enderror
					@if(session()->has('message'))
						<div class="alert alert-success">
							{{ session()->get('message') }}
						</div>
					@endif
                </div>
            </div>	
            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
				<button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </div>
    </form>
@endsection