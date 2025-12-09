@extends('component.navbar')

@section('content')

@include('component.message')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>EHS Patrol</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{route('patrolEhs')}}">Table EHS Patrol</a>
            </li>
            <li class="breadcrumb-item">
                <strong>Detail Laporan</strong>
            </li>
        </ol>
    </div>
</div>

@php
        $deptHeadEHS = App\Models\User::role('Departement Head EHS')->first();
        $deptHeadPIC = App\Models\user_has_area::where('area_id', $laporan->area_id)->whereHas('user.roles', function ($query) {$query->where('name', 'Departement Head PIC');})->first();
@endphp

<div class="wrapper wrapper-content animated fadeInRight">
<div class="row">
    <div class="col-lg-12">
        <div class="ibox ">
            <div class="ibox-title bg-info">
                <h5>Data Patrol</h5>
                @if(auth()->user()->roles[0]->name == "EHS")
                <div class="ibox-tools">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-wrench" style="color:white"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="{{ route('patrolEhsEdit', ['id' => $laporan->id]) }}" class="dropdown-item">Edit Data</a>
                        </li>
                    </ul>
                </div>
                @endif
            </div>
            <div class="ibox-content">
                    <div class="form-group row">
                        
                        <label class="col-lg-2 col-form-label">Area</label>

                        <div class="col-sm-4"><input type="text" disabled="" placeholder="{{ $laporan->area_patrol->name }}" class="form-control"></div>
                        
                        <label class="col-lg-2 col-form-label">Tanggal Patrol</label>

                        <div class="col-sm-4"><input type="text" disabled="" placeholder="@dateWithDay($laporan->tanggal_patrol)" class="form-control"></div>
                    </div>

                </div> 
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title bg-info">
                    <h5>Temuan Patrol</h5>
                </div>
            <div class="ibox-content">
                <div class="row my-0 my-sm-4" style="margin-left:0">
                    <div class="col-2 @if($exportVisible) offset-6 @else offset-8 @endif">
                        
                    </div>
                    <div class="col-sm-2 offset-sm-10 m-3 m-sm-0 text-end">
                        @if($laporan->deleted_at == null)
                        @role('EHS')
                        <a class="btn btn-block btn-primary compose-mail" href="{{route('createForm', ['id' => $laporan->id])}}">Buat Temuan</a>
                        @endrole
                        @endif
                    </div>
                    <div class="col-sm-2 mx-3 m-sm-0 text-end">
                        @if($exportVisible)
                        <form method="post" action="{{route('exportLaporan')}}">
                            @csrf
                            <input type="hidden" value="{{ $laporan->id }}" name="patrol_id">
                            <input type="hidden" name="tipe_tabel" value="laporan_patrol">
                        <button class="btn btn-block btn-info compose-mail" type="submit">Export laporan</button>
                        </form>
                        @endif
                    </div>
                </div>
                <div class="table-responsive">
        <table class="table table-striped dataTables-example-temuan-patrol">
            {{-- <thead>
                <tr>
                    <th >No</th>
                    <th class="text-center">Temuan </th>
                    <th class="text-center" >Area </th>
                    <th class="text-center" >Kategori Stop-6</th>
                    <th class="text-center" >Rank</th>
                    <th class="text-center" >Tanggal Laporan</th>
                    <th class="text-center" >Due Date</th>
                    <th class="text-center" >Status </th>
                    <th class="text-center" >Action </th>
                </tr>
                </thead>
                <tbody>
                    @foreach($temuans as $temuan)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td class="text-center">{{ $temuan->temuan }}</td>
                        <td class="text-center">{{ $temuan->area->name }}</td>
                        <td class="text-center">{{ $temuan->kategori }}</td>
                        <td class="text-center">{{ $temuan->rank }}</td>
                        <td class="text-center">{{ date('d/m/Y', strtotime($temuan->created_at)) }}</td>
                        <td class="text-center">{{ date('d/m/Y', strtotime($temuan->deadline_date)) }}</td>
                        @if ($temuan->ACC_Dept_Head_PIC_At == null && $temuan->progress <= 10.00) 
                            <td class="text-center"><span class="pou">{{ $temuan->progress }}/10</span></td>
                        @elseif ($temuan->verify_submit_at == null)
                            <td class="text-center"><span class="pie">{{ $temuan->progress }}/10</span></td>
                        @elseif ($temuan->ACC_Dept_Head_EHS_At == null && $temuan->progress == 12)
                            <td class="text-center"><span class="fa fa-check text-warning"></span></td>
                        @else
                            <td class="text-center"><span class="fa fa-check text-navy"></span></td>
                            
                        @endif
                        <td class="text-center"><a class="btn btn-info btn-block compose-mail" href="route('detailLaporan' , id => {{ $temuan->id }})">See getail</a> </td>
                    </tr>
                    @endforeach
                </tbody> --}}

                <thead>
            <tr>
                <th class="col-1" >No</th>
                <th class="text-center col">temuan </th>
                <th class="text-center col-1" >Area </th>
                <th class="text-center col-1" >Kategori Stop-6</th>
                <th class="text-center col-1" >Rank</th>
                <th class="text-center col-1" >Tanggal Laporan</th>
                <th class="text-center col-1" >Due Date</th>
                <th class="text-center col-1" >status </th>
                <th class="text-center col-1" >Assign To</th>
                <th class="text-center col-1" >Action </th>
            </tr>
            </thead>
            <tbody>
                @foreach($temuans as $temuan)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td class="text-center" style="font-size:12px">{{ $temuan->temuan }}</td>
                    <td class="text-center" style="font-size:12px">{{ $temuan->area->name }}</td>
                    <td class="text-center" style="font-size:12px">{{ $temuan->kategori }}</td>
                    <td class="text-center" style="font-size:12px">{{ $temuan->rank }}</td>
                    <td class="text-center" style="font-size:12px">{{ date('d/m/Y', strtotime($temuan->laporan_patrol->tanggal_patrol)) }}</td>
                    <td class="text-center" style="font-size:12px">{{ date('d/m/Y', strtotime($temuan->deadline_date)) }}</td>
                    @if ($temuan->ACC_Dept_Head_EHS_At == null && $temuan->deleted_at !== null)
                        <td class="text-center" style="font-size:12px"><span>Cancel</span></td>
                        <td class="text-center" style="font-size:12px">-</td>
                    @elseif ($temuan->ACC_Dept_Head_PIC_At == null && $temuan->progress < 10.00)
                        @if ($temuan->ACC_Dept_Head_PIC_At == null && $temuan->progress == 0)
                        <td class="text-center" style="font-size:12px"><span @if (strtotime($temuan->deadline_date) < time()) class="pops" @else class="pou" @endif >{{ $temuan->progress }}/10</span><br><span>OPEN</span></td>    
                        @else
                        <td class="text-center" style="font-size:12px"><span @if (strtotime($temuan->deadline_date) < time()) class="pop" @else class="pou" @endif >{{ $temuan->progress }}/10</span><br><span>{{ $temuan->progress * 10 }}%</span></td>
                        @endif
                        <td class="text-center" style="font-size:12px">{{ $temuan->PIC->name }}</td>
                    @elseif ($temuan->ACC_Dept_Head_PIC_At == null && $temuan->progress == 10.00)
                        <td class="text-center" style="font-size:12px"><span class="pou">{{ $temuan->progress }}/10</span><br><span>Waiting Approval</span></td>
                        <td class="text-center" style="font-size:12px">{{ $deptHeadPIC->user->name }}</td>
                    @elseif ($temuan->verify_submit_at == null)
                        <td class="text-center" style="font-size:12px"><span class="pie">{{ $temuan->progress }}/10</span><br><span>Waiting Verify</span></td>
                        <td class="text-center" style="font-size:12px">{{ $temuan->auditor->name }}</td>
                    @elseif ($temuan->ACC_Dept_Head_EHS_At == null && $temuan->progress == 12)
                        <td class="text-center" style="font-size:12px"><span class="fa fa-check text-warning"></span><br><span>Waiting Approval</span></td>
                        <td class="text-center" style="font-size:12px">{{ $deptHeadEHS->name }}</td>
                    @else
                        <td class="text-center" style="font-size:12px"><span class="fa fa-check text-navy"></span><br><span>CLOSED</span></td>
                        <td class="text-center" style="font-size:12px"> - </td>
                    @endif
                    <td class="text-center" style="font-size:12px"><a class="btn btn-info btn-block compose-mail" href="{{ route('detailLaporan', ['id' => $temuan->id]) }}">See Detail</a> </td>
                </tr>
                @endforeach
            </tbody>
        </table>
                </div>
@if($laporan->deleted_at == null)
                @role('PIC')
                @if($PICApproveVisible)
                <div class="row mt-4 mt-sm-0" style="margin-left:0">
                    <div class="col-sm-4 offset-6">
                    </div>
                    <div class="col-sm-6 mx-3 m-sm-0 text-end">
                        <form id="submitForm" method="post" action="{{route('needApproveTemuanPICALL')}}">
                            @csrf
                            <input type="hidden" value="{{ $laporan->id }}" name="patrol_id">
                        <button id="submitButton" class="btn btn-block btn-success compose-mail" type="submit">Kirim email minta approval depthead</button>
                    </form>
                    </div>
                </div>
                @endif
                @endrole

                @role('Departement Head PIC')
                
                @if($verifikasiVisible)
                    <div class="row mt-4 mt-sm-0" style="margin-left:0">
                        @role('Departement Head EHS')
                            @if(auth()->user()->area[0]->area_id == $laporan->area_id && $DeptEHSApproveVisible == true)
                                <div class="col-sm-3 offset-4">
                                </div>
                            @else
                                <div class="col-sm-4 offset-5">
                                </div>
                            @endif
                        @elserole(['EHS', 'Departement Head PIC', 'PIC'])
                            <div class="col-sm-4 offset-5">
                            </div>
                        @endrole
                        
                        <div class="col-sm-6 mx-3 m-sm-0 mb-2 text-end inline">
                            <form id="submitForm" method="post" action="{{route('needVerifikasiEhsAll')}}">
                                @csrf
                                <input type="hidden" value="{{ $laporan->id }}" name="patrol_id">
                            <button id="submitButton" class="btn btn-block btn-success compose-mail" type="submit">Kirim email minta approval EHS</button>
                        </form>
                        </div>

                        @role('Departement Head EHS')
                            @if(auth()->user()->area[0]->area_id == $laporan->area_id && $DeptEHSApproveVisible == false)
                                </div>
                            @endif
                        @elserole(['EHS', 'Departement Head PIC', 'PIC'])
                            </div>
                        @endrole
                @endif
                @endrole
                
                @role('EHS')
                @if($EHSApproveVisible)
                <div class="row mt-4 mt-sm-0" style="margin-left:0">
                    <div class="col-sm-4 offset-6">
                    </div>
                    <div class="col-sm-6 mx-3 m-sm-0 text-end">
                        <form id="submitForm" method="post" action="{{route('needApproveTemuanEhsAll')}}">
                            @csrf
                            <input type="hidden" value="{{ $laporan->id }}" name="patrol_id">
                        <button id="submitButton" class="btn btn-block btn-success compose-mail" type="submit">Kirim email minta approval depthead EHS</button>
                    </form>
                    </div>
                </div>
                @endif
                @endrole

                @role('Departement Head EHS')
                @if($DeptEHSApproveVisible)
                    @if(auth()->user()->area[0]->area_id != $laporan->area_id || $verifikasiVisible == false)
                        <div class="row mt-4 mt-sm-0" style="margin-left:0">
                            <div class="col-sm-4 offset-6">
                            </div>
                    @endif
                            <div class="col-sm-6 mx-3 m-sm-0 text-end">
                                <form id="submitForm" method="post" action="{{route('approveDeptheadEhsAll')}}">
                                    @csrf
                                    <input type="hidden" value="{{ $laporan->id }}" name="patrol_id">
                                <button id="submitButton" class="btn btn-block btn-success compose-mail" type="submit">Kirim email selesai temuan</button>
                            </form>
                            </div>
                        </div>
                @endif
                @endrole
@endif
        </div>
    </div>
    </div>
    </div>

</div>
@endsection