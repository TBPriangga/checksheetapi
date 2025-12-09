@extends('layouts.app-master')

@section('content')
    <div class="bg-light p-4 rounded">
        <h2>Update detail Department</h2>
        <div class="lead">
            Edit detail Department.
        </div>

        <div class="container mt-4">

            <form method="POST" action="{{ route('detail_departments.update', $detail_dept->id) }}">
                @method('patch')
                @csrf
                <div class="mb-3">
                    <label for="code" class="form-label">Code</label>
                    <input value="{{ $detail_dept->code }}" 
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
                    <input value="{{ $detail_dept->name }}" 
                        type="text" 
                        class="form-control" 
                        name="name" 
                        placeholder="Name" required>

                    @if ($errors->has('name'))
                        <span class="text-danger text-left">{{ $errors->first('name') }}</span>
                    @endif
                </div>    

                <div class="mb-3">
                    <label for="departement_id" class="form-label">Departement id</label>
                    <input value="{{ $detail_dept->departement_id }}" 
                        type="text" 
                        class="form-control" 
                        departement_id="departement_id" 
                        placeholder="Name" required>

                    @if ($errors->has('departement_id'))
                        <span class="text-danger text-left">{{ $errors->first('departement_id') }}</span>
                    @endif
                </div>                

                <button type="submit" class="btn btn-primary">Save changes</button>
                <a href="{{ route('detail_departments.index') }}" class="btn btn-default">Back</a>
            </form>
        </div>

    </div>
@endsection