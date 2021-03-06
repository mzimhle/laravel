@extends('include.layout')
@section('style')
<link href="{{ asset('/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@stop
@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Members</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-success" href="/member/create"> Create New Member</a>
            </div>
        </div>
    </div>
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif
    <table class="table table-bordered yajra-datatable">
        <tbody></tbody>
    </table>
@endsection
@section('javascript')
<script type="text/javascript">
$(function () {
	var table = $('.yajra-datatable').DataTable({
		processing: true,
		serverSide: true,
		ajax: "/member/paginate",
		columns: [
			{data: 'name', name: 'name', title: 'Name'},
			{data: 'surname', name: 'surname', title: 'Surame'},
			{data: 'cellphone', name: 'cellphone', title: 'Cellphone'},
			{data: 'email', name: 'email', title: 'Email'},
			{
				data: 'address', 
				name: 'address', 
				orderable: false, 
				searchable: false
			},
			{
				data: 'edit', 
				name: 'edit', 
				orderable: false, 
				searchable: false
			},
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