@extends('component.navbar')
 
 
@section('content')
 
 
@include('component.message')
 
 
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>EHS Patrol</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{url('patrolEHS')}}">Table EHS Patrol</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{url('patrolEHS/'.$laporan->laporan_patrol->id)}}" >Detail Laporan</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>Detail Temuan</strong>
            </li>
        </ol>
    </div>
</div>
 
 
<div class="form-group row">
 
 
    <div class="modal inmodal" id="myModal4" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content animated fadeIn">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title">Foto Temuan</h4>
                    <small>Foto dibuat pada tanggal @dateWithDay($laporan->created_at) oleh {{ $laporan->auditor->name }}</small>
                </div>
                <div class="modal-body" style="overflow: hidden;">
                    <div id="image-to-rotate1" class="ibox-content no-padding border-left-right">
                        @if($laporan->foto_temuan)
                            @if(filter_var($laporan->foto_temuan, FILTER_VALIDATE_URL) && preg_match('/drive\.google\.com\/(?:file\/d\/|open\?id=)(.+?)(?:\/view|$)/', $laporan->foto_temuan, $matches))
                                <br>
                                <a href="{{ $laporan->foto_temuan }}" target="_blank" class="btn btn-info btn-sm mt-2">Lihat di Google Drive</a>
                            @elseif(filter_var($laporan->foto_temuan, FILTER_VALIDATE_URL))
                                <p>Link tidak valid: <a href="{{ $laporan->foto_temuan }}" target="_blank">{{ $laporan->foto_temuan }}</a></p>
                            @else
                                <img alt="image" class="img-fluid" src="{{ asset('gambar/foto_temuan/'.$laporan->foto_temuan) }}" style="width: 100%; height: 100%; object-fit: cover;">
                            @endif
                        @else
                            <p>Tidak ada foto temuan</p>
                        @endif
                    </div>
                </div>
                <div class="modal-footer">
                    <button id="rotate-button1" class="btn btn-white"><i class="fa fa-repeat" aria-hidden="true"></i></button>
                    <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
 
 
 
 
    <div class="modal inmodal" id="gambar_penanggulangan" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content animated fadeIn">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title">Foto Penanggulangan</h4>
                    <small>Penanggulangan berupa {{ $laporan->penanggulangan }} yang dikerjakan oleh {{ $laporan->PIC->name }} pada tanggal @dateWithDay($laporan->PIC_submit_at)</small>
                </div>
                <div class="modal-body" style="overflow: hidden;">
                    <div id="image-to-rotate2" class="ibox-content no-padding border-left-right">
                        <img alt="image" class="img-fluid" src="{{ asset('gambar/foto_penanggulangan/'.$laporan->foto_penanggulangan) }}" style="width: 100%; height: 100%; object-fit: cover;">
                    </div>
                </div>
                <div class="modal-footer">
                    <button id="rotate-button2" class="btn btn-white"><i class="fa fa-repeat" aria-hidden="true"></i></button>
                    <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
 
 
    <div class="modal inmodal" id="info_kategori" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content animated fadeIn">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title"><strong>Keterangan Kategori STOP-6:</strong></h4>
                </div>
                <div class="modal-body" style="overflow: hidden;">
 
                                    <div id="stop6Categories" class="pl-2">
                                        <p><strong>5R</strong>: Ringkas, Rapi, Resik, Rawat & Rajin</p>
                                        <p><strong>A</strong>: Apparatus (Terjepit, terdampak Mesin)</p>
                                        <p><strong>B</strong>: Big Heavy (Tertimpa, terbentur benda berat)</p>
                                        <p><strong>C</strong>: Car (Tertabrak kendaraan bermotor)</p>
                                        <p><strong>D</strong>: Drop (Jatuh dari ketinggian)</p>
                                        <p><strong>E</strong>: Electricity (Terkena sengatan listrik)</p>
                                        <p><strong>F</strong>: Fire (Kebakaran atau terkait panas)</p>
                                        <p><strong>G</strong>: Green Hazard (Pencemaran)</p>
                                        <p><strong>O</strong>: Other (Selain kategori A, B, C, D, E, F, G)</p>
                                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal inmodal" id="info_rank" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content animated fadeIn">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title"><strong>Keterangan Rank:</strong></h4>
                </div>
                <div class="modal-body" style="overflow: hidden;">
 
                    <div id="rankCategories" class="pl-2">
                        <p><strong>Rank A</strong>: Kecelakaan berat yang menyebabkan cacat tetap atau
                            meninggal dunia</p>
                        <p><strong>Rank B</strong>: Kecelakaan sedang yang menyebabkan kehilangan hari kerja
                            / cacat sementara</p>
                        <p><strong>Rank C</strong>: Kecelakaan ringan/ penanganan P3K dan tidak menyebabkan
                            kehilangan hari kerja</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
 
    <div class="modal inmodal" id="info_progress" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content animated fadeIn">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h5 class="modal-title"><strong>Keterangan Progress :</strong></h5>
                </div>
                <div class="modal-body" style="overflow: hidden;">
 
                    <div id="noteProgress" class="pl-2">
                        <p><strong>0%</strong> Belum ada perbaikan</p>
                        <p><strong>25%</strong> Sedang Proses Perbaikan</p>
                        <p><strong>50%</strong> Telah selesai dilakukan Perbaikan</p>
                        <p><strong>75%</strong> Telah selesai dilakukan Perbaikan namun belum efektif
                            diimplementasikan</p>
                        <p><strong>100%</strong> Telah selesai dilakukan Perbaikan dan diimplementasikan dengan
                            efektif</p>
 
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal inmodal" id="req_duedate_lanjutan" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content animated fadeIn">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span
                                aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <h4 class="modal-title"><strong>Request Due Date Lanjutan</strong></h4>
                    </div>
                    <div class="modal-body" style="overflow: hidden;">
                        <form action="{{ route('requestDueDateLanjutan', ['id' => $laporan->id]) }}" class="bg-white p-3">
                            <div class="form-group row justify-content-center"><label
                                    class="col-sm-10 col-form-label">Alasan :</label>
                                <div class="col-sm-10"><input type="text" class="form-control"
                                        name="alasan_due_date_lanjutan" required></div>
                            </div>
                            <div class="form-group row justify-content-center">
                                <label class="col-sm-10  form-label">Request Due Date Lanjutan</label>
                                <div class="col-sm-10 " id="data_7">
                                    <div class="input-group date">
                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input
                                            type="text" class="form-control" name="tanggal_request_due_date_lanjutan"
                                            value="@dateWithDay($laporan->deadline_date)">
                                    </div>
                                </div>
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary">Kirim Request Due Date Lanjutan</button>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-white" data-dismiss="modal">Batal</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal inmodal" id="konfirmasi_req_duedate_lanjutan" tabindex="-1" role="dialog"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content animated fadeIn">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span
                                aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <h4 class="modal-title"><strong>Request Due Date Lanjutan</strong></h4>
                    </div>
                    <div class="modal-body" style="overflow: hidden;">
                        <div class="form-group row justify-content-center"><label class="col-sm-10 col-form-label">Alasan
                                :</label>
                            <div class="col-sm-10"><input type="text" class="form-control"
                                    name="alasan_due_date_lanjutan" value="{{ $laporan->alasan_due_date_lanjutan }}">
                            </div>
                        </div>
                        <div class="form-group row justify-content-center"><label class="col-sm-10 col-form-label">Request
                                DUE DATE LANJUTAN :</label>
                            <div class="col-sm-10"><input type="text" class="form-control"
                                    name="alasan_due_date_lanjutan"
                                    value="{{ $laporan->tanggal_request_due_date_lanjutan }}"></div>
                        </div>
                        <div class="text-center">
                            <a class="btn btn-primary"
                                href="{{ route('konfirmasiDueDateLanjutan', ['id' => $laporan->id, 'status' => 'acc']) }}">Approve</a>
                            <a class="btn btn-danger"
                                href="{{ route('konfirmasiDueDateLanjutan', ['id' => $laporan->id, 'status' => 'tolak']) }}">Tolak</a>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-white" data-dismiss="modal">Batal</button>
                    </div>
                </div>
            </div>
        </div>
 
</div>
 
 
 
 
<div class="wrapper wrapper-content animated fadeInRight">
<div class="row">
    <div class="col-lg-12">
        <div class="ibox ">
            <div class="ibox-title bg-info">
                <h5>Form Data</h5>
                {{-- <div class="ibox-tools">
                    <a class="" href="http://www.google.com">
                        <i class="fa fa-exclamation-circle" style="color:white"></i>
                    </a>
                </div> --}}
            </div>
            <div class="ibox-content">
                    <div class="form-group row">
                        <label class="col-lg-2 col-form-label">Tanggal Patrol</label>
 
 
                        <div class="col-sm-4"><input type="text" disabled="" placeholder="@dateWithDay($laporan->laporan_patrol->tanggal_patrol)" class="form-control"></div>
 
                        <label class="col-sm-1 col-form-label">Nama EHS</label>
 
 
                        <div class="col-sm-4"><input type="text" disabled="" placeholder="{{ $laporan->auditor->name }}" class="form-control"></div>
 
 
                    </div>
 
 
                    <div class="form-group row">
                        <label class="col-lg-2 col-form-label">Area</label>
 
 
                        <div class="col-sm-4"><input type="text" disabled="" placeholder="{{ $laporan->area->name }}" class="form-control"></div>
 
                        <label class="col-sm-1 col-form-label">PIC</label>
 
                        <div class="col-sm-4"><input type="text" disabled="" placeholder="{{ $laporan->PIC->name }}" class="form-control"></div>
 
                    </div>
                    @if ($laporan->wo != null)
 
 
                    <div class="form-group row mt-4">
                        <label class="col-lg-2 col-form-label">Need Support</label>
 
 
                        <div class="col-sm-4"><input type="text" disabled="" placeholder="{{ $laporan->wo }}" class="form-control"></div>
 
 
                        <label class="col-lg-1 col-form-label">No.WO</label>
 
 
                        <div class="col-sm-4 "><input type="text" disabled="" placeholder="{{ $laporan->noWO }}" class="form-control"></div>
 
                    </div>
                    @endif
 
 
                    <div class="hr-line-dashed"></div>
 
                    <div class="form-group row" >
 
                        <label class="col-lg-2 col-form-label">Temuan</label>
 
                        <div class="col-sm-9"><textarea style="height:100px" type="text" disabled="" placeholder="{{ $laporan->temuan }}" class="form-control"></textarea></div>
 
                    </div>
 
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Foto Temuan</label>
 
                        <div class="col-sm-4"><div class="custom-file">
                            <button class="btn btn-info" data-toggle="modal" data-target="#myModal4" type="button"><i class="fa fa-paste"></i> Lihat Foto</button>
                        </div>
                    </div>
                </div>
 
                <div class="hr-line-dashed"></div>
                <div class="form-group row">
                        <label class="col-lg-2 col-form-label">Kategori <span class="btn btn-sm btn-info" data-toggle="modal" data-target="#info_kategori"><i class="fa fa-question-circle"></i></span></label>
 
 
                        <div class="col-sm-4"><input type="text" disabled="" placeholder="{{ $laporan->kategori }}" class="form-control"></div>
 
                        <label class="col-sm-1 col-form-label pr-0">RANK <span class="btn btn-sm btn-info" data-toggle="modal" data-target="#info_rank"><i class="fa fa-question-circle"></i></span></label>
 
 
                        <div class="col-sm-4"><input type="text" disabled="" placeholder="{{ $laporan->rank }}" class="form-control"></div>
 
                    </div>
                    <div class="form-group row align-items-center">
 
                        <label class="col-lg-2 col-form-label">Due Date</label>
 
 
                        <div class="col-sm-4"><input type="text" disabled="" placeholder= "@dateWithDay($laporan->deadline_date_awal)" class="form-control"></div>
 
                        @if ($laporan->deadline_date_awal !== $laporan->deadline_date)
                            <label class="col-lg-1 col-form-label col-form-label" style="font-size: 0.7rem;">Due Date Lanjutan</label>
                            <div class="col-sm-4"><input type="text" disabled="" placeholder= "@dateWithDay($laporan->deadline_date)" class="form-control"></div>
                        @endif
 
 
 
 
                    </div>
 
 
                    <div class="hr-line-dashed"></div>
 
 
                    @if($laporan->alasan_penolakan != null)
 
 
                    <div class="form-group row">
 
 
                        <label class="col-lg-2 col-form-label">Catatan Perbaikan Lanjutan</label>
 
 
                        <div class="col-sm-9"><textarea style="border: 3px solid red; margin: 2px;" type="text" disabled="" placeholder="{{ $laporan->alasan_penolakan }}" class="form-control"></textarea></div>
 
 
                    </div>
 
 
@endif
 
 
@if($laporan->penanggulangan != null)
 
 
                    <div class="form-group row">
 
 
                        <label class="col-lg-2 col-form-label">Penanggulangan</label>
 
 
                        <div class="col-sm-9"><textarea style="height:100px" type="text" disabled="" placeholder="{{ $laporan->penanggulangan }}" class="form-control"></textarea></div>
 
 
                    </div>
 
 
@endif
 
 
                @if($laporan->foto_penanggulangan != null)
                <div class="form-group row">
                <label class="col-sm-2 col-form-label">Foto Penanggulangan</label>
 
 
                <div class="col-sm-4">
                    <div class="custom-file">
                    <button class="btn btn-info" data-toggle="modal" data-target="#gambar_penanggulangan" type="button"><i class="fa fa-paste"></i> Lihat Foto</button>
                    </div>
                </div>
                </div>
                @endif
                    <div class="form-group row">
 
 
                        <label class="col-lg-2 col-form-label">Progress <span class="btn btn-sm btn-info" data-toggle="modal" data-target="#info_progress"><i class="fa fa-question-circle"></i></span></label>
                        <div class="col-sm-9 mt-1">
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
 
 
                        <div class="col-sm-3"><input type="text" disabled=""
                            placeholder= "@if($laporan->verify_submit_at != null) @dateWithDay($laporan->verify_submit_at)
                            @else {{ '-' }} @endif"
                            class="form-control"></div>
                    </div>
 
 
                    <div class="hr-line-dashed"></div>
                    <div class="form-group row">
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
                                            <label class="col-lg-2 col-form-label">PIC </label>
                                            <div class="col-sm-4"><input type="text" disabled="" @if($laporan->PIC_id != null )placeholder="{{ $laporan->PIC->name }}"@else placeholder="-" @endif
                                            class="form-control"></div>
 
                                            <label class="col-lg-2 col-form-label">Submited</label>
 
                                            <div class="col-sm-3"><input type="text" disabled=""
                                                @if($laporan->PIC_submit_at != null )placeholder="@dateWithDay($laporan->PIC_submit_at)"@else placeholder="-" @endif
                                                class="form-control"></div>
                                        </div>
 
 
 
 
                                        <div class="form-group row">
                                            <label class="col-lg-2 col-form-label">Department Head PIC</label>
                                            <div class="col-sm-4"><input type="text" disabled="" @if($laporan->dept_pic_id != null )placeholder="{{ $laporan->dept_PIC->name }}"@else placeholder="-" @endif
                                            class="form-control"></div>
 
                                            <label class="col-lg-2 col-form-label">Approved</label>
 
                                            <div class="col-sm-3"><input type="text" disabled=""
                                                @if($laporan->ACC_Dept_Head_PIC_At != null )placeholder="@dateWithDay($laporan->ACC_Dept_Head_PIC_At)"@else placeholder="-" @endif
                                                class="form-control"></div>
                                        </div>
 
 
 
 
                                        <div class="form-group row">
                                            <label class="col-lg-2 col-form-label">EHS</label>
                                            <div class="col-sm-4"><input type="text" disabled="" @if($laporan->verify_submit_at != null )placeholder="{{ $laporan->auditor->name }}"@else placeholder="-" @endif
                                            class="form-control"></div>
 
                                            <label class="col-lg-2 col-form-label">Verify</label>
 
                                            <div class="col-sm-3"><input type="text" disabled=""
                                                @if($laporan->verify_submit_at != null )placeholder="@dateWithDay($laporan->verify_submit_at)"@else placeholder="-" @endif
                                                class="form-control"></div>
                                        </div>
 
 
 
 
                                        <div class="form-group row">
                                            <label class="col-lg-2 col-form-label">Department Head EHS</label>
 
                                            <div class="col-sm-4"><input type="text" disabled="" @if($laporan->dept_ehs_id != null )placeholder="{{ $laporan->dept_EHS->name }}"@else placeholder="-" @endif class="form-control"></div>
 
                                            <label class="col-lg-2 col-form-label">Approved</label>
 
                                            <div class="col-sm-3"><input type="text" disabled="" @if($laporan->ACC_Dept_Head_EHS_At != null )placeholder="@dateWithDay($laporan->ACC_Dept_Head_EHS_At)"@else placeholder="-" @endif class="form-control"></div>
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
 
 
                    <div class="hr-line-dashed"></div>
 
 
                    <div class="form-group row">
 
 
 
 
 
 
                        {{-- Pembagian tugas masing masing role --}}
 
 
 
 
 
 
                        <div class="col-7 col-sm-8 col-lg-9 col-sm-offset-2">
                            @if($laporan->deleted_at == null && $laporan->laporan_patrol->deleted_at == null)
                                @if($laporan->progress < 10)
 
 
                                    @role(['EHS', 'Departement Head EHS'])
                                        <form id="submitForm" action="{{url('hapus-laporan')}}" method="post" class="inline">
                                            @csrf
                                            <input type="hidden" name="id" value={{ $laporan->id }}>
                                        <button class="btn btn-danger btn-sm" id="submitButton" type="submit">Cancel</button>
                                        </form>
 
                                        <a class="btn btn-warning btn-sm" href="{{url('editForm', ['id' => $laporan->id])}}" type="submit">Edit</a>
                                        @if ($laporan->deadline_date_awal === $laporan->deadline_date && $laporan->tanggal_request_due_date_lanjutan != null && auth()->user()->hasRole('EHS'))
                                                <span class="btn btn-info btn-sm" data-toggle="modal"
                                                    data-target="#konfirmasi_req_duedate_lanjutan">Konfirmasi Request Due Date
                                                    Lanjutan</span>
                                            @endif
                                    @endrole
 
 
                                    @role(['PIC', 'Departement Head PIC'])
                                    @foreach($laporan->area->area as $DeptPIC)
                                            @if($DeptPIC->user_id == auth()->user()->id)
                                                <a class="btn btn-primary btn-sm" href="{{url('laporan_penanggulangan/'.$laporan->id)}}" type="submit">Update Perbaikan</a>
                                                @if ($laporan->deadline_date_awal === $laporan->deadline_date && $laporan->alasan_due_date_lanjutan != 'tolak' )
                                                        @if ($laporan->tanggal_request_due_date_lanjutan == null)
                                                            <span class="btn btn-danger btn-sm" data-toggle="modal"
                                                                data-target="#req_duedate_lanjutan">Request Due Date
                                                                Lanjutan</span>
                                                        @else
                                                            <span class="btn btn-danger btn-sm">Menunggu Konfirmasi Request Due
                                                                Date Lanjutan</span>
                                                        @endif
                                                    @endif
                                        @endif
                                    @endforeach
                                    @endrole
 
 
                                @elseif($laporan->progress == 10 && $laporan->ACC_Dept_Head_PIC_At == null )
 
 
                                    @role('PIC')
 
                                        @foreach($laporan->area->area as $DeptPIC)
                                            @if($DeptPIC->user_id == auth()->user()->id)
 
 
                                                <a class="btn btn-primary btn-sm" href="{{url('laporan_penanggulangan/'.$laporan->id)}}" type="submit">Update Perbaikan</a>
 
 
 
 
                                                <form id="submitForm" action="{{route('needApproveTemuanPic')}}" method="post" class="inline">
                                                    @csrf
                                                    <input type="hidden" name="id" value="{{ $laporan->id }}">
                                                    <button class="btn btn-success btn-sm" id="submitButton" type="submit" >Kirim email minta approval depthead</button>
                                                </form>
                                            @endif
                                        @endforeach
 
 
                                    @endrole
 
 
                                    @role('Departement Head PIC')
                                        @foreach($laporan->area->area as $DeptPIC)
 
                                            @if($DeptPIC->user_id == auth()->user()->id)
 
                                                    <a class="btn btn-danger btn-sm text-white" href="{{ route('createPenolakan', ['id' => $laporan->id])}}">Tolak</a>
                                                    <form id="submitForm" action="{{ route('deptHeadPicSubmit')}}" method="post" class="inline">
                                                        @csrf
                                                        <input type="hidden" name="id" value={{ $laporan->id }}>
 
                                                    <button class="btn btn-primary btn-sm" id="submitButton" type="submit">Approve</button>
                                                    </form>
                                            @endif
                                        @endforeach
 
 
                                    @endrole
 
                                @elseif($laporan->progress == 11 && $laporan->ACC_Dept_Head_PIC_At !== null )
 
                                    @role('Departement Head PIC')
                                        @foreach($laporan->area->area as $DeptPIC)
                                            @if($DeptPIC->user_id == auth()->user()->id)
                                                <form id="submitForm" action="{{url('needVerifyEHS') }}" method="post" class="inline">
                                                    @csrf
                                                    <input type="hidden" name="id" value={{ $laporan->id }}>
                                                    <button class="btn btn-success btn-sm" id="submitButton" type="submit" >Kirim email minta approval EHS</button>
                                                </form>
                                            @endif
                                        @endforeach
                                    @endrole
 
 
                                    @role('EHS')
                                        <a class="btn btn-danger btn-sm text-white" href="{{ route('createPenolakan', ['id' => $laporan->id])}}">Tolak</a>
 
 
                                        <form id="submitForm" action="{{route('verify-laporan') }}" method="post" class="inline">
                                            @csrf
                                            <input type="hidden" name="laporan_id" value={{ $laporan->id }}>
                                        <button class="btn btn-primary btn-sm" id="submitButton" href="{{route('editForm',['id' => $laporan->id]) }}" type="submit">Verifikasi</button>
                                        </form>
                                    @endrole
 
                                @elseif($laporan->progress == 12 && $laporan->verify_submit_at !== null && $laporan->ACC_Dept_Head_EHS_At == null )
 
                                    @role('EHS')
                                    <form id="submitForm" action="{{route('needApproveTemuanEHS')}}" method="post" class="inline">
                                        @csrf
                                        <input type="hidden" name="id" value={{ $laporan->id }}>
                                        <button class="btn btn-success btn-sm" id="submitButton" type="submit" >Kirim email minta approval depthead EHS</button>
                                    </form>
                                    @endrole
 
 
                                    @role('Departement Head EHS')
                                        <a class="btn btn-danger btn-sm text-white" href="{{ route('createPenolakan', ['id' => $laporan->id])}}">Tolak</a>
                                            <form id="submitForm" action="{{route('deptHeadEhsSubmit') }}" method="post" class="inline">
                                                @csrf
                                                <input type="hidden" name="laporan_id" value={{ $laporan->id }}>
                                            <button class="btn btn-primary btn-sm" id="submitButton" type="submit">Approve</button>
                                            </form>
                                    @endrole
 
 
                                @elseif($laporan->progress == 13 && $laporan->ACC_Dept_Head_EHS_At !== null)
 
 
                                    @role('Departement Head EHS')
                                        <form id="submitForm" action="{{url('ApprovedDeptHeadEHS') }}" method="post" class="inline">
                                            @csrf
                                            <input type="hidden" name="id" value={{ $laporan->id }}>
                                            <button class="btn btn-success btn-sm" id="submitButton" type="submit" >Kirim email notifikasi selesai temuan</button>
                                        </form>
                                    @endrole
 
 
                                @endif
                            @endif
 
 
                        </div>
                                <div class="justify-content-end">
                                    <a class="btn btn-info btn-sm" href="{{url('patrolEHS/'.$laporan->laporan_patrol->id) }}" type="button">Lihat Laporan</a>
                                </div>
                    </div>
 
 
            </div>
        </div>
    </div>
</div>
</div>
@endsection
