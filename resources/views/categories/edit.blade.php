@extends('layouts.app-master')

@section('content')
    <div class="bg-light p-4 rounded">
        <h2>Update Category</h2>
        <div class="lead">
            Edit Category.
        </div>

        <div class="container mt-4">
<<<<<<< HEAD
             <div>
              @if(session()->has('success'))
                  <div class="alert alert-primary">{{session('success')}}</div>
              @endif
              @if(session()->has('fail'))
                  <div class="alert alert-danger">{{session('fail')}}</div>
              @endif
            </div>
=======

>>>>>>> origin/master
            <form method="POST" action="{{ route('categories.update', $category->id) }}">
                @method('patch')
                @csrf
                <div class="mb-3">
<<<<<<< HEAD
                    <input type="hidden" value="{{ $category->id }}">
=======
>>>>>>> origin/master
                    <label for="name" class="form-label">Name</label>
                    <input value="{{ $category->name }}" 
                        type="text" 
                        class="form-control" 
                        name="name" 
                        placeholder="Name" required>

                    @if ($errors->has('name'))
                        <span class="text-danger text-left">{{ $errors->first('name') }}</span>
                    @endif
                </div>

<<<<<<< HEAD
                <!-- <div class="mb-3">
=======
                <div class="mb-3">
>>>>>>> origin/master
                    <label for="name" class="form-label">Name</label>
                    <input value="{{ $category->name }}" 
                        type="text" 
                        class="form-control" 
                        name="name" 
                        placeholder="Name" required>

                    @if ($errors->has('name'))
                        <span class="text-danger text-left">{{ $errors->first('name') }}</span>
                    @endif
<<<<<<< HEAD
                </div>    -->             
=======
                </div>                
>>>>>>> origin/master

                <button type="submit" class="btn btn-primary">Save changes</button>
                <a href="{{ route('categories.index') }}" class="btn btn-default">Back</a>
            </form>
        </div>

    </div>
@endsection