@extends('component.navbar')

@section('content')

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Laporan</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a>Laporan</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>Buat Laporan Perbaikan</strong>
            </li>
        </ol>
    </div>
</div>

@error('foto_penanggulangan')
<div class="alert alert-danger">File gambar perbaikan harus berbentuk gambar</div>
@enderror

<div class="wrapper wrapper-content animated fadeInRight">
<div class="row">
    <div class="col-lg-12">
        <div class="ibox ">
            <div class="ibox-title">
                <h5>Form Data</h5>
            </div>
            <div class="ibox-content">
                <form method="post" action="/laporan_penanggulangan/Update" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" value={{ $laporan->id }} name="laporan_id">
                    <div class="form-group row"><label class="col-sm-2 col-form-label">Perbaikans</label>

                        <div class="col-sm-10"><input type="text" class="form-control" name="penanggulangan" value="{{$laporan->penanggulangan }}" style="text-transform:none;"  required></div>
                    </div>

                    <div class="hr-line-dashed"></div>

                    <div class="form-group row"><label class="col-sm-2 col-form-label">Gambar Perbaikan</label>

                        <div class="col-sm-7">
                            <div class="custom-file">
                            <input id="logo" type="file" class="custom-file-input" name="foto_penanggulangan">
                            <label for="logo" class="custom-file-label">Choose file...</label>
                            </div>
                        </div>

                    <div class="col-sm-2">
                        <button class="btn btn-info" data-toggle="modal" data-target="#myModal4" type="button"><i class="fa fa-paste"></i>Preview Sebelumnya</button>
                        
                    </div>

                    <div class="modal inmodal" id="myModal4" tabindex="-1" role="dialog"  aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content animated fadeIn">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                    <h4 class="modal-title">Gambar Perbaikan</h4>
                                    <small>Penanggulangan berupa {{ $laporan->penanggulangan }} yang dikerjakan oleh {{ $laporan->PIC->name }} pada tanggal {{ $laporan->PIC_submit_at }}</small>
                                </div>
                                <div class="modal-body" style="overflow: hidden;">
                                    <div id="image-to-rotate1" class="ibox-content no-padding border-left-right">
                                        <img alt="image" class="img-fluid" src="{{ asset('gambar/foto_penanggulangan/'.$laporan->foto_penanggulangan) }}" style="width: 100%; height: 100%; object-fit: cover;">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button id="rotate-button1" class="btn btn-white"><i class="fa fa-repeat" aria-hidden="true"></i></button>
                                    <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    </div>


                    <div class="hr-line-dashed"></div>

                    <div class="form-group row">
                        <div class="col-sm-4 col-sm-offset-2">
                            <a class="btn btn-white btn-sm" href="/table" type="submit">Cancel</a>
                            <button class="btn btn-primary btn-sm" type="submit">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>
@endsection