@extends('layouts.app-master')

@section('content')
    <div class="bg-light p-4 rounded">
        <h2>Update Position</h2>
        <div class="lead">
            Edit Position.
        </div>

        <div class="container mt-4">

            <form method="POST" action="{{ route('position.update', $position->id) }}">
                @method('patch')
                @csrf
                <div class="mb-3">
                    <label for="code" class="form-label">Code</label>
                    <input value="{{ $position->code }}" 
                        type="text" 
                        class="form-control" 
                        name="code" 
                        placeholder="Code" required>

                    @if ($errors->has('code'))
                        <span class="text-danger text-left">{{ $errors->first('code') }}</span>
                    @endif
                </div>

                <div class="mb-3">
                    <label for="position" class="form-label">Position</label>
                    <input value="{{ $position->position }}" 
                        type="text" 
                        class="form-control" 
                        name="position" 
                        placeholder="Name" required>

                    @if ($errors->has('position'))
                        <span class="text-danger text-left">{{ $errors->first('position') }}</span>
                    @endif
                </div>    

                <button type="submit" class="btn btn-primary">Save changes</button>
                <a href="{{ route('position.index') }}" class="btn btn-default">Back</a>
            </form>
        </div>

    </div>
@endsection