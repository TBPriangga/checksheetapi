@extends('layouts.app-master')

@section('content')
    <div class="bg-light p-4 rounded">
        <h2>Show Department</h2>
        <div class="lead">
            
        </div>
        
        <div class="container mt-4">
            <div>
                Title: {{ $department->code }}
            </div>
            <div>
                Description: {{ $department->name }}
            </div>
        </div>

    </div>
    <div class="mt-4">
        <a href="{{ route('departments.edit', $department->id) }}" class="btn btn-info">Edit</a>
        <a href="{{ route('departments.index') }}" class="btn btn-default">Back</a>
    </div>
@endsection
