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
            <li class="breadcrumb-item">
                <a>Detail Laporan</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>Detail Temuan</strong>
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
            </div>
            <div class="ibox-content">
                    <div class="form-group row">

                        <label class="col-lg-2 col-form-label">Tanggal Patrol</label>

                        <div class="col-sm-4"><input type="text" disabled="" placeholder="@dateWithDay($laporan->laporan_genba->tanggal_patrol)" class="form-control"></div>
                        
                        <label class="col-sm-2 col-form-label">Group Auditor</label>

                        <div class="col-sm-4"><input type="text" disabled="" placeholder="{{ $laporan->PIC->name }}" class="form-control"></div>
                        
                    </div>
                    
                    <div class="hr-line-dashed"></div>

                    <div class="form-group row">

                        <label class="col-lg-2 col-form-label">Area</label>

                        <div class="col-sm-4"><input type="text" disabled="" placeholder="{{ $laporan->area->name }}" class="form-control"></div>
                        
                        <label class="col-sm-2 col-form-label">PIC</label>

                        <div class="col-sm-4"><input type="text" disabled="" placeholder="{{ $laporan->PIC->name }}" class="form-control"></div>

                    </div>
                    
                    <div class="hr-line-dashed"></div>

                    <div class="form-group row">

                        <label class="col-lg-2 col-form-label">PIC_Auditor</label>

                        <div class="col-sm-4"><input type="text" disabled="" placeholder="{{ $laporan->laporan_genba->PIC_auditor->name }}" class="form-control"></div>

                        <label class="col-sm-2 col-form-label">Status Temuan</label>
                        
                        <div class="col-sm-4"><div class="custom-file">
                            <button class="btn btn-info" data-toggle="modal" data-target="#status_temuan" type="button"><i class="fa fa-paste"></i> Lihat Detail</button>
                        </div>
                    </div>

                    <div class="modal inmodal fade" id="status_temuan" tabindex="-1" role="dialog"  aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                    <h4 class="modal-title">Status Temuan</h4>
                                </div>
                                <div class="modal-body">
                                    <div class="ibox-content">
                                        
                                        <div class="form-group row">
                                            <label class="col-lg-2 col-form-label">Departement Head EHS</label>
                    
                                            <div class="col-sm-4"><input type="text" disabled="" @if($laporan->dept_ehs_id != null )placeholder="{{ $laporan->dept_EHS->name }}"@else placeholder="-" @endif class="form-control"></div>
                    
                                            <label class="col-lg-2 col-form-label">Approved</label>
                    
                                            <div class="col-sm-3"><input type="text" disabled="" @if($laporan->ACC_Dept_Head_EHS_At != null )placeholder="@dateWithDay($laporan->ACC_Dept_Head_EHS_At)"@else placeholder="-" @endif class="form-control"></div>
                                        </div>
                    
                                        <div class="form-group row">
                                            <label class="col-lg-2 col-form-label">Departement Head PIC</label>
                                            <div class="col-sm-4"><input type="text" disabled="" @if($laporan->dept_pic_id != null )placeholder="{{ $laporan->dept_PIC->name }}"@else placeholder="-" @endif 
                                            class="form-control"></div>
                    
                                            <label class="col-lg-2 col-form-label">Approved</label>
                    
                                            <div class="col-sm-3"><input type="text" disabled="" 
                                                @if($laporan->ACC_Dept_Head_PIC_At != null )placeholder="@dateWithDay($laporan->ACC_Dept_Head_PIC_At)"@else placeholder="-" @endif
                                                class="form-control"></div>
                                        </div>
                    
                                </div>
                                </div>

                                <div class="modal-footer">
                                    
                                    <button type="submit" class="btn btn-white" data-dismiss="modal">Close</button>
                                    
                                </div>
                            </div>
                        </div>
                    </div>

                    </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="ibox ">
            <div class="ibox-title bg-info">
                <h5>Analysis (5W+1H) & 4M</h5>
            </div>
            <div class="ibox-content">

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Man</label>

                    <div class="col-sm-4"><input type="text" class="form-control" name="man" value="{{ $laporan->analisis->man }}" disabled></div>
                    
                    <label class="col-sm-2 col-form-label">material</label>

                    <div class="col-sm-4"><input type="text" class="form-control" name="material" value="{{ $laporan->analisis->material }}" disabled ></div>
                </div>
                
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Machine</label>

                    <div class="col-sm-4"><input type="text" class="form-control" name="machine" value="{{ $laporan->analisis->machine }}" disabled></div>

                    <label class="col-sm-2 col-form-label">Methode</label>

                    <div class="col-sm-4"><input type="text" class="form-control" name="methode" value="{{ $laporan->analisis->methode }}" disabled></div>
                </div>

                <div class="hr-line-dashed"></div>
                
                <div class="form-group row"><label class="col-sm-2 col-form-label">What</label>

                    <div class="col-sm-10"><input type="text" class="form-control" name="what" value="{{ $laporan->analisis->what }}" disabled></div>
                </div>
                <div class="form-group row"><label class="col-sm-2 col-form-label">Where</label>

                    <div class="col-sm-10"><input type="text" class="form-control" name="where" value="{{ $laporan->analisis->where }}" disabled></div>
                </div>
                <div class="form-group row"><label class="col-sm-2 col-form-label">When</label>

                    <div class="col-sm-10"><input type="text" class="form-control" name="when" value="{{ $laporan->analisis->when }}" disabled></div>
                </div>
                <div class="form-group row"><label class="col-sm-2 col-form-label">Why</label>

                    <div class="col-sm-10"><input type="text" class="form-control" name="why" value="{{ $laporan->analisis->why }}" disabled></div>
                </div>
                <div class="form-group row"><label class="col-sm-2 col-form-label">Who</label>

                    <div class="col-sm-10"><input type="text" class="form-control" name="who" value="{{ $laporan->analisis->who }}" disabled></div>
                </div>
                <div class="form-group row"><label class="col-sm-2 col-form-label">How</label>

                    <div class="col-sm-10"><input type="text" class="form-control" name="how" value="{{ $laporan->analisis->how }}" disabled></div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Foto Temuan</label>

                    <div class="col-sm-4"><div class="custom-file">
                        <button class="btn btn-info" data-toggle="modal" data-target="#myModal4" type="button"><i class="fa fa-paste"></i> Lihat Foto</button>
                        </div>
                    </div>

                    <div class="modal inmodal" id="myModal4" tabindex="-1" role="dialog"  aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content animated fadeIn">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                    <h4 class="modal-title">Bukti Foto</h4>
                                    <small>Foto dibuat pada tanggal {{ $laporan->created_at }} oleh {{ $laporan->auditor->name }}</small>
                                </div>
                                <div class="modal-body" style="overflow: hidden;">
                                    <div class="ibox-content no-padding border-left-right">
                                        <img alt="image" class="img-fluid" src="{{ asset('gambar/foto_temuan/'.$laporan->foto_temuan) }}" style="width: 100%; height: 100%; object-fit: cover;">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="hr-line-dashed"></div>

                <div class="form-group row">

                <label class="col-lg-2 col-form-label">Kategori</label>

                        <div class="col-sm-4"><input type="text" disabled="" placeholder="{{ $laporan->kategori }}" class="form-control"></div>
                        
                        <label class="col-sm-2 col-form-label">RANK</label>

                        <div class="col-sm-4"><input type="text" disabled="" placeholder="{{ $laporan->rank }}" class="form-control"></div>
                </div>

                <div class="form-group row">

                    <label class="col-lg-2 col-form-label">Due Date</label>

                    <div class="col-sm-4"><input type="text" disabled="" placeholder= "@dateWithDay($laporan->deadline_date)" class="form-control"></div>
                </div>

            </div>
        </div>
    </div>
</div>

       

<div class="row">
    <div class="col-lg-12">
        <div class="ibox ">
            <div class="ibox-title bg-info">
                <h5>Data Penangulangan</h5>
            </div>
            <div class="ibox-content">
                @if($laporan->PIC_submit_at != null)

                    <div class="form-group row">

                        <label class="col-lg-2 col-form-label">Catatan Perbaikan Sementara</label>

                        <div class="col-sm-10"><textarea type="text" disabled="" placeholder="{{ $laporan->temporary_solution }}" class="form-control"></textarea></div>

                    </div>

                @endif

@if($laporan->penanggulangan != null)

                    <div class="form-group row">

                        <label class="col-lg-2 col-form-label">Penanggulangan </label>

                        <div class="col-sm-10"><textarea type="text" disabled="" placeholder="{{ $laporan->penanggulangan }}" class="form-control"></textarea></div>

                    </div>

@endif

@if($laporan->alasan_penolakan != null)
<div class="hr-line-dashed"></div>

                    <div class="form-group row">

                        <label class="col-lg-2 col-form-label">Catatan Perbaikan Lanjutan</label>

                        <div class="col-sm-10 has-error"><textarea style="border: 3px solid red; margin: 2px;" type="text" disabled="" placeholder="{{ $laporan->alasan_penolakan }}" class="form-control"></textarea></div>

                    </div>

@endif
                    <div class="form-group row">

                        <label class="col-lg-2 col-form-label">Progress</label>
                        <div class="col-sm-10 mt-1">
                            <div class="progress progress-mini">
                                <div style="width: {{ ($laporan->progress * 10) }}%;" class="progress-bar"></div>
                            </div>
                            @if($laporan->progress <= 10) 
                            <div class="mt-2">{{ ($laporan->progress * 10) }}%</div>
                            @else 
                            <div class="mt-2">{{ (10 * 10) }}%</div>
                            @endif
                        </div>
                    </div>
                    <div class="hr-line-dashed"></div>

                    <div class="form-group row">
                        <label class="col-lg-2 col-form-label">Tanggal Penanggulangan</label>

                        <div class="col-sm-4"><input type="text" disabled="" placeholder= "@if($laporan->PIC_submit_at != null)@dateWithDay($laporan->PIC_submit_at)
                                                                                            @else {{'-'}} @endif"  
                        class="form-control"></div>

                        <label class="col-lg-2 col-form-label">Verified Date</label>

                        <div class="col-sm-4"><input type="text" disabled="" 
                            placeholder= "@if($laporan->verify_submit_at != null) @dateWithDay($laporan->verify_submit_at)
                            @else {{ '-' }} @endif" 
                            class="form-control"></div>
                    </div>

                    <div class="hr-line-dashed"></div>

                    <div class="form-group row">

    @if($laporan->foto_penanggulangan != null)

                        <label class="col-sm-2 col-form-label">Gambar Perbaikan</label>

                        <div class="col-sm-4"><div class="custom-file">
                            <button class="btn btn-info" data-toggle="modal" data-target="#gambar_penanggulangan" type="button"><i class="fa fa-paste"></i> Lihat Gambar</button>
                            </div>
                        </div>

                        <div class="modal inmodal" id="gambar_penanggulangan" tabindex="-1" role="dialog"  aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content animated fadeIn">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                        <h4 class="modal-title">Bukti Gambar</h4>
                                        <small>Penanggulangan berupa {{ $laporan->penanggulangan }} yang dikerjakan oleh {{ $laporan->PIC->name }} pada tanggal {{ $laporan->PIC_submit_at }}</small>
                                    </div>
                                    <div class="modal-body" style="overflow: hidden;">
                                        <div class="ibox-content no-padding border-left-right">
                                            <img alt="image" class="img-fluid" src="{{ asset('gambar/foto_penanggulangan/'.$laporan->foto_penanggulangan) }}" style="width: 100%; height: 100%; object-fit: cover;">
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
    @endif

                    </div>


                    <div class="form-group row">

                        <div class="col-sm-4 col-sm-offset-2 col-6">
                            {{-- genba  --}}
                                @if($laporan->verify_submit_at == null)
                                    @if(auth()->user()->id == $laporan->auditor_id || auth()->user()->getRoleNames()[0] == "Departement Head EHS" ||  auth()->user()->getRoleNames()[0] == "EHS" )
                                        @if($laporan->progress < 10) 
                            
                                            <form action="/hapus-laporan" method="post" class="inline">
                                                @csrf
                                                <input type="hidden" name="id" value={{ $laporan->id }}>
                                                <button class="btn btn-danger btn-sm" type="submit">Hapus</button>
                                                </form>
                                                <a class="btn btn-warning btn-sm" href="/genba/laporan/temuan/edit/{{ $laporan->id }}" type="submit">Edit</a>
                                        @elseif($laporan->progress >= 10)
                                            @role('EHS')
                                                @if($laporan->ACC_Dept_Head_PIC_At !== null)
                                                    <a class="btn btn-danger btn-sm text-white" href="/tolak-laporan/{{$laporan->id}}">Tolak</a>
                                                    <form action="/verify-laporan" method="post" class="inline">
                                                        @csrf
                                                        <input type="hidden" name="laporan_id" value={{ $laporan->id }}>
                                                    <button class="btn btn-primary btn-sm" href="/editform/{{ $laporan->id }}" type="submit">Verifikasi</button>
                                                    </form>
                                                @endif
                                            @endrole
            
                                        @endif
                                    @endif
                                @endif

                            @role('Departement Head EHS')
                            @if ($laporan->ACC_Dept_Head_PIC_At !== null && $laporan->ACC_Dept_Head_EHS_At == null)
                                <a class="btn btn-danger btn-sm text-white" href="/tolak-laporan/{{$laporan->id}}">Tolak</a>
                                @if($laporan->verify_submit_at !== null && $laporan->progress >= 10)
                                    <form action="/Dept.Head.EHS/Submit" method="post" class="inline">
                                        @csrf
                                        <input type="hidden" name="laporan_id" value={{ $laporan->id }}>
                                    <button class="btn btn-primary btn-sm" type="submit">Approve</button>
                                @endif
                            @endif
                            @endrole


                            @role('PIC')
                            @if(auth()->user()->id == $laporan->PIC_id)
                            <a class="btn btn-primary btn-sm" href="/laporan_penanggulangan/{{ $laporan->id }}" type="submit">Update Perbaikan</a>
                            @endif
                            @elserole('Departement Head PIC')
                            @if($laporan->progress == 10 && $laporan->ACC_Dept_Head_PIC_At == null)
                            <a class="btn btn-danger btn-sm text-white" href="/tolak-laporan/{{$laporan->id}}">Tolak</a>
                            <form action="/Dept.Head.PIC/Submit" method="post" class="inline">
                                @csrf
                                <input type="hidden" name="id" value={{ $laporan->id }}>

                            <button class="btn btn-primary btn-sm" type="submit">Approve</button>
                            @elseif ($laporan->progress < 10)
                            <a class="btn btn-primary btn-sm" href="/laporan_penanggulangan/{{ $laporan->id }}" type="submit">Update Perbaikan</a>
                            @endif
                            @endrole
                        </div> 
                        <div class="col-sm-8 col-6">
                            <div class="float-right"> 
                                <a class="btn btn-info btn-sm" href="/genba/laporan/{{ $laporan->genba_id }}" type="submit">Lihat Laporan Genba</a>
                            </div>
                        </div>
                    </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection