@extends('member.layout')
 
@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Members</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-success" href="{{ route('member.create') }}"> Create New Member</a>
            </div>
        </div>
    </div>
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif
    <table class="table table-bordered">
        <tr>
            <th>No</th>
            <th>Name</th>
            <th>Surname</th>
            <th>Cellphone</th>
            <th>Email</th>			
            <th width="280px">Action</th>
        </tr>
        @foreach ($member as $item)
        <tr>
            <td>{{ $item->id }}</td>
            <td>{{ $item->name }}</td>
            <td>{{ $item->surname }}</td>
            <td>{{ $item->cellphone }}</td>
            <td>{{ $item->email }}</td>			
            <td>
                    <a class="btn btn-info" href="{{ route('member.show',$item->id) }}">Show</a>
                    <a class="btn btn-primary" href="{{ route('member.edit',$item->id) }}">Edit</a>
                    <button onclick="deleteMemberModal('{{ $item->id }}'); return false;" class="btn btn-danger">Delete</button>
            </td>
        </tr>
        @endforeach
    </table>
    {!! $member->links() !!}
	<script>
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
@endsection
