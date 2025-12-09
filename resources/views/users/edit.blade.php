@extends('layouts.app-master')

@section('content')
<link href="{{asset('css/plugins/chosen/bootstrap-chosen.css')}}" rel="stylesheet">

<div class="bg-light p-4 rounded">
    <h1>Update User</h1>
    <div class="lead">
        
    </div>
    
    <div class="container mt-4">
        <form method="post" action="{{ route('users.update', $user->id) }}">
            @method('patch')
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input value="{{ $user->name }}" 
                    type="text" 
                    class="form-control" 
                    name="name" 
                    placeholder="Name" required>

                @if ($errors->has('name'))
                    <span class="text-danger text-left">{{ $errors->first('name') }}</span>
                @endif
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input value="{{ $user->email }}"
                    type="email" 
                    class="form-control" 
                    name="email" 
                    placeholder="Email address" required>
                @if ($errors->has('email'))
                    <span class="text-danger text-left">{{ $errors->first('email') }}</span>
                @endif
            </div>
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input value="{{ $user->username }}"
                    type="text" 
                    class="form-control" 
                    name="username" 
                    placeholder="Username" required>
                @if ($errors->has('username'))
                    <span class="text-danger text-left">{{ $errors->first('username') }}</span>
                @endif
            </div>
            <div class="form-group">
                <label for="role" class="form-label">Role</label>
                <select class="form-control chosen-select" data-placeholder=" --Role--" name="role[]" id="role" tabindex="4" multiple required>
                    @foreach ($roles as $role)
                    <option value="{{ $role->name }}" {{  ( in_array($role->name, $userRole) ? "selected":"") }}>{{ $role->name }}</option>
                    @endforeach
                </select>
                @error('role') 
                <div class="invalid-feedback">
                    {{$message}}
                </div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Update user</button>
            <a href="{{ route('users.index') }}" class="btn btn-default">Cancel</a> 
        </form>
    </div>

</div>
@endsection

@push('scripts')
    <script src="{{asset('js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('js/dataTables.dateTime.min.js')}}"></script>
    <script src="{{asset('js/plugins/select2/select2.full.min.js')}}"></script>
    <script src="{{asset('js/js_agil/dataTables.responsive.js')}}"></script>
    <script src="{{asset('js/moment.min.js')}}"></script>
    <script src="{{asset('js/plugins/chosen/chosen.jquery.js')}}"></script>
    <script>
        $('.chosen-select').chosen({width: "100%"});
        $('#role').change(function(){
        //         console.log($(this).val());
        //     });
        // $(document).ready(){function(){
        //     $('#role').change(function(){
        //         console.log($(this).val());
        //     });
        });

    </script>
@endpush
    
