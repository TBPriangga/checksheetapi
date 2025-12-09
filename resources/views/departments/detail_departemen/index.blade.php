@extends('layouts.app-master')

@section('content')
    {{-- datatable library css --}}
    <link href="{{asset('css/dataTables.dateTime.min.css')}}" rel="stylesheet">
    <link href="{{asset('css/jquery.dataTables.min.css')}}" rel="stylesheet">
    <link href="{{asset('css/plugins/select2/select2.min.css')}}" rel="stylesheet">

    <link href="{{asset('css/css_agil/responsive.dataTables.css')}}" rel="stylesheet">

    <!-- Sweet Alert -->
    <link href="{{asset('css/plugins/sweetalert/sweetalert.css')}}" rel="stylesheet">

    <div class="bg-light p-4 rounded">
        <h2>Detail Departments</h2>
        <div class="lead">
            <a href="{{ route('detail_departments.create') }}" class="btn btn-primary btn-sm float-right mb-1">Add Detail Department</a>
        </div>
        
        <div class="mt-2">
            @include('layouts.partials.messages')
        </div>

        <table id="datatable" class="table table-bordered   ">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Code</th>
                    <th>Name</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($detail_dept as $key => $department)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $department->code }}</td>
                    <td>{{ $department->name}}</td>
                    <td>
                        <a class="btn btn-primary btn-sm" href="{{ route('detail_departments.edit', $department->id) }}">Edit</a>
                        {!! Form::open(['method' => 'DELETE','route' => ['detail_departments.destroy', $department->id],'style'=>'display:inline']) !!}
                        {!! Form::submit('Delete', ['class' => 'btn btn-danger btn-sm', 'onclick' => 'return confirm("Are you sure?")']) !!}
                        {!! Form::close() !!}
                    </td>
                </tr>
                @endforeach
            </tbody>         
        </table>

       

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
