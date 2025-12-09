@extends('component.navbar')

@section('content')

@include('component.message')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Management Patrol</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a>Management Patrol</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>Detail Laporan</strong>
            </li>
        </ol>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
<div class="row">
    <div class="col-lg-12">
        <div class="ibox ">
            <div class="ibox-title bg-info">
                <h5>Data Genba</h5>
                @if(auth()->user()->roles[0]->name == "EHS")
                <div class="ibox-tools">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-wrench" style="color:white"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="/genba/schedule/edit/{{ $genba->id }}" class="dropdown-item">Edit Data</a>
                        </li>
                    </ul>
                </div>
                @endif
            </div>
            <div class="ibox-content">
                    <div class="form-group row">
                        
                        <label class="col-lg-2 col-form-label">Area</label>

                        <div class="col-sm-4"><input type="text" disabled="" placeholder="{{ $genba->genba_area->name }}" class="form-control"></div>
                        
                        <label class="col-sm-2 col-form-label">PIC</label>

                        <div class="col-sm-4"><input type="text" disabled="" placeholder="{{ $genba->PIC_auditor->name }}" class="form-control"></div>
                    </div>

                    <div class="hr-line-dashed"></div>

                    <div class="form-group row">
                        <label class="col-lg-2 col-form-label">Tanggal Genba</label>

                        <div class="col-sm-4"><input type="text" disabled="" placeholder="@dateWithDay($genba->tanggal_patrol)" class="form-control"></div>

                        <label class="col-lg-2 col-form-label">Nama Team</label>

                        <div class="col-sm-4"><input type="text" disabled="" placeholder="{{ $genba->team->name }}" class="form-control"></div>
                    </div>
                    <div class="hr-line-dashed"></div>
                    <div class="form-group row">
                        <label class="col-lg-2 col-form-label">Hasil Penilaian</label>

                        <div class="col-sm-4"><input type="text" disabled="" placeholder="{{ $total_nilai }}" class="form-control"></div>

                        <label class="col-lg-2 col-form-label">Status Nilai</label>

                        <div class="col-sm-4"><input type="text" disabled="" @if($total_nilai >= 25)placeholder="Sangat Baik" @elseif ($total_nilai >= 19) placeholder="Baik" @elseif ($total_nilai >= 10)  placeholder="Kurang Baik" @else placeholder="Progress" @endif class="form-control"></div>
                    </div>

                </div> 
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title bg-info">
                    <h5>Temuan Genba</h5>
                </div>
            <div class="ibox-content">
                <div class="row my-4" style="margin-left:0">
                    <div class="col-2 @if($exportVisible) offset-6 @else offset-8 @endif">
                        
                    </div>
                    <div class="col-sm-2 offset-sm-10 m-3 m-sm-0 text-end">
                        @foreach($genba->detail as $member)
                            @if($member->user_id == auth()->user()->id)
                        <a class="btn btn-block btn-primary compose-mail" href="/genba/laporan/createTemuan/{{ $genba->id }}">Tambah Temuan</a>
                            @endif
                        @endforeach
                    </div>
                    @if($exportVisible)
                    <div class="col-sm-2 mx-3 m-sm-0 text-end">
                        <form action="/genba_export" method="post">
                            @csrf 
                        <input type="hidden" value="{{ $genba->id }}" name="genba_id">
                        <button class="btn btn-block btn-info compose-mail" type="submit">Export laporan</button>
                    </form>
                    </div>
                    @endif
                </div>
        <div class="table-responsive mt-3">
        <table class="table table-striped">
            <thead>
            <tr>
                <th>No</th>
                <th class="text-center">Rank</th>
                <th class="text-center">Kategori</th>
                <th class="text-center">Deadline</th>
                <th class="text-center">status</th>
                <th class="text-center">Action</th>
            </tr>
            </thead>
            <tbody>
                @foreach($temuans as $temuan)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td class="text-center">{{ $temuan->rank }}</td>
                    <td class="text-center">{{ $temuan->kategori }}</td>
                    <td class="text-center">{{ $temuan->deadline_date }}</td>

                    @if($temuan->ACC_Dept_Head_PIC_At == null && $temuan->progress >= 10.00) 
                        <td class="text-center"><span class="pou">10/10</span></td>
                    @elseif ($temuan->verify_submit_at == null)
                        <td class="text-center"><span class="pie">{{ $temuan->progress }}/10</span></td>
                    @elseif ($temuan->ACC_Dept_Head_EHS_At == null && $temuan->progress > 10)
                        <td class="text-center"><span class="fa fa-check text-warning"></span></td>
                    @else
                    <td class="text-center"><span class="fa fa-check text-navy"></span></td>                       
                    @endif
                    
                    <td class="text-center" class="text-center"><a class="btn btn-info" href="/genba/laporan/temuan/{{ $temuan->id }}">See Detail</a> </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        </div>
        </div>
    </div>
    </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title bg-info">
                    <h5>Penilaian Genba</h5>
                </div>
            <div class="ibox-content">
    <div class="table-responsive mt-3">
        <table class="table table-striped">
            <thead>
            <tr>
                <th>No</th>
                <th class="text-center">Nama</th>
                <th class="text-center">Departement</th>
                <th class="text-center">Position</th>
                <th class="text-center">Nilai</th>
                <th class="col-sm-1 text-center">PIC Auditor</th>
                <th class="text-center">Action</th>
                
            </tr>
            </thead>
            <tbody>
                @foreach($genba->detail as $member)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td class="text-center">{{ $member->genba_member->name }}</td>
                <td class="text-center">{{ $member->genba_member->detail->name }}</td>
                <td class="text-center">{{ $member->genba_member->position->position }}</td>
                <td class="text-center">
                    @if($member->genba_nilai != null)
                {{ 
                (($member->genba_nilai->pertanyaan_1 + 
                $member->genba_nilai->pertanyaan_2 + 
                $member->genba_nilai->pertanyaan_3 + 
                $member->genba_nilai->pertanyaan_4 + 
                $member->genba_nilai->pertanyaan_5 + 
                $member->genba_nilai->pertanyaan_6 + 
                $member->genba_nilai->pertanyaan_7 + 
                $member->genba_nilai->pertanyaan_8 + 
                $member->genba_nilai->pertanyaan_9 + 
                $member->genba_nilai->pertanyaan_10))}}
                @else 
                -
                    @endif
                </td>
                <td class="text-center">
                    <div class="i-checks"><input type="checkbox" value="" disabled @if($member->detail->pic_auditor_id == $member->user_id) checked @endif></div>
                </td>

                @if($member->genba_member->name != auth()->user()->name)
                    @if($member->genba_nilai != null)
                        <td class="text-center"><a class="btn btn-info" href="/genba/laporan/{{ $member->genba_id }}/penilaian/detail/{{ $member->genba_nilai->id }}">See Detail</a> </td>
                    @else
                        <td class="text-center">Belum Membuat penilaian</td>
                    @endif
                @else
                    @if($member->genba_nilai == null)
                        <td class="text-center"><a class="btn btn-primary" href="/genba/laporan/{{ $member->genba_id }}/penilaian/{{ $member->id }}">buat penilaian</a> </td>
                    @else
                        <td class="text-center"><a class="btn btn-info" href="/genba/laporan/{{ $member->genba_id }}/penilaian/detail/{{ $member->genba_nilai->id }}">See Detail</a> </td>
                    @endif
                @endif
            </tr>
            @endforeach                   
            </tbody>
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