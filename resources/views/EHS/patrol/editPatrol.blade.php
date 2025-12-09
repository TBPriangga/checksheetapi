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
                <a href="{{url('patrolEHS/'.$laporan->id)}}">Detail Laporan</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>Edit Laporan</strong>
            </li>
        </ol>
    </div>
</div>
<div class="modal inmodal fade" id="myModal5" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Gambar Temuan</h4>
            </div>
            <div class="modal-body">
                <div id="cameraOutput"></div>
            </div>
        </div>
    </div>
</div>
@error('foto_temuan')
<div class="alert alert-danger">File bukti harus berbentuk gambar</div>
@enderror

<div class="wrapper wrapper-content animated fadeInRight">
<div class="row">
    <div class="col-lg-12">
        <div class="ibox ">
            <div class="ibox-title bg-info">
                <h5>Form Data</h5>
            </div>
            <div class="ibox-content">
                <form id="submitForm" method="post" action="{{route('patrolEhsUpdate')}}">
                    @csrf
                    <input type="hidden" name="id" value="{{ $laporan->id }}">
                    <div class="form-group row"><label class="col-sm-2 col-form-label">Area</label>
                        <div class="col-sm-4">
                            <select class="select2_demo_3 form-control" name="area_id" required>
                                <option></option>
                                @foreach($areas as $area)
                                <option value={{ $area->id }} @if($laporan->area_id == $area->id) selected @endif>{{ $area->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <label class="col-sm-2 col-form-label">Tanggal Patrol</label>
                        <div class="col-sm-4" id="data_1">
                            <div class="input-group date">
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" name="tanggal_patrol" class="form-control" value="@dateWithDay($laporan->tanggal_patrol)" required>
                            </div>
                        </div>
                
                    </div>
                    
                    <div class="hr-line-dashed"></div>

                    <div class="container">
                        <div class="row">
                            <div class="col-4">
                                <a class="btn btn-white btn-sm" href="{{ route('patrolEhsDetail', ['id' => $laporan->id])  }}" type="button">Kembali</a>
                            </div>
                            <div class="col text-right">
                                <a class="btn btn-danger btn-sm" href="{{ route('hapusLaporan',['id' => $laporan->id]) }}" type="submit">Hapus</a>

                                <button id="submitButton" class="btn btn-warning btn-sm" type="submit">Simpan</button>
                            </div>
                        </div>
                    </div>
                    
                </form>
            </div>
        </div>
    </div>
</div>
</div>

@endsection