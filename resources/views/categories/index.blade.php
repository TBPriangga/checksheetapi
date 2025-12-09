@extends('layouts.app-master')

@section('content')

    <div class="bg-light p-4 rounded">
        <h2>Categories</h2>
        <div class="lead">
            Manage your Category / Folder here.
            <a href="{{ route('categories.create') }}" class="btn btn-primary btn-sm float-right">Add Category</a>
        </div>
        
        <div class="mt-2">
            @include('layouts.partials.messages')
        </div>

        <table id="datatable" class="display">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Name</th>
                    <!-- <th>Parent</th> -->
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($categories as $key => $category)
                <tr>
                    <td>{{ $loop->iteration + (($categories->currentPage() -1) * $categories->perPage())  }}</td>
                    <td>{{ $category->name }}</td>
                    <!-- <td>{{ $category->parent_id }}</td> -->
                    <td>
                        <!-- <a class="btn btn-info btn-sm" href="{{ route('categories.show', $category->id) }}">Show</a> -->
                    
                        <a class="btn btn-primary btn-sm" href="{{ route('categories.edit', $category->id) }}">Edit</a>
                    
                        {!! Form::open(['method' => 'DELETE','route' => ['categories.destroy', $category->id],'style'=>'display:inline']) !!}
                        {!! Form::submit('Delete', ['class' => 'btn btn-danger btn-sm', 'onclick' => 'return confirm("Are you sure?")']) !!}
                        {!! Form::close() !!}
                    </td>
                </tr>
                @endforeach
            </tbody>         
        </table>

        <div class="d-flex">
            {!! $categories->links() !!}
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
