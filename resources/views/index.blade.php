@extends('include.layout')
@section('content')
<div class="row">
	<div class="col-lg-12 margin-tb">
		<div class="pull-left">
			<h2>Dashboard</h2>
			<p>Good day {{ Auth::user()->name }}, you have successfully logged in</p>
		</div>
	</div>
</div>
@endsection