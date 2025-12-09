@extends('layouts.app-master')

@section('content')
    <div class="bg-light p-4 rounded">
        <h2>Update Department</h2>
        <div class="lead">
            Edit Department.
        </div>

        <div class="container mt-4">

            <form method="POST" action="{{ route('departments.update', $department->id) }}">
                @method('patch')
                @csrf
                <div class="mb-3">
                    <label for="code" class="form-label">Code</label>
                    <input value="{{ $department->code }}" 
                        type="text" 
                        class="form-control" 
                        name="code" 
                        placeholder="Code" required>

                    @if ($errors->has('code'))
                        <span class="text-danger text-left">{{ $errors->first('code') }}</span>
                    @endif
                </div>

                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input value="{{ $department->name }}" 
                        type="text" 
                        class="form-control" 
                        name="name" 
                        placeholder="Name" required>

                    @if ($errors->has('name'))
                        <span class="text-danger text-left">{{ $errors->first('name') }}</span>
                    @endif
                </div>                

                <button type="submit" class="btn btn-primary">Save changes</button>
                <a href="{{ route('departments.index') }}" class="btn btn-default">Back</a>
            </form>
        </div>

    </div>
@endsection