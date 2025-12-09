@extends('layouts.app-master')

@section('content')
    <div class="bg-light p-4 rounded">
        <h1>Add new role</h1>
        <div class="lead">
            Add new role and assign permissions.
        </div>

        <div class="container mt-4">

            @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <strong>Whoops!</strong> There were some problems with your input.<br><br>
                    <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                    </ul>
                </div>
            @endif
            <div class="btn-group mb-1">
                <button class="btn btn-primary delivery_btn ">Delivery</button>
                <button class="btn btn-danger quality_btn">Quality</button>
                <button style="background-color:black" class="btn text-white scanner_btn">Scanner</button>
                <button class="btn btn-default all_btn">All category</button>
            </div>
            <form method="POST" action="{{ route('roles.store') }}">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input value="{{ old('name') }}" 
                        type="text" 
                        class="form-control" 
                        name="name" 
                        placeholder="Name" required>
                </div>
                
                <label for="permissions" class="form-label">Assign Permissions</label>

                <table class="table table-striped">
                    <thead>
                        <th scope="col" width="1%"><input type="checkbox" name="all_permission"></th>
                        <th scope="col" width="20%">Name</th>
                        <th scope="col" width="1%">Guard</th> 
                    </thead>

                    @foreach($permissions_delivery as $permission)
                        <tr class="delivery_checkbox">
                            <td>
                                <input type="checkbox" 
                                name="permission[{{ $permission->name }}]"
                                value="{{ $permission->name }}"
                                class='permission'>
                            </td>
                            <td>{{ $permission->name }}</td>
                            <td>{{ $permission->guard_name }}</td>
                        </tr>
                    @endforeach
                    @foreach($permissions_quality as $permission)
                        <tr class="quality_checkbox">
                            <td>
                                <input type="checkbox" 
                                name="permission[{{ $permission->name }}]"
                                value="{{ $permission->name }}"
                                class='permission'>
                            </td>
                            <td>{{ $permission->name }}</td>
                            <td>{{ $permission->guard_name }}</td>
                        </tr>
                    @endforeach
                    @foreach($permissions_scanner as $permission)
                        <tr class="scanner_checkbox">
                            <td>
                                <input type="checkbox" 
                                name="permission[{{ $permission->name }}]"
                                value="{{ $permission->name }}"
                                class='permission'>
                            </td>
                            <td>{{ $permission->name }}</td>
                            <td>{{ $permission->guard_name }}</td>
                        </tr>
                    @endforeach
                    @foreach($permissions_all as $permission)
                        <tr class="sisa_category_checkbox">
                            <td>
                                <input type="checkbox" 
                                name="permission[{{ $permission->name }}]"
                                value="{{ $permission->name }}"
                                class='permission'>
                            </td>
                            <td>{{ $permission->name }}</td>
                            <td>{{ $permission->guard_name }}</td>
                        </tr>
                    @endforeach
                </table>

                <button type="submit" class="btn btn-primary">Save user</button>
                <a href="{{ route('users.index') }}" class="btn btn-default">Back</a>
            </form>
        </div>

    </div>
@endsection

@section('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            $('[name="all_permission"]').on('click', function() {

                if($(this).is(':checked')) {
                    $.each($('.permission'), function() {
                        $(this).prop('checked',true);
                    });
                } else {
                    $.each($('.permission'), function() {
                        $(this).prop('checked',false);
                    });
                }
                
            });

            $('.delivery_btn').click(function(){
                
                $('.delivery_checkbox').show();
                $('.quality_checkbox').hide();
                $('.scanner_checkbox').hide();
                $('.sisa_category_checkbox').hide();
                
            });

            $('.quality_btn').click(function(){
                
                $('.quality_checkbox').show();
                $('.delivery_checkbox').hide();
                $('.scanner_checkbox').hide();
                $('.sisa_category_checkbox').hide();

            });

            $('.scanner_btn').click(function(){

                
                $('.scanner_checkbox').show();
                $('.delivery_checkbox').hide();
                $('.quality_checkbox').hide();
                $('.sisa_category_checkbox').hide();

            });

            $('.all_btn').click(function(){
                
                $('.delivery_checkbox').show();
                $('.quality_checkbox').show();
                $('.scanner_checkbox').show();
                $('.sisa_category_checkbox').show();

            });
        });
    </script>
@endsection