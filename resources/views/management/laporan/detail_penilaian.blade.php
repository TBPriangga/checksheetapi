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
                <h5>Form Penilaian</h5>
            </div>
            <div class="ibox-content">
                <h3>RINGKAS</h3>
                <div>
                    <label class="col-form-label">Hanya ada barang, peralatan, material dan dokumen yang sedang dikerjakan hari ini di area kerja. Serta yang tidak digunakna ditempatkan tersendiri.
                    </label>
                    <div class="row ml-sm-5 ml-3">
                        <div class="col form-check form-check-inline">
                            <label class="form-check-label" for="input1">Kurang Baik</label>
                        </div>
                        <div class="col form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="pertanyaan_1" id="radio_pertanyaan_1" value="1" @if($penilaian->pertanyaan_1 == 1) checked @endif disabled>
                            <label class="form-check-label" for="radio_pertanyaan_1">1</label>
                        </div>
                        <div class="col form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="pertanyaan_1" id="radio2_pertanyaan_1" value="2" @if($penilaian->pertanyaan_1 == 2) checked @endif disabled>
                            <label class="form-check-label" for="radio2_pertanyaan_1">2</label>
                        </div>
                        <div class="col form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="pertanyaan_1" id="radio3_pertanyaan_1" value="3" @if($penilaian->pertanyaan_1 == 3) checked @endif disabled>
                            <label class="form-check-label" for="radio3_pertanyaan_1">3</label>
                        </div>
                        <div class="col form-check form-check-inline">
                            <label class="form-check-label" for="comfort5">Sangat Baik</label>
                        </div>
                    </div>
                </div>
                <div class="hr-line-dashed"></div>
                <h3>RAPI</h3>
                <div>
                    <label class="col-form-label">Tempat sampah ditempatkan seusai dengan tempatnya masing-masing terlayout, tidak tertutup barang, material, trolley, dan isi sampah tidak over/luber sesuai dengan kategori : Organik, Anorganik & B3.</label>
                    <div class="row ml-sm-5 ml-3">
                        <div class="col form-check form-check-inline">
                            <label class="form-check-label" for="input2">Kurang Baik</label>
                        </div>
                        <div class="col form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="pertanyaan_2" id="radio_pertanyaan_2" value="1" @if($penilaian->pertanyaan_2 == 1) checked @endif disabled>
                            <label class="form-check-label" for="radio_pertanyaan_2">1</label>
                        </div>
                        <div class="col form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="pertanyaan_2" id="radio2_pertanyaan_2" value="2" @if($penilaian->pertanyaan_2 == 2) checked @endif disabled>
                            <label class="form-check-label" for="radio2_pertanyaan_2">2</label>
                        </div>
                        <div class="col form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="pertanyaan_2" id="radio3_pertanyaan_2" value="3" @if($penilaian->pertanyaan_2 == 3) checked @endif disabled>
                            <label class="form-check-label" for="radio3_pertanyaan_2">3</label>
                        </div>
                        <div class="col form-check form-check-inline">
                            <label class="form-check-label" for="comfort5">Sangat Baik</label>
                        </div>
                    </div>
                </div>
                <div class="hr-line-dashed"></div>
                <div>
                    <label class="col-form-label">Setiap barnag, peralatan, material, dokumen ditempatkan sesusai identitas dan terdapat layout dalam kondisi baik serta mudah terbaca, terdapat nama dengan alamat penyimpanan sesuai penempatannya.

                    </label>
                    <div class="row ml-sm-5 ml-3">
                        <div class="col form-check form-check-inline">
                            <label class="form-check-label" for="input1">Kurang Baik</label>
                        </div>
                        <div class="col form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="pertanyaan_3" id="radio_pertanyaan_3" value="1" @if($penilaian->pertanyaan_3 == 1) checked @endif disabled>
                            <label class="form-check-label" for="radio_pertanyaan_3">1</label>
                        </div>
                        <div class="col form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="pertanyaan_3" id="radio2_pertanyaan_3" value="2" @if($penilaian->pertanyaan_3 == 2) checked @endif disabled>
                            <label class="form-check-label" for="radio2_pertanyaan_3">2</label>
                        </div>
                        <div class="col form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="pertanyaan_3" id="radio3_pertanyaan_3" value="3" @if($penilaian->pertanyaan_3 == 3) checked @endif disabled>
                            <label class="form-check-label" for="radio3_pertanyaan_3">3</label>
                        </div>
                        <div class="col form-check form-check-inline">
                            <label class="form-check-label" for="comfort5">Sangat Baik</label>
                        </div>
                    </div>
                </div>
                <div class="hr-line-dashed"></div>
                <div>
                    <label class="col-form-label">Cara penempatan barang, peralatan, material dan dokumen tidak bercampur dalam posisi yang sudah ditentukan dan harus sesuai dengan barang yang bentuknya sama.
                    </label>
                    <div class="row ml-sm-5 ml-3">
                        <div class="col form-check form-check-inline">
                            <label class="form-check-label" for="input1">Kurang Baik</label>
                        </div>
                        <div class="col form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="pertanyaan_4" id="radio_pertanyaan_4" value="1" @if($penilaian->pertanyaan_4 == 1) checked @endif disabled> 
                            <label class="form-check-label" for="radio_pertanyaan_4">1</label>
                        </div>
                        <div class="col form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="pertanyaan_4" id="radio2_pertanyaan_4" value="2" @if($penilaian->pertanyaan_4 == 2) checked @endif disabled>
                            <label class="form-check-label" for="radio2_pertanyaan_4">2</label>
                        </div>
                        <div class="col form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="pertanyaan_4" id="radio3_pertanyaan_4" value="3" @if($penilaian->pertanyaan_4 == 3) checked @endif disabled>
                            <label class="form-check-label" for="radio3_pertanyaan_4">3</label>
                        </div>
                        <div class="col form-check form-check-inline">
                            <label class="form-check-label" for="comfort5">Sangat Baik</label>
                        </div>
                    </div>
                </div>
                <div class="hr-line-dashed"></div>
                <h3>RESIK</h3>
                <div>
                    <label class="col-form-label">Lingkungan kerja/ area kerja, mesin, fasilitas kerja, peralatan, material, trolley, rak, dokumen dalam kondisi bersih, rapi, tidak ada bau, tidak berdebu dan tidak terdapat laba-laba.
                    </label>
                    <div class="row ml-sm-5 ml-3">
                        <div class="col form-check form-check-inline">
                            <label class="form-check-label" for="input1">Kurang Baik</label>
                        </div>
                        <div class="col form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="pertanyaan_5" id="radio_pertanyaan_5" value="1" @if($penilaian->pertanyaan_5 == 1) checked @endif disabled>
                            <label class="form-check-label" for="radio_pertanyaan_5">1</label>
                        </div>
                        <div class="col form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="pertanyaan_5" id="radio2_pertanyaan_5" value="2" @if($penilaian->pertanyaan_5 == 2) checked @endif disabled>
                            <label class="form-check-label" for="radio2_pertanyaan_5">2</label>
                        </div>
                        <div class="col form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="pertanyaan_5" id="radio3_pertanyaan_5" value="3" @if($penilaian->pertanyaan_5 == 3) checked @endif disabled>
                            <label class="form-check-label" for="radio3_pertanyaan_5">3</label>
                        </div>
                        <div class="col form-check form-check-inline">
                            <label class="form-check-label" for="comfort5">Sangat Baik</label>
                        </div>
                    </div>
                </div>
                <div class="hr-line-dashed"></div>
                <div>
                    <label class="col-form-label">Lingkungan kerja/area kerja (lantai) bebas dari benda-benda yang tidak terpakai dan tidak ada ceceran (contoh : majun, kertas, kardus, plastik, air, limbah cair, oli).

                    </label>
                    <div class="row ml-sm-5 ml-3">
                        <div class="col form-check form-check-inline">
                            <label class="form-check-label" for="input1">Kurang Baik</label>
                        </div>
                        <div class="col form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="pertanyaan_6" id="radio_pertanyaan_6" value="1" @if($penilaian->pertanyaan_6 == 1) checked @endif disabled>
                            <label class="form-check-label" for="radio_pertanyaan_6">1</label>
                        </div>
                        <div class="col form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="pertanyaan_6" id="radio2_pertanyaan_6" value="2" @if($penilaian->pertanyaan_6 == 2) checked @endif disabled>
                            <label class="form-check-label" for="radio2_pertanyaan_6">2</label>
                        </div>
                        <div class="col form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="pertanyaan_6" id="radio3_pertanyaan_6" value="3" @if($penilaian->pertanyaan_6 == 3) checked @endif disabled>
                            <label class="form-check-label" for="radio3_pertanyaan_6">3</label>
                        </div>
                        <div class="col form-check form-check-inline">
                            <label class="form-check-label" for="comfort5">Sangat Baik</label>
                        </div>
                    </div>
                </div>
                <div class="hr-line-dashed"></div>
                <h3>RAWAT</h3>
                <div>
                    <label class="col-form-label">Konsistensi Ringkas, Rapi, Resik terimplementasi dengan baik di area kerja masing-masing.

                    </label>
                    <div class="row ml-sm-5 ml-3">
                        <div class="col form-check form-check-inline">
                            <label class="form-check-label" for="input1">Kurang Baik</label>
                        </div>
                        <div class="col form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="pertanyaan_7" id="radio_pertanyaan_7" value="1" @if($penilaian->pertanyaan_7 == 1) checked @endif disabled>
                            <label class="form-check-label" for="radio_pertanyaan_7">1</label>
                        </div>
                        <div class="col form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="pertanyaan_7" id="radio2_pertanyaan_7" value="2" @if($penilaian->pertanyaan_7 == 2) checked @endif disabled>
                            <label class="form-check-label" for="radio2_pertanyaan_7">2</label>
                        </div>
                        <div class="col form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="pertanyaan_7" id="radio3_pertanyaan_7" value="3" @if($penilaian->pertanyaan_7 == 3) checked @endif disabled>
                            <label class="form-check-label" for="radio3_pertanyaan_7">3</label>
                        </div>
                        <div class="col form-check form-check-inline">
                            <label class="form-check-label" for="comfort5">Sangat Baik</label>
                        </div>
                    </div>
                </div>
                <div class="hr-line-dashed"></div>
                <h3>RAJIN</h3>
                <div>
                    <label class="col-form-label">Member dan Pimpinan kerja dapat menjaga aspek safety dan 5R serta melakukan perbaikan di lingkungna kerja masing-masing/.

                    </label>
                    <div class="row ml-sm-5 ml-3">
                        <div class="col form-check form-check-inline">
                            <label class="form-check-label" for="input1">Kurang Baik</label>
                        </div>
                        <div class="col form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="pertanyaan_8" id="radio_pertanyaan_8" value="1" @if($penilaian->pertanyaan_8 == 1) checked @endif disabled>
                            <label class="form-check-label" for="radio_pertanyaan_8">1</label>
                        </div>
                        <div class="col form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="pertanyaan_8" id="radio2_pertanyaan_8" value="2" @if($penilaian->pertanyaan_8 == 2) checked @endif disabled>
                            <label class="form-check-label" for="radio2_pertanyaan_8">2</label>
                        </div>
                        <div class="col form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="pertanyaan_8" id="radio3_pertanyaan_8" value="3" @if($penilaian->pertanyaan_8 == 3) checked @endif disabled>
                            <label class="form-check-label" for="radio3_pertanyaan_8">3</label>
                        </div>
                        <div class="col form-check form-check-inline">
                            <label class="form-check-label" for="comfort5">Sangat Baik</label>
                        </div>
                    </div>
                </div>
                <div class="hr-line-dashed"></div>
                <h3>SAFETY</h3>
                <div>
                    <label class="col-form-label">Area kerja dalam kondisi aman dan bebas dari barang, material peralatan dan mesin yang berpotensi bahaya kecelakaan kerja.(Stom 6 : Terjepit mesin, Kejatuhan benda berat, Tertabrak Kendaraan, Terjatuh dari Ketinggian, Tersengat listrik, Terkena Benda?Mesin Panas, Tergores, Tertusuk, Tersayat, Terbentur, Teperosok, dan Terpeleset).

                        <div class="row ml-sm-5 ml-3">
                            <div class="col form-check form-check-inline">
                                <label class="form-check-label" for="input1">Kurang Baik</label>
                            </div>
                            <div class="col form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="pertanyaan_9" id="radio_pertanyaan_9" value="1" @if($penilaian->pertanyaan_9 == 1) checked @endif disabled>
                                <label class="form-check-label" for="radio_pertanyaan_9">1</label>
                            </div>
                            <div class="col form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="pertanyaan_9" id="radio2_pertanyaan_9" value="2" @if($penilaian->pertanyaan_9 == 2) checked @endif disabled>
                                <label class="form-check-label" for="radio2_pertanyaan_9">2</label>
                            </div>
                            <div class="col form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="pertanyaan_9" id="radio3_pertanyaan_9" value="3" @if($penilaian->pertanyaan_9 == 3) checked @endif disabled>
                                <label class="form-check-label" for="radio3_pertanyaan_9">3</label>
                            </div>
                            <div class="col form-check form-check-inline">
                                <label class="form-check-label" for="comfort5">Sangat Baik</label>
                            </div>
                        </div>
                </div>
                <div class="hr-line-dashed"></div>
                <div>
                    <label class="col-form-label">Semua panel listrik tidak dalam kondisi terbuka, tidak terhalang benda atau barang. Wiring kabel listrik dalam kondisi rapi, tercover, tidak menjuntai, melintang, terjepit, berpotensi tersandung, dan tersengat arus, serta kondisi APAR & Hydrant di area kerja dalam kondisi mudah terlihat dan tidak terhalang atau tertutup barang.

                    </label>
                    <div class="row ml-sm-5 ml-3">
                        <div class="col form-check form-check-inline">
                            <label class="form-check-label" for="input1">Kurang Baik</label>
                        </div>
                        <div class="col form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="pertanyaan_10" id="radio_pertanyaan_10" value="1" @if($penilaian->pertanyaan_10 == 1) checked @endif disabled>
                            <label class="form-check-label" for="radio_pertanyaan_10">1</label>
                        </div>
                        <div class="col form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="pertanyaan_10" id="radio2_pertanyaan_10" value="2" @if($penilaian->pertanyaan_10 == 2) checked @endif disabled>
                            <label class="form-check-label" for="radio2_pertanyaan_10">2</label>
                        </div>
                        <div class="col form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="pertanyaan_10" id="radio3_pertanyaan_10" value="3" @if($penilaian->pertanyaan_10 == 3) checked @endif disabled>
                            <label class="form-check-label" for="radio3_pertanyaan_10">3</label>
                        </div>
                        <div class="col form-check form-check-inline">
                            <label class="form-check-label" for="comfort5">Sangat Baik</label>
                        </div>
                    </div>
                </div>
                <div class="hr-line-dashed"></div>
                <div class="form-group row">
                    <div class="col-sm-4 col-sm-offset-2">
                        <a class="btn btn-white btn-lg" href="/genba/laporan/{{ $genba_id }}">Cancel</a>
                        @if($penilaian->genba_nilai->user_id == auth()->user()->id)
                        <a class="btn btn-warning btn-lg compose_mail" href="/genba/laporan/{{ $genba_id }}/penilaian/edit/{{ $penilaian->id }}" type="submit">Edit Data</a>
                        @endif
                    </div>
                </div>
                </div> 
            </div>
        </div>
    </div>
</div>

{{-- <a class="btn btn-primary btn-sm" href="/laporan_penanggulangan" type="submit">Update Laporan</a> --}}
@endsection
