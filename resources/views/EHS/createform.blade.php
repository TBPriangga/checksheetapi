@extends('component.navbar')
 
@section('content')
    @include('component.message')
 
    @error('foto_temuan')
        <div class="alert alert-danger">File bukti harus berbentuk gambar</div>
    @enderror
 
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-10">
            <h2>EHS Patrol</h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ url('patrolEHS') }}">Table EHS Patrol</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ url('patrolEHS/' . $laporan->id) }}">Detail Laporan</a>
                </li>
                <li class="breadcrumb-item active">
                    <strong>Buat Temuan</strong>
                </li>
            </ol>
        </div>
    </div>
 
 
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-title bg-info">
                        <h5>Form Data</h5>
                    </div>
                    <div class="ibox-content">
                        <form id="submitForm" method="post" action="{{ route('createFormStore') }}"
                            enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="auditor_id" value={{ auth()->user()->id }}>
                            <input type="hidden" name="patrol_id" value={{ $laporan->id }}>
                            <input type="hidden" name="progress" value="0">
                            <input type="hidden" name="area_id" value={{ $laporan->area_id }}>
                            <input type="hidden" name="PIC_id" value={{ $PIC->user_id }}>
 
                            <div class="form-group row"><label class="col-sm-2 col-form-label">Temuan</label>
 
                                <div class="col-sm-10"><input type="text" class="form-control" name="temuan"
                                        value="{{ old('temuan') }}" style="text-transform:none;" required></div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Bukti Foto</label>
 
                                <div class="col">
                                    <div class="custom-file" style="display: flex; align-items: center;">
                                        <div style="margin-right:0">
                                            <input id="logo" type="file" class="custom-file-input"
                                                name="foto_temuan" required style="flex-grow: 1;">
                                            <label for="logo" id="cameraLabel" class="custom-file-label"
                                                style="margin-right:0; white-space: nowrap;">Choose file or take
                                                picture</label>
                                        </div>
 
                                    </div>
                                </div>
                            </div>
 
                            <div class="hr-line-dashed"></div>
                            <div class="form-group row"><label class="col-sm-2 col-form-label">Kategori <span class="btn btn-sm btn-info" data-toggle="modal" data-target="#info_kategori"><i class="fa fa-question-circle"></i></span></label>
 
                                <div class="col-sm-4">
                                    <select class="select2_demo_3 form-control" name="kategori" required>
 
                                        <option></option>
                                        <option value="5R" @if (old('kategori') == '5R') selected @endif>5R</option>
                                        <option value="A" @if (old('kategori') == 'A') selected @endif>A</option>
                                        <option value="B" @if (old('kategori') == 'B') selected @endif>B</option>
                                        <option value="C" @if (old('kategori') == 'C') selected @endif>C</option>
                                        <option value="D" @if (old('kategori') == 'D') selected @endif>D</option>
                                        <option value="E" @if (old('kategori') == 'E') selected @endif>E</option>
                                        <option value="F" @if (old('kategori') == 'F') selected @endif>f</option>
                                        <option value="G" @if (old('kategori') == 'G') selected @endif>G</option>
                                        <option value="O" @if (old('kategori') == 'O') selected @endif>O</option>
                                    </select>
 
                                </div>
 
 
                                <label class="col-sm-1 col-form-label pr-0">RANK <span class="btn btn-sm btn-info" data-toggle="modal" data-target="#info_rank"><i class="fa fa-question-circle"></i></span></label>
                                <div class="col-sm-4">
                                    <select class="form-control" name="rank" required id="rankSelect">
                                        <option>Select Rank</option>
                                        <option value="A" @if (old('rank') == 'A') selected @endif>A</option>
                                        <option value="B" @if (old('rank') == 'B') selected @endif>B</option>
                                        <option value="C" @if (old('rank') == 'C') selected @endif>C
                                        </option>
                                    </select>
                                </div>
                            </div>
 
 
 
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Due Date</label>
                                <div class="col-sm-4" id="data_3">
                                    <div class="input-group date">
                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input
                                            type="text" class="form-control" name="deadline_date"
                                            value="{{ date('d/m/Y') }}" id="due_date" disabled>
                                    </div>
                                </div>
                            </div>
 
 
                            <div class="hr-line-dashed"></div>
 
                            <div class="form-group row">
                                <div class="col-sm-4 col-sm-offset-2">
                                    <!-- <a class="btn btn-white btn-sm" href="/patrolEHS/{{ $laporan->id }}">kembali</a> -->
                                    <a class="btn btn-white btn-sm"
                                        href="{{ route('patrolEhsDetail', ['id' => $laporan->id]) }}">Kembali</a>
                                    <button id="submitButton" class="btn btn-primary btn-sm"
                                        type="submit">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div>
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
    </div>
@endsection
 
@section('scripts')
    <script>
        $(document).ready(function() {
            var currentDate = new Date();
            const due_date = document.getElementById('due_date');
            var rankADate = new Date();
            rankADate.setDate(currentDate.getDate() + 1);
 
            document.getElementById('rankSelect').addEventListener('change', function() {
                const selectedValue = this.value;
                if (selectedValue === 'A') {
                    rankAClick();
                } else if(selectedValue === 'B' || selectedValue === 'C') {
                    otherRankClick();
                }else{
                    selectRank();
                }
            });
 
            function rankAClick() {
                due_date.disabled = false;
                $('#data_3 .input-group.date').datepicker('remove'); // Hapus datepicker sebelumnya
                $('#data_3 .input-group.date').datepicker({
                    format: 'dd/mm/yyyy',
                    todayBtn: "linked",
                    keyboardNavigation: false,
                    forceParse: false,
                    autoclose: true,
                    startDate: currentDate,
                    endDate: rankADate,
                });
            }
 
            function otherRankClick() {
                due_date.disabled = false;
                $('#data_3 .input-group.date').datepicker('remove'); // Hapus datepicker sebelumnya
                $('#data_3 .input-group.date').datepicker({
                    format: 'dd/mm/yyyy',
                    todayBtn: "linked",
                    keyboardNavigation: false,
                    forceParse: false,
                    autoclose: true,
                    startDate: currentDate,
                });
            }
 
            function selectRank(){
                due_date.disabled = true;
            }
        });
    </script>
@endsection
