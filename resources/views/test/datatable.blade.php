@extends('component.navbar')

@section('content')
@include('component.message')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Laporan</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a>Laporan</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>Tabel Laporan</strong>
            </li>
        </ol>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    @livewire('data-tables')
    @stack('scripts')

</div>

@endsection