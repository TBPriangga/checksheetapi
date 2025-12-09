@extends('component.navbar')

@section('content')

@include('component.message')  

{{-- yield  content--}}
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Management Patrol</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="index.html">Management Patrol</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>Pembuatan Schedule</strong>
            </li>
        </ol>
    </div>
    <div class="col-lg-2">

    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">



                        @livewire('schedule-team')
                        @stack('scripts')

</div>

@endsection