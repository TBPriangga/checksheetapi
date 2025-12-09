@extends('layouts.app-master')

@section('content')
    
    <h1 class="mb-3">Demo List</h1>

    <div class="bg-light p-4 rounded">
        <h2>Demo</h2>
        <div class="lead">
            Manage your demo here.
            <a href="{{ route('demo.create') }}" class="btn btn-primary btn-sm float-right">Add demo</a>
        </div>

        <div class="lead">
            <a class="btn btn-info btn-sm" href="{{ route('demo.index') }}">Show Data</a> | 
            <a class="btn btn-info btn-sm" href="{{ route('demo.trash') }}">Show Trash</a>
        </div>
        
        <div class="mt-2">
            @include('layouts.partials.messages')
        </div>

        <table class="table table-bordered">
          <tr>
             <th width="1%">NIP</th>
             <th>Nama</th>
             <th>Alamat</th>
             <th width="3%" colspan="3">Action</th>
          </tr>
            @foreach ($demos as $key => $demo)
            <tr>
                <td>{{ $demo->nip }}</td>
                <td>{{ $demo->nama }}</td>
                <td>{{ $demo->alamat }}</td>
                <td>
                    <a class="btn btn-info btn-sm" href="{{ route('demo.show', $demo->id) }}">Show</a>
                </td>
                <td>
                    <a class="btn btn-primary btn-sm" href="{{ route('demo.edit', $demo->id) }}">Edit</a>
                </td>
                <td>
                    {!! Form::open(['method' => 'DELETE','route' => ['demo.destroy', $demo->id],'style'=>'display:inline']) !!}
                    {!! Form::submit('Delete', ['class' => 'btn btn-danger btn-sm']) !!}
                    {!! Form::close() !!}
                </td>
            </tr>
            @endforeach
        </table>

        <div class="d-flex">
            {!! $demos->links() !!}
        </div>

    </div>
@endsection
