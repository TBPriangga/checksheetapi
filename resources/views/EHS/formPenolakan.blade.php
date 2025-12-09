@extends('component.navbar')

@section('content')

@include('component.message')
<div class="modal inmodal" id="myModalFoto" tabindex="-1" role="dialog"  aria-hidden="true">
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


<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        @if($laporan->genba_id == null)
        <h2>EHS Patrol</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{url('/patrolEHS')}}">Table EHS Patrol</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{url('/patrolEHS/'.$laporan->laporan_patrol->id)}}" >Detail Laporan</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{url('/detail/'.$laporan->id)}}" >Detail Temuan</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>Form Penolakan</strong>
            </li>
        </ol>
        @else 
        <h2>Management Patrol</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="/genba/schedule">Tabel Management Patrol</a>
            </li>
            <li class="breadcrumb-item">
                <a href="/genba/laporan/{{ $laporan->genba_id}}" >Detail Laporan</a>
            </li>
            <li class="breadcrumb-item">
                <a href="/genba/laporan/temuan/{{ $laporan->id }}" >Detail Temuan</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>Form Penolakan</strong>
            </li>
        </ol>
        @endif
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">

    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title bg-info">
                    <h5>Detail Temuan</h5>
                </div>
                <div class="ibox-content">
                    <div class="form-group row">
                        <label class="col-lg-2 col-form-label">Kategori</label>
    
                        <div class="col-sm-4"><input type="text" disabled="" placeholder="{{ $laporan->kategori }}" class="form-control"></div>
                        
                        <label class="col-sm-1 col-form-label">RANK</label>
    
                        <div class="col-sm-4"><input type="text" disabled="" placeholder="{{ $laporan->rank }}" class="form-control"></div>
                        
                    </div>
                    @if($laporan->genba_id == null)
    
                    <div class="form-group row">
                            
                        <label class="col-lg-2 col-form-label">Temuan</label>
                        
                        <div class="col-sm-9"><textarea type="text" disabled="" placeholder="{{ $laporan->temuan }}" class="form-control"></textarea></div>
                        
                    </div>
                    @endif
    
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Foto Temuan</label>
                        
                        <div class="col-sm-4"><div class="custom-file">
                            <button class="btn btn-info" data-toggle="modal" data-target="#myModalFoto" type="button"><i class="fa fa-paste"></i> Lihat Foto</button>
                        </div>
                    </div>
                </div>
    
    {{-- @dd($laporan) --}}
    
    
    
                </div>
            </div>
        </div>
    </div>

<div class="row">
    <div class="col-lg-12">
        <div class="ibox ">
            <div class="ibox-title bg-info">
                <h5>Form Data</h5>
            </div>
            <div class="ibox-content">
                <form id="submitForm" method="post" action="{{ route('updateTolakLaporan', ['id' => $laporan->id]) }}">
                    @csrf
                    <input type="hidden" value={{ $laporan->id }} name="laporan_id">
                    <input type="hidden" value={{ $laporan->progress }} id="progress_default" name="progress_default">
                    <div class="form-group row"><label class="col-sm-2 col-form-label">Catatan perbaikan lanjutan</label>

                        <div class="col-sm-10  @error('alasan_penolakan') has-error  @enderror">
                            <input type="text" class="form-control" name="alasan_penolakan" value="{{ old('alasan_penolakan') }}" required>
                            @error('alasan_penolakan')
                                <code>
                                    Catatan perbaikan lanjutan tidak boleh dikosongkan
                                </code>
                                @enderror
                        </div>
                    </div>
                    

                    <div class="hr-line-dashed"></div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Progress <span class="btn btn-sm btn-info" data-toggle="modal" data-target="#info_progress"><i class="fa fa-question-circle"></i></span></label>
                        <div class="col-lg-10">
                            <div id="basic_slider"></div>
                            <div class="mt-2" id="percentageDisplay"></div>
                        </div>
                        <input type="hidden" id="sliderValue" name="progress">
                    </div>
                    <div class="hr-line-dashed"></div>

                    <div class="form-group row">
                        <div class="col-sm-4 col-sm-offset-2">
                            @if($laporan->genba_id == null)
                            <a class="btn btn-white btn-sm" href="{{route('detailLaporan', ['id'=> $laporan->id])}}" type="submit">Cancel</a>
                            @else
                            <a class="btn btn-white btn-sm" href="{{route('detailTemuan', ['id' => $laporan->id])}}" type="submit">Cancel</a>
                            @endif
                            <button id="submitButton" class="btn btn-primary btn-sm" type="submit">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>

<div>
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
</div>
@endsection
