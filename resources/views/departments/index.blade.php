@extends('layouts.app-master')

@section('content')

    <div class="bg-light p-4 rounded">
        <h2>Departments</h2>
        <div class="lead">
            Manage your Departments here.
            <a href="{{ route('departments.create') }}" class="btn btn-primary btn-sm float-right">Add Department</a>
        </div>
        
        <div class="mt-2">
            @include('layouts.partials.messages')
        </div>

        <table id="datatable" class="display">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Code</th>
                    <th>Name</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($departments as $key => $department)
                <tr>
                    <td>{{ $loop->iteration + (($departments->currentPage() -1) * $departments->perPage())  }}</td>
                    <td>{{ $department->code }}</td>
                    <td>{{ $department->name }}</td>
                    <td>
                        <a class="btn btn-info btn-sm" href="{{ route('departments.show', $department->id) }}">Show</a>
                    
                        <a class="btn btn-primary btn-sm" href="{{ route('departments.edit', $department->id) }}">Edit</a>
                    
                        {!! Form::open(['method' => 'DELETE','route' => ['departments.destroy', $department->id],'style'=>'display:inline']) !!}
                        {!! Form::submit('Delete', ['class' => 'btn btn-danger btn-sm', 'onclick' => 'return confirm("Are you sure?")']) !!}
                        {!! Form::close() !!}
                    </td>
                </tr>
                @endforeach
            </tbody>         
        </table>

        <div class="d-flex">
            {!! $departments->links() !!}
        </div>

    </div>
@endsection

@push('scripts')
<script type="text/javascript" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>

<script type="text/javascript">
  $(document).ready(function() {
      $('#datatable').DataTable({
        // "pageLength": 2
      });
  } );
</script>
@endpush
