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
            <th>Details</th>
            <th width="280px">Action</th>
        </tr>
        @foreach ($member as $item)
        <tr>
            <td>{{ $item->id }}</td>
            <td>{{ $item->name }}</td>
            <td>{{ $item->surname }}</td>
            <td>
                <form action="{{ route('member.destroy',$item->id) }}" method="POST">
   
                    <a class="btn btn-info" href="{{ route('member.show',$item->id) }}">Show</a>
    
                    <a class="btn btn-primary" href="{{ route('member.edit',$item->id) }}">Edit</a>
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>
  
    {!! $member->links() !!}
      
@endsection