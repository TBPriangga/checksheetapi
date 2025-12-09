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
                <strong>Tambah Karyawan</strong>
            </li>
        </ol>
    </div>
    <div class="col-lg-2">

    </div>
</div>

{{-- div content  --}}

<div class="wrapper wrapper-content animated fadeInRight">
        {{-- <h2>
            Tambah Karyawan
        </h2> --}}
        
        @livewire('create-karyawan', [
                                      'roles' => $roles,   
                                      'areas' => $areas,
                                      'departments' => $departments,
                                      'detail_departements' => $detail_departements,
                                      'positions' => $positions,            
                                      ])
        @stack('scripts')



</div>
{{-- end content  --}}
{{-- end yield content --}}
@endsection