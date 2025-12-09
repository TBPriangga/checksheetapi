@extends('component.navbar')

@section('content')

@include('component.message')  
{{-- yield  content--}}
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Account Management</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a >Setting Management</a>
            </li>
            <li class="breadcrumb-item active">
                <strong><a href="{{url('/karyawan')}}">Account Management</a></strong>
            </li>
            <li class="breadcrumb-item active">
                <strong>Detail Karyawan</strong>
            </li>
        </ol>
    </div>
    <div class="col-lg-2">

    </div>
</div>


{{-- div content  --}}
<div class="wrapper wrapper-content animated fadeInRight ecommerce">

    <div class="row">
        <div class="col-lg-12">
            <div class="tabs-container">
                    <ul class="nav nav-tabs">
                        <li><a class="nav-link active" data-toggle="tab" href="#tab-1">Acount</a></li>
                        <li><a class="nav-link" data-toggle="tab" href="#tab-2"> Profile</a></li>
                    </ul>
                    <div class="tab-content">

                        {{-- start tab 1 --}}
                        <div id="tab-1" class="tab-pane active">
                            <div class="panel-body">

                                <fieldset>
                                    <div class="form-group row"><label class="col-sm-2 col-form-label">Nama</label>
                                        <div class="col-sm-10"><input type="text" class="form-control" placeholder="Nama" value="{{ $karyawan->name }}" disabled></div>
                                    </div>
                                    <div class="form-group row"><label class="col-sm-2 col-form-label">Username:</label>
                                        <div class="col-sm-10"><input type="text" class="form-control" placeholder="Username" value="{{ $karyawan->username }}" disabled></div>
                                    </div>
                                    <div class="form-group row"><label class="col-sm-2 col-form-label" >Email:</label>
                                        <div class="col-sm-10"><input type="text" class="form-control" placeholder="Email" value="{{ $karyawan->email }}" disabled></div>
                                    </div>
                                    
                                </fieldset>

                                <div class="mt-3 bg-black">
                                    <form action="{{route('deleteKaryawan')}}" method="post" class="inline">
                                        @csrf
                                        <input type="hidden" name="id" value={{ $karyawan->id }}>
                                <button class="btn btn-danger btn-sm" type="submit">Hapus</button>
                                </form>                            
                                <a class="btn btn-warning btn-sm" href="{{ route('editKaryawan', ['id' => $karyawan->id]) }}" type="submit">Edit Karyawan</a>
                            </div>

                            </div>
                        </div>
                        {{-- end tab 1 --}}

                        {{-- start tab 2 --}}
                        <div id="tab-2" class="tab-pane">
                            <div class="panel-body">

                                <fieldset>
                                    <div class="form-group row"><label class="col-sm-2 col-form-label">Nama</label>
                                        <div class="col-sm-10"><input type="text" class="form-control" placeholder="Nama" value="{{ $karyawan->name }}" disabled></div>
                                    </div>
                                    <div class="form-group row"><label class="col-sm-2 col-form-label">NPK</label>
                                        <div class="col-sm-10"><input type="text" class="form-control" placeholder="NPK" value="{{ $karyawan->npk }}" disabled></div>
                                    </div>
                                    <div class="form-group row"><label class="col-sm-2 col-form-label">Departement</label>
                                        <div class="col-sm-10"><input type="text" class="form-control" placeholder="Departement" value="{{ $karyawan->department->name }}" disabled></div>
                                    </div>
                                    <div class="form-group row"><label class="col-sm-2 col-form-label">Detail Departement</label>
                                        <div class="col-sm-10"><input type="text" class="form-control" placeholder="Detail_Departement" value="{{ $karyawan->detail->name }}" disabled></div>
                                    </div>
                                    <div class="form-group row"><label class="col-sm-2 col-form-label">Position</label>
                                        <div class="col-sm-10"><input type="text" class="form-control" placeholder="Position" value="{{ $karyawan->position->position }}" disabled></div>
                                    </div>
                                    <div class="form-group row"><label class="col-sm-2 col-form-label">Role</label>
                                        <div class="col-sm-10"><input type="text" class="form-control" placeholder="Role" value="@foreach($karyawan->roles as $key => $role){{$role->name}}@if($key !== count($karyawan->roles) - 1),@endif @endforeach" disabled>
                                    </div>
                                    </div>
                                    @if($karyawan->roles[0]->id == 3)
                                    <div class="form-group row"><label class="col-sm-2 col-form-label">Area</label>
                                        <div class="col-sm-10"><input type="text" class="form-control" placeholder="Area" @if($karyawan->area->isempty()) value="Area Belum Terdaftar" @else value="{{ $karyawan->area[0]->area->name}}" @endif disabled></div>
                                    </div>
                                    @endif
                                </fieldset>
                                <div class="mt-3 bg-black">
                                    <form action="{{ route('deleteKaryawan') }}" method="post" class="inline">
                                        @csrf
                                        <input type="hidden" name="id" value={{ $karyawan->id }}>
                                    <button class="btn btn-danger btn-sm" type="submit">Hapus</button>
                                    </form>                            
                                    <a class="btn btn-warning btn-sm" href="{{ route('editKaryawan', ['id' => $karyawan->id]) }}" type="submit">Edit Karyawan</a>
                                </div>

                            </div>
                        </div>
                        {{-- end tab 2 --}}

                    </div>
            </div>
        </div>
    </div>

</div>

{{-- end content  --}}
{{-- end yield content --}}

@endsection