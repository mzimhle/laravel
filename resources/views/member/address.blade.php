@extends('include.layout')
@section('style')
<link href="{{ asset('/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@stop
@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>{{ $member->name }}'s addresses</h2>
            </div>
        </div>
    </div>
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif
    <table class="table table-bordered yajra-datatable"></table>
	<h4>Add Address</h4>
	<p>Below is where you can add an address for {{ $member->name }}</p>
	@if ($errors->any())
		<div class="alert alert-danger">
			<strong>Whoops!</strong> There were some problems with your input.<br /><br />
			<ul>
				@foreach ($errors->all() as $error)
					<li>{{ $error }}</li>
				@endforeach
			</ul>
		</div>
	@endif	
	<form action="{{ route('address.store', ['id' => $member->id]) }}" method="POST">
		@csrf
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12">
				<div class="form-group">
					<strong>Address Line 1:</strong>
					<input type="text" name="address_1" class="form-control" placeholder="Address Line 1">
				</div>
			</div>
			<div class="col-xs-12 col-sm-12 col-md-12">
				<div class="form-group">
					<strong>Address Line 2:</strong>
					<input type="text" name="address_2" class="form-control" placeholder="Address Line 2">
				</div>
			</div>
			<div class="col-xs-12 col-sm-12 col-md-12">
				<div class="form-group">
					<strong>Type:</strong>
					<select name="type" class="form-control">
						<option value=""> ---- Choose ---- </option>
						<option value="PHYSICAL"> Physical Address </option>
						<option value="POSTAL"> Postal Address </option>
						<option value="WORK"> Work Address </option>
					</select>
				</div>
			</div>
			<div class="col-xs-12 col-sm-12 col-md-12">
				<div class="form-group">
					<strong>Area Code:</strong>
					<input type="text" name="area_code" class="form-control" placeholder="Area Code" />
				</div>
			</div>			
			<div class="col-xs-12 col-sm-12 col-md-12 text-center">
				<button type="submit" class="btn btn-primary">Submit</button>
			</div>
		</div>
	</form>	
@endsection
@section('javascript')
<script type="text/javascript">
$(function () {
	var table = $('.yajra-datatable').DataTable({
		processing: true,
		serverSide: true,
		ajax: "/member/{{ $member->id }}/address/paginate",
		columns: [
			{data: 'type', name: 'type', title: 'Type'},
			{data: 'address', name: 'address', title: 'Full Address'},
			{
				data: 'destroy', 
				name: 'destroy', 
				orderable: false, 
				searchable: false
			},				
		]
	});
});
function deleteMemberModal(id) {
	$('#memberid').val(id);
	$('#deleteMemberModal').modal('show');
	return false;
}

function deleteMember() {
	event.preventDefault();
	
	let id			= $('#memberid').val();
	let _token	= $('meta[name="csrf-token"]').attr('content');
	
	$.ajax({
		url: '/member/'+id+'/destroy',
		type:"POST",
		data: {
			"id": id,
			"_token": _token
		},
		success:function(response){			
			if(response) {
				window.location.href = window.location.href;
			}
		},
	});
}
</script>
<!-- Modal -->
<div class="modal fade" id="deleteMemberModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header">
			<h4 class="modal-title">Delete Member</h4>
		</div>
		<div class="modal-body">Are you sure you want to delete this member?</div>
		<div class="modal-footer">
			<button data-dismiss="modal" class="btn btn-default" type="button">Cancel</button>
			<button class="btn btn-warning" type="button" onclick="javascript:deleteMember();">Delete</button>
			<input type="hidden" id="memberid" name="memberid" value="" />
		</div>
	</div>
</div>
</div>
<!-- modal -->
@stop