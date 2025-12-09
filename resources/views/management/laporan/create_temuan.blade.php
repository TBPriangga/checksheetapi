@extends('component.navbar')

@section('content')

@include('component.message')
@error('foto_temuan')
<div class="alert alert-danger">File bukti harus berbentuk gambar</div>
@enderror
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Laporan</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a>Laporan</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>Buat Laporan</strong>
            </li>
        </ol>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <form method="post" action="/genba/laporan/storeTemuan" enctype="multipart/form-data">
        @csrf
<div class="row">
    <div class="col-lg-12">
        <div class="ibox ">
            <div class="ibox-title bg-info">
                <h5>Form Data</h5>
            </div>
            <div class="ibox-content">
                    <input type="hidden" name="auditor_id" value={{ auth()->user()->id }}>
                    <input type="hidden" name="progress" value="0">
                    <input type="hidden" name="genba_id" value="{{ $genba->id }}">
                    @livewire('form-area-p-i-c', ['genba_area' => $genba->area_id, 'selectdisable' => true])
                    @stack('scripts')
                    
                    <div class="hr-line-dashed"></div>

                    <div class="form-group row"><label class="col-sm-2 col-form-label" >Kategori</label>
                        <div class="col-sm-4">
                            <select class="select2_demo_3 form-control" name="kategori" required>
                                <option></option>
                                <option value="5R" @if(old('kategori') == '5R') selected @endif>5R</option>
                                <option value="A" @if(old('kategori') == 'A') selected @endif>A</option>
                                <option value="B" @if(old('kategori') == 'B') selected @endif>B</option>
                                <option value="C" @if(old('kategori') == 'C') selected @endif>C</option>
                                <option value="D" @if(old('kategori') == 'D') selected @endif>D</option>
                                <option value="E" @if(old('kategori') == 'E') selected @endif>E</option>
                                <option value="f" @if(old('kategori') == 'F') selected @endif>f</option>
                                <option value="G" @if(old('kategori') == 'G') selected @endif>G</option>
                                <option value="O" @if(old('kategori') == 'O') selected @endif>O</option>
                            </select>
                        </div>

                            <label class="col-sm-1 col-form-label">RANK</label>
                            <div class="col-sm-4">
                                <select class="select2_demo_3 form-control" name="rank" required>
                                    <option></option>
                                    <option value="A"  @if(old('rank') == 'A') selected @endif>A</option>
                                    <option value="B"  @if(old('rank') == 'B') selected @endif>B</option>
                                    <option value="C"  @if(old('rank') == 'C') selected @endif>C</option>
                                </select>
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

                        <div class="col-sm-4"><input type="text" class="form-control" name="man" value="{{ old('man') }}"></div>
                        
                        <label class="col-sm-2 col-form-label">material</label>

                        <div class="col-sm-4"><input type="text" class="form-control" name="material" value="{{ old('material') }}" ></div>
                    </div>
                    
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Machine</label>

                        <div class="col-sm-4"><input type="text" class="form-control" name="machine" value="{{ old('machine') }}"></div>

                        <label class="col-sm-2 col-form-label">Methode</label>

                        <div class="col-sm-4"><input type="text" class="form-control" name="methode" value="{{ old('methode') }}"></div>
                    </div>

                    <div class="hr-line-dashed"></div>
                    
                    <div class="form-group row"><label class="col-sm-2 col-form-label">What</label>

                        <div class="col-sm-10"><input type="text" class="form-control" name="what" value="{{ old('what') }}"></div>
                    </div>
                    <div class="form-group row"><label class="col-sm-2 col-form-label">Where</label>

                        <div class="col-sm-10"><input type="text" class="form-control" name="where" value="{{ old('where') }}"></div>
                    </div>
                    <div class="form-group row"><label class="col-sm-2 col-form-label">When</label>

                        <div class="col-sm-10"><input type="text" class="form-control" name="when" value="{{ old('when') }}"></div>
                    </div>
                    <div class="form-group row"><label class="col-sm-2 col-form-label">Why</label>

                        <div class="col-sm-10"><input type="text" class="form-control" name="why" value="{{ old('why') }}"></div>
                    </div>
                    <div class="form-group row"><label class="col-sm-2 col-form-label">Who</label>

                        <div class="col-sm-10"><input type="text" class="form-control" name="who" value="{{ old('who') }}"></div>
                    </div>
                    <div class="form-group row"><label class="col-sm-2 col-form-label">How</label>

                        <div class="col-sm-10"><input type="text" class="form-control" name="how" value="{{ old('how') }}"></div>
                    </div>
                    
                    <div class="hr-line-dashed"></div>

                    <div class="form-group row"><label class="col-sm-2 col-form-label">Bukti Gambar</label>

                        <div class="col-sm-4"><div class="custom-file">
                            <input id="logo" type="file" class="custom-file-input" name="foto_temuan" required>
                            <label for="logo" class="custom-file-label">Choose file...</label>
                        </div>
                    </div>

                    <label class="col-sm-1 col-form-label">Due Date</label>
                            <div class="col-sm-4" id="data_1">
                                <div class="input-group date">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control" name="deadline_date" value="{{ date('d/m/Y') }}">
                                </div>
                            </div>
                        </div>

                    <div class="hr-line-dashed"></div>

                    <div class="form-group row">
                        <div class="col-sm-4 col-sm-offset-2">
                            <a class="btn btn-white btn-sm" href="/genba/laporan/{{ $genba->id }}">Cancel</a>
                            <button class="btn btn-primary btn-sm" type="submit">Submit</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

</div>

@endsection