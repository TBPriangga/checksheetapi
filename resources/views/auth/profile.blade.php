@extends('component.navbar')

@section('content')

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Profile</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item active">
                <strong>Profile</strong>
            </li>
        </ol>
    </div>
</div>
@if (session('status'))
    <div class="alert alert-success m-4">
        {{ session('status') }}
    </div>
@endif
{{-- div content  --}}
<div class="wrapper wrapper-content animated fadeInRight ecommerce">

    <div class="row mb-5">
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
                                        <div class="col-sm-10"><input type="text" class="form-control" placeholder="Nama" value="{{ Auth::user()->name }}" disabled></div>
                                    </div>
                                    <div class="form-group row"><label class="col-sm-2 col-form-label">Username:</label>
                                        <div class="col-sm-10"><input type="text" class="form-control" placeholder="Username" value="{{ Auth::user()->username }}" disabled></div>
                                    </div>
                                    <div class="form-group row"><label class="col-sm-2 col-form-label" >Email:</label>
                                        <div class="col-sm-10"><input type="text" class="form-control" placeholder="Email" value="{{ Auth::user()->email }}" disabled></div>
                                    </div>

                                </fieldset>
                                <hr>
                                <form action="{{ route('profile.new.password') }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin Memperbarui Password?');">
                                    @csrf
                                <p> <strong>Ubah password</strong> </p>
                                <div class="form-group row d-flex align-items-center">
                                    <label class="col-sm-2 col-form-label">Konfirmasi Password Lama</label>
                                    <div class="col-sm-4">
                                        <input id="password-lama" name="password_lama" type="password" class="form-control" >
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Password Baru</label>
                                    <div class="col-sm-4">
                                        <input id="password-baru" name="password_baru" type="password" class="form-control" >
                                    </div>
                                </div>
                                <div class="mt-3 bg-black">
                                <button class="btn btn-warning btn-sm" type="submit">Perbarui Password</button>
                            </div>
                            </form>
                            </div>
                        </div>
                        {{-- end tab 1 --}}

                        {{-- start tab 2 --}}
                        <div id="tab-2" class="tab-pane">
                            <div class="panel-body">

                                <fieldset>
                                    <div class="form-group row"><label class="col-sm-2 col-form-label">Nama</label>
                                        <div class="col-sm-10"><input type="text" class="form-control" placeholder="Nama" value="{{ Auth::user()->name }}" disabled></div>
                                    </div>
                                    <div class="form-group row"><label class="col-sm-2 col-form-label">NPK</label>
                                        <div class="col-sm-10"><input type="text" class="form-control" placeholder="NPK" value="{{ Auth::user()->npk }}" disabled></div>
                                    </div>
                                    <div class="form-group row"><label class="col-sm-2 col-form-label">Departement</label>
                                        <div class="col-sm-10"><input type="text" class="form-control" placeholder="Departement" value="{{ Auth::user()->department->name }}" disabled></div>
                                    </div>
                                    <div class="form-group row"><label class="col-sm-2 col-form-label">Detail Departement</label>
                                        <div class="col-sm-10"><input type="text" class="form-control" placeholder="Detail_Departement" value="{{ Auth::user()->detail->name }}" disabled></div>
                                    </div>
                                    <div class="form-group row"><label class="col-sm-2 col-form-label">Position</label>
                                        <div class="col-sm-10"><input type="text" class="form-control" placeholder="Position" value="{{ Auth::user()->position->position }}" disabled></div>
                                    </div>
                                    <div class="form-group row"><label class="col-sm-2 col-form-label">Role</label>
                                        <div class="col-sm-10"><input type="text" class="form-control" placeholder="Role" value="@foreach(Auth::user()->roles as $key => $role){{$role->name}}@if($key !== count(Auth::user()->roles) - 1),@endif @endforeach" disabled>
                                    </div>
                                    </div>
                                    @if(Auth::user()->roles[0]->id == 3)
                                    <div class="form-group row"><label class="col-sm-2 col-form-label">Area</label>
                                        <div class="col-sm-10"><input type="text" class="form-control" placeholder="Area" @if(Auth::user()->area->isempty()) value="Area Belum Terdaftar" @else value="{{ Auth::user()->area[0]->area->name}}" @endif disabled></div>
                                    </div>
                                    @endif
                                </fieldset>

                            </div>
                        </div>
                        {{-- end tab 2 --}}

                    </div>
            </div>
        </div>
    </div>

</div>

{{-- end content  --}}

@endsection
