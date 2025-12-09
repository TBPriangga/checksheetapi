@extends('component.navbar')

@section('content')

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Management Patrol</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a>Management Patrol</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>Detail Team</strong>
            </li>
        </ol>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
<div class="row">
    <div class="col-lg-12">
        <div class="ibox ">
            <div class="ibox-title bg-info">
                <h5>Anggota {{ $team->name }}</h5>
                <div class="ibox-tools">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-wrench" style="color:white"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="/genba/team/edit/{{ $team->id }}" class="dropdown-item">Edit Team</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="ibox-content">
                <div class="row" style="margin-left:0">
                    <div class="col-2 offset-8">

                    </div>

                </div>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th class="text-center">Nama</th>
                    <th class="text-center">NPK</th>
                    <th class="text-center">Departement</th>
                    <th class="text-center">Position</th>

                </tr>
            </thead>
            <tbody>
                @foreach($team->user as $user)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td class="text-center">{{ $user->user->name }}</td>
                    <td class="text-center">{{ $user->user->npk }}</td>
                    <td class="text-center">{{ $user->user->detail->name }}</td>
                    <td class="text-center">{{ $user->user->position->position }}</td>
                </tr>
                @endforeach

            </tbody>
        </table>
        </div>
    </div>
    </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title bg-info">
                    <h5>List Laporan genba</h5>
                </div>
            <div class="ibox-content">

                <div class="table-responsive mt-3">
                    <table class="table table-striped table-bordered table-hover dataTables-example-team">
                        <thead>
                        <tr>
                            <th >No</th>
                            <th class="">Tanggal Patrol</th>
                            <th class="col-sm-3" >Area</th>
                            <th class="col-sm-2">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach($team->genba_member as $laporan)

                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td class="">{{ $laporan->tanggal_patrol }}</td>
                                <td class="">{{ $laporan->genba_area->name }}</td>
                                <td>
                                    <a class="btn btn-info btn-block" href="/genba/laporan/{{ $laporan->id }}">See Detail</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>

                        </tfoot>
                    </table>
                </div>
        <div class="row" style="margin-left:0">

            <div class="col-lg-9">

            </div>
        </div>
        </div>
    </div>
    </div>
    </div>

</div>
{{-- <a class="btn btn-primary btn-sm" href="/laporan_penanggulangan" type="submit">Update Laporan</a> --}}
@endsection
