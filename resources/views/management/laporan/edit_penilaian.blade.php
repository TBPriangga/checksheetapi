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
    <form method="post" action="/genba/penilaian/update" enctype="multipart/form-data">
        @csrf
        <input type="hidden" value={{ $penilaian->id }} name="id">
        <input type="hidden" value={{ $genba_id }} name="genba_id">
<div class="row">
    <div class="col-lg-12">
        <div class="ibox ">
            <div class="ibox-title bg-info">
                <h5>Form Penilaian</h5>
            </div>
            <div class="ibox-content">
                <h3>RINGKAS</h3>
                <div>
                    <label class="col-form-label responsive-text">Hanya ada barang, peralatan, material dan dokumen yang sedang dikerjakan hari ini di area kerja. Serta yang tidak digunakna ditempatkan tersendiri.
                    </label>
                    <div class="row ml-sm-5 ml-0  mt-3 mt-sm-2">
                        <div class="col form-check form-check-inline">
                            <label class="form-check-label responsive-label" for="input1">Kurang Baik</label>
                        </div>
                        <div class="col form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="pertanyaan_1" id="radio_pertanyaan_1" value="1" @if($penilaian->pertanyaan_1 == 1) checked @endif>
                            <label class="form-check-label" for="radio_pertanyaan_1">1</label>
                        </div>
                        <div class="col form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="pertanyaan_1" id="radio2_pertanyaan_1" value="2" @if($penilaian->pertanyaan_1 == 2) checked @endif>
                            <label class="form-check-label" for="radio2_pertanyaan_1">2</label>
                        </div>
                        <div class="col form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="pertanyaan_1" id="radio3_pertanyaan_1" value="3" @if($penilaian->pertanyaan_1 == 3) checked @endif>
                            <label class="form-check-label" for="radio3_pertanyaan_1">3</label>
                        </div>
                        <div class="col form-check form-check-inline">
                            <label class="form-check-label responsive-label" for="comfort5">Sangat Baik</label>
                        </div>
                    </div>
                </div>
                <div class="hr-line-dashed"></div>
                <h3>RAPI</h3>
                <div>
                    <label class="col-form-label responsive-text">Tempat sampah ditempatkan seusai dengan tempatnya masing-masing terlayout, tidak tertutup barang, material, trolley, dan isi sampah tidak over/luber sesuai dengan kategori : Organik, Anorganik & B3.</label>
                    <div class="row ml-sm-5 ml-0  mt-3 mt-sm-2">
                        <div class="col form-check form-check-inline">
                            <label class="form-check-label responsive-label" for="input2">Kurang Baik</label>
                        </div>
                        <div class="col form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="pertanyaan_2" id="radio_pertanyaan_2" value="1" @if($penilaian->pertanyaan_2 == 1) checked @endif>
                            <label class="form-check-label" for="radio_pertanyaan_2">1</label>
                        </div>
                        <div class="col form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="pertanyaan_2" id="radio2_pertanyaan_2" value="2" @if($penilaian->pertanyaan_2 == 2) checked @endif>
                            <label class="form-check-label" for="radio2_pertanyaan_2">2</label>
                        </div>
                        <div class="col form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="pertanyaan_2" id="radio3_pertanyaan_2" value="3" @if($penilaian->pertanyaan_2 == 3) checked @endif>
                            <label class="form-check-label" for="radio3_pertanyaan_2">3</label>
                        </div>
                        <div class="col form-check form-check-inline">
                            <label class="form-check-label responsive-label" for="comfort5">Sangat Baik</label>
                        </div>
                    </div>
                </div>
                <div class="hr-line-dashed"></div>
                <div>
                    <label class="col-form-label responsive-text">Setiap barnag, peralatan, material, dokumen ditempatkan sesusai identitas dan terdapat layout dalam kondisi baik serta mudah terbaca, terdapat nama dengan alamat penyimpanan sesuai penempatannya.

                    </label>
                    <div class="row ml-sm-5 ml-0  mt-3 mt-sm-2">
                        <div class="col form-check form-check-inline">
                            <label class="form-check-label responsive-label" for="input1">Kurang Baik</label>
                        </div>
                        <div class="col form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="pertanyaan_3" id="radio_pertanyaan_3" value="1" @if($penilaian->pertanyaan_3 == 1) checked @endif>
                            <label class="form-check-label" for="radio_pertanyaan_3">1</label>
                        </div>
                        <div class="col form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="pertanyaan_3" id="radio2_pertanyaan_3" value="2" @if($penilaian->pertanyaan_3 == 2) checked @endif>
                            <label class="form-check-label" for="radio2_pertanyaan_3">2</label>
                        </div>
                        <div class="col form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="pertanyaan_3" id="radio3_pertanyaan_3" value="3" @if($penilaian->pertanyaan_3 == 3) checked @endif>
                            <label class="form-check-label" for="radio3_pertanyaan_3">3</label>
                        </div>
                        <div class="col form-check form-check-inline">
                            <label class="form-check-label responsive-label" for="comfort5">Sangat Baik</label>
                        </div>
                    </div>
                </div>
                <div class="hr-line-dashed"></div>
                <div>
                    <label class="col-form-label responsive-text">Cara penempatan barang, peralatan, material dan dokumen tidak bercampur dalam posisi yang sudah ditentukan dan harus sesuai dengan barang yang bentuknya sama.
                    </label>
                    <div class="row ml-sm-5 ml-0  mt-3 mt-sm-2">
                        <div class="col form-check form-check-inline">
                            <label class="form-check-label responsive-label" for="input1">Kurang Baik</label>
                        </div>
                        <div class="col form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="pertanyaan_4" id="radio_pertanyaan_4" value="1" @if($penilaian->pertanyaan_4 == 1) checked @endif> 
                            <label class="form-check-label" for="radio_pertanyaan_4">1</label>
                        </div>
                        <div class="col form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="pertanyaan_4" id="radio2_pertanyaan_4" value="2" @if($penilaian->pertanyaan_4 == 2) checked @endif>
                            <label class="form-check-label" for="radio2_pertanyaan_4">2</label>
                        </div>
                        <div class="col form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="pertanyaan_4" id="radio3_pertanyaan_4" value="3" @if($penilaian->pertanyaan_4 == 3) checked @endif>
                            <label class="form-check-label" for="radio3_pertanyaan_4">3</label>
                        </div>
                        <div class="col form-check form-check-inline">
                            <label class="form-check-label responsive-label" for="comfort5">Sangat Baik</label>
                        </div>
                    </div>
                </div>
                <div class="hr-line-dashed"></div>
                <h3>RESIK</h3>
                <div>
                    <label class="col-form-label responsive-text">Lingkungan kerja/ area kerja, mesin, fasilitas kerja, peralatan, material, trolley, rak, dokumen dalam kondisi bersih, rapi, tidak ada bau, tidak berdebu dan tidak terdapat laba-laba.
                    </label>
                    <div class="row ml-sm-5 ml-0  mt-3 mt-sm-2">
                        <div class="col form-check form-check-inline">
                            <label class="form-check-label responsive-label" for="input1">Kurang Baik</label>
                        </div>
                        <div class="col form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="pertanyaan_5" id="radio_pertanyaan_5" value="1" @if($penilaian->pertanyaan_5 == 1) checked @endif>
                            <label class="form-check-label" for="radio_pertanyaan_5">1</label>
                        </div>
                        <div class="col form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="pertanyaan_5" id="radio2_pertanyaan_5" value="2" @if($penilaian->pertanyaan_5 == 2) checked @endif>
                            <label class="form-check-label" for="radio2_pertanyaan_5">2</label>
                        </div>
                        <div class="col form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="pertanyaan_5" id="radio3_pertanyaan_5" value="3" @if($penilaian->pertanyaan_5 == 3) checked @endif>
                            <label class="form-check-label" for="radio3_pertanyaan_5">3</label>
                        </div>
                        <div class="col form-check form-check-inline">
                            <label class="form-check-label responsive-label" for="comfort5">Sangat Baik</label>
                        </div>
                    </div>
                </div>
                <div class="hr-line-dashed"></div>
                <div>
                    <label class="col-form-label responsive-text">Lingkungan kerja/area kerja (lantai) bebas dari benda-benda yang tidak terpakai dan tidak ada ceceran (contoh : majun, kertas, kardus, plastik, air, limbah cair, oli).

                    </label>
                    <div class="row ml-sm-5 ml-0  mt-3 mt-sm-2">
                        <div class="col form-check form-check-inline">
                            <label class="form-check-label responsive-label" for="input1">Kurang Baik</label>
                        </div>
                        <div class="col form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="pertanyaan_6" id="radio_pertanyaan_6" value="1" @if($penilaian->pertanyaan_6 == 1) checked @endif>
                            <label class="form-check-label" for="radio_pertanyaan_6">1</label>
                        </div>
                        <div class="col form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="pertanyaan_6" id="radio2_pertanyaan_6" value="2" @if($penilaian->pertanyaan_6 == 2) checked @endif>
                            <label class="form-check-label" for="radio2_pertanyaan_6">2</label>
                        </div>
                        <div class="col form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="pertanyaan_6" id="radio3_pertanyaan_6" value="3" @if($penilaian->pertanyaan_6 == 3) checked @endif>
                            <label class="form-check-label" for="radio3_pertanyaan_6">3</label>
                        </div>
                        <div class="col form-check form-check-inline">
                            <label class="form-check-label responsive-label" for="comfort5">Sangat Baik</label>
                        </div>
                    </div>
                </div>
                <div class="hr-line-dashed"></div>
                <h3>RAWAT</h3>
                <div>
                    <label class="col-form-label responsive-text">Konsistensi Ringkas, Rapi, Resik terimplementasi dengan baik di area kerja masing-masing.

                    </label>
                    <div class="row ml-sm-5 ml-0  mt-3 mt-sm-2">
                        <div class="col form-check form-check-inline">
                            <label class="form-check-label responsive-label" for="input1">Kurang Baik</label>
                        </div>
                        <div class="col form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="pertanyaan_7" id="radio_pertanyaan_7" value="1" @if($penilaian->pertanyaan_7 == 1) checked @endif>
                            <label class="form-check-label" for="radio_pertanyaan_7">1</label>
                        </div>
                        <div class="col form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="pertanyaan_7" id="radio2_pertanyaan_7" value="2" @if($penilaian->pertanyaan_7 == 2) checked @endif>
                            <label class="form-check-label" for="radio2_pertanyaan_7">2</label>
                        </div>
                        <div class="col form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="pertanyaan_7" id="radio3_pertanyaan_7" value="3" @if($penilaian->pertanyaan_7 == 3) checked @endif>
                            <label class="form-check-label" for="radio3_pertanyaan_7">3</label>
                        </div>
                        <div class="col form-check form-check-inline">
                            <label class="form-check-label responsive-label" for="comfort5">Sangat Baik</label>
                        </div>
                    </div>
                </div>
                <div class="hr-line-dashed"></div>
                <h3>RAJIN</h3>
                <div>
                    <label class="col-form-label responsive-text">Member dan Pimpinan kerja dapat menjaga aspek safety dan 5R serta melakukan perbaikan di lingkungna kerja masing-masing/.

                    </label>
                    <div class="row ml-sm-5 ml-0  mt-3 mt-sm-2">
                        <div class="col form-check form-check-inline">
                            <label class="form-check-label responsive-label" for="input1">Kurang Baik</label>
                        </div>
                        <div class="col form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="pertanyaan_8" id="radio_pertanyaan_8" value="1" @if($penilaian->pertanyaan_8 == 1) checked @endif>
                            <label class="form-check-label" for="radio_pertanyaan_8">1</label>
                        </div>
                        <div class="col form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="pertanyaan_8" id="radio2_pertanyaan_8" value="2" @if($penilaian->pertanyaan_8 == 2) checked @endif>
                            <label class="form-check-label" for="radio2_pertanyaan_8">2</label>
                        </div>
                        <div class="col form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="pertanyaan_8" id="radio3_pertanyaan_8" value="3" @if($penilaian->pertanyaan_8 == 3) checked @endif>
                            <label class="form-check-label" for="radio3_pertanyaan_8">3</label>
                        </div>
                        <div class="col form-check form-check-inline">
                            <label class="form-check-label responsive-label" for="comfort5">Sangat Baik</label>
                        </div>
                    </div>
                </div>
                <div class="hr-line-dashed"></div>
                <h3>SAFETY</h3>
                <div>
                    <label class="col-form-label responsive-text">Area kerja dalam kondisi aman dan bebas dari barang, material peralatan dan mesin yang berpotensi bahaya kecelakaan kerja.(Stom 6 : Terjepit mesin, Kejatuhan benda berat, Tertabrak Kendaraan, Terjatuh dari Ketinggian, Tersengat listrik, Terkena Benda?Mesin Panas, Tergores, Tertusuk, Tersayat, Terbentur, Teperosok, dan Terpeleset).

                        <div class="row ml-sm-5 ml-0  mt-3 mt-sm-2">
                            <div class="col form-check form-check-inline">
                                <label class="form-check-label responsive-label" for="input1">Kurang Baik</label>
                            </div>
                            <div class="col form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="pertanyaan_9" id="radio_pertanyaan_9" value="1" @if($penilaian->pertanyaan_9 == 1) checked @endif>
                                <label class="form-check-label" for="radio_pertanyaan_9">1</label>
                            </div>
                            <div class="col form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="pertanyaan_9" id="radio2_pertanyaan_9" value="2" @if($penilaian->pertanyaan_9 == 2) checked @endif>
                                <label class="form-check-label" for="radio2_pertanyaan_9">2</label>
                            </div>
                            <div class="col form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="pertanyaan_9" id="radio3_pertanyaan_9" value="3" @if($penilaian->pertanyaan_9 == 3) checked @endif>
                                <label class="form-check-label" for="radio3_pertanyaan_9">3</label>
                            </div>
                            <div class="col form-check form-check-inline">
                                <label class="form-check-label responsive-label" for="comfort5">Sangat Baik</label>
                            </div>
                        </div>
                </div>
                <div class="hr-line-dashed"></div>
                <div>
                    <label class="col-form-label responsive-text">Semua panel listrik tidak dalam kondisi terbuka, tidak terhalang benda atau barang. Wiring kabel listrik dalam kondisi rapi, tercover, tidak menjuntai, melintang, terjepit, berpotensi tersandung, dan tersengat arus, serta kondisi APAR & Hydrant di area kerja dalam kondisi mudah terlihat dan tidak terhalang atau tertutup barang.

                    </label>
                    <div class="row ml-sm-5 ml-0  mt-3 mt-sm-2">
                        <div class="col form-check form-check-inline">
                            <label class="form-check-label responsive-label" for="input1">Kurang Baik</label>
                        </div>
                        <div class="col form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="pertanyaan_10" id="radio_pertanyaan_10" value="1" @if($penilaian->pertanyaan_10 == 1) checked @endif>
                            <label class="form-check-label" for="radio_pertanyaan_10">1</label>
                        </div>
                        <div class="col form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="pertanyaan_10" id="radio2_pertanyaan_10" value="2" @if($penilaian->pertanyaan_10 == 2) checked @endif>
                            <label class="form-check-label" for="radio2_pertanyaan_10">2</label>
                        </div>
                        <div class="col form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="pertanyaan_10" id="radio3_pertanyaan_10" value="3" @if($penilaian->pertanyaan_10 == 3) checked @endif>
                            <label class="form-check-label" for="radio3_pertanyaan_10">3</label>
                        </div>
                        <div class="col form-check form-check-inline">
                            <label class="form-check-label responsive-label" for="comfort5">Sangat Baik</label>
                        </div>
                    </div>
                </div>
                <div class="hr-line-dashed"></div>
                <div class="form-group row">
                    <div class="col-sm-4 col-sm-offset-2">
                        <a class="btn btn-white btn-lg" href="/genba/laporan/{{ $genba_id }}/penilaian/detail/{{ $penilaian->id }}">Cancel</a>
                        <button class="btn btn-primary btn-lg compose_mail" type="submit">Save</button>
                    </div>
                </div>
                </div> 
            </div>
        </div>
    </div>
    </form>
</div>
{{-- <a class="btn btn-primary btn-sm" href="/laporan_penanggulangan" type="submit">Update Laporan</a> --}}
@endsection
{{-- @section('scripts')
<script src={{ asset('js/jquery-3.1.1.min.js') }}></script>
    <script src={{ asset('js/popper.min.js') }}></script>
    <script src={{ asset('js/bootstrap.js') }}></script>
    <script src={{ asset('js/plugins/nouslider/jquery.nouislider.min.js') }}></script>
<script>

    var slider_penilaian1 = document.getElementById('slider_penilaian1');
    var sliderValueInput1 = document.getElementById('pertanyaan_1');
    noUiSlider.create(slider_penilaian1, {
        start: sliderValueInput1.value,
        behaviour: 'tap',
        connect: 'lower',
        orientation: 'horizontal',
        range: {
            'min':  0,
            'max':  10
            },
        step: 1,
        
        });
    slider_penilaian1.noUiSlider.on('update', function(values, handle) {
    sliderValueInput1.value = values[handle];
    var percentage = (values[handle] / 10) * 10;
    

    // Tampilkan persentase di bawah slider
    percentageDisplay1.innerText = percentage.toFixed(0);
    });

    var slider_penilaian2 = document.getElementById('slider_penilaian2');
    var sliderValueInput2 = document.getElementById('pertanyaan_2');
    noUiSlider.create(slider_penilaian2, {
        start: sliderValueInput2.value,
        behaviour: 'tap',
        connect: 'lower',
        range: {
            'min':  0,
            'max':  10
            },
        step: 1,
        
        });
    slider_penilaian2.noUiSlider.on('update', function(values, handle) {
    sliderValueInput2.value = values[handle];
    var percentage = (values[handle] / 10) * 10;
    

    // Tampilkan persentase di bawah slider
    percentageDisplay2.innerText = percentage.toFixed(0);
    
    });


    var slider_penilaian3 = document.getElementById('slider_penilaian3');
    var sliderValueInput3 = document.getElementById('pertanyaan_3');
    noUiSlider.create(slider_penilaian3, {
        start: sliderValueInput3.value,
        behaviour: 'tap',
        connect: 'lower',
        range: {
            'min':  0,
            'max':  10
            },
        step: 1,
        
        });
    slider_penilaian3.noUiSlider.on('update', function(values, handle) {
    sliderValueInput3.value = values[handle];
    var percentage = (values[handle] / 10) * 10;
    

    // Tampilkan persentase di bawah slider
    percentageDisplay3.innerText = percentage.toFixed(0);
    });


    var slider_penilaian4 = document.getElementById('slider_penilaian4');
    var sliderValueInput4 = document.getElementById('pertanyaan_4');
    noUiSlider.create(slider_penilaian4, {
        start: sliderValueInput4.value,
        behaviour: 'tap',
        connect: 'lower',
        range: {
            'min':  0,
            'max':  10
            },
        step: 1,
        
        });
    slider_penilaian4.noUiSlider.on('update', function(values, handle) {
    sliderValueInput4.value = values[handle];
    var percentage = (values[handle] / 10) * 10;
    

    // Tampilkan persentase di bawah slider
    percentageDisplay4.innerText = percentage.toFixed(0);
    });


    var slider_penilaian5 = document.getElementById('slider_penilaian5');
    var sliderValueInput5 = document.getElementById('pertanyaan_5');
    noUiSlider.create(slider_penilaian5, {
        start: sliderValueInput5.value,
        behaviour: 'tap',
        connect: 'lower',
        range: {
            'min':  0,
            'max':  10
            },
        step: 1,
        
        });
    slider_penilaian5.noUiSlider.on('update', function(values, handle) {
    sliderValueInput5.value = values[handle];
    var percentage = (values[handle] / 10) * 10;
    

    // Tampilkan persentase di bawah slider
    percentageDisplay5.innerText = percentage.toFixed(0);
    });


    var slider_penilaian6 = document.getElementById('slider_penilaian6');
    var sliderValueInput6 = document.getElementById('pertanyaan_6');
    noUiSlider.create(slider_penilaian6, {
        start: sliderValueInput6.value,
        behaviour: 'tap',
        connect: 'lower',
        range: {
            'min':  0,
            'max':  10
            },
        step: 1,
        
        });
    slider_penilaian6.noUiSlider.on('update', function(values, handle) {
    sliderValueInput6.value = values[handle];
    var percentage = (values[handle] / 10) * 10;
    

    // Tampilkan persentase di bawah slider
    percentageDisplay6.innerText = percentage.toFixed(0);
    });


    var slider_penilaian7 = document.getElementById('slider_penilaian7');
    var sliderValueInput7 = document.getElementById('pertanyaan_7');
    noUiSlider.create(slider_penilaian7, {
        start: sliderValueInput7.value,
        behaviour: 'tap',
        connect: 'lower',
        range: {
            'min':  0,
            'max':  10
            },
        step: 1,
        
        });
    slider_penilaian7.noUiSlider.on('update', function(values, handle) {
    sliderValueInput7.value = values[handle];
    var percentage = (values[handle] / 10) * 10;
    

    // Tampilkan persentase di bawah slider
    percentageDisplay7.innerText = percentage.toFixed(0);
    });


    var slider_penilaian8 = document.getElementById('slider_penilaian8');
    var sliderValueInput8 = document.getElementById('pertanyaan_8');
    noUiSlider.create(slider_penilaian8, {
        start: sliderValueInput8.value,
        behaviour: 'tap',
        connect: 'lower',
        range: {
            'min':  0,
            'max':  10
            },
        step: 1,
        
        });
    slider_penilaian8.noUiSlider.on('update', function(values, handle) {
    sliderValueInput8.value = values[handle];
    var percentage = (values[handle] / 10) * 10;
    

    // Tampilkan persentase di bawah slider
    percentageDisplay8.innerText = percentage.toFixed(0);
    });


    var slider_penilaian9 = document.getElementById('slider_penilaian9');
    var sliderValueInput9 = document.getElementById('pertanyaan_9');
    noUiSlider.create(slider_penilaian9, {
        start: sliderValueInput9.value,
        behaviour: 'tap',
        connect: 'lower',
        range: {
            'min':  0,
            'max':  10
            },
        step: 1,
        
        });
    slider_penilaian9.noUiSlider.on('update', function(values, handle) {
    sliderValueInput9.value = values[handle];
    var percentage = (values[handle] / 10) * 10;
    

    // Tampilkan persentase di bawah slider
    percentageDisplay9.innerText = percentage.toFixed(0);
    });


    var slider_penilaian10 = document.getElementById('slider_penilaian10');
    var sliderValueInput10 = document.getElementById('pertanyaan_10');
    noUiSlider.create(slider_penilaian10, {
        start: sliderValueInput10.value,
        behaviour: 'tap',
        connect: 'lower',
        range: {
            'min':  0,
            'max':  10
            },
        step: 1,
        
        });
        slider_penilaian10.noUiSlider.on('update', function(values, handle) {
            sliderValueInput10.value = values[handle];
            var percentage = (values[handle] / 10) * 10;
            

            // Tampilkan persentase di bawah slider
            percentageDisplay10.innerText = percentage.toFixed(0);
            });

</script>
@endsection --}}
