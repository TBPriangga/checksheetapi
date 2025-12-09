@extends('component.navbar')

@section('content')

@include('component.message')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>EHS Patrol</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{route('patrolEhs')}}">Table EHS Patrol</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('patrolEhsDetail', ['id' => $laporan->laporan_patrol->id])  }}" >Detail Laporan</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('detailLaporan', ['id' => $laporan->id])  }}" >Detail Temuan</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>Edit Temuan</strong>
            </li>
        </ol>
    </div>
</div>

@error('foto_temuan')
<div class="alert alert-danger">File bukti harus berbentuk gambar</div>
@enderror
<div class="modal inmodal fade" id="myModal5" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Foto Temuan</h4>
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
        </div>
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
                <form id="submitForm" method="post" action="{{route('updateForm')}}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" value={{ $laporan->id }}>
                    <input type="hidden" name="auditor_id" value={{ auth()->user()->id }}>
                    <input type="hidden" name="PIC_id" value={{ $laporan->PIC_id }}>
                    <input type="hidden" name="area_id" value={{ $laporan->area_id }}>
                    {{-- @livewire('form-area-p-i-c', ['genba_area' => $laporan->area_id, 'selectdisable' => true])
                    @stack('scripts') --}}
                    
                    {{-- <div class="hr-line-dashed"></div> --}}
                    <div class="form-group row"><label class="col-sm-2 col-form-label">Temuan</label>

                        <div class="col-sm-10"><input type="text" class="form-control" name="temuan" value="{{ $laporan->temuan }}" style="text-transform:none;"  required></div>
                    </div>

                    <div class="form-group row"><label class="col-sm-2 col-form-label">Bukti Foto</label>
                    
                        <div class="col-sm-7">
                            <div class="custom-file" style="display: flex; align-items: center;">
                                <div style="margin-right:0">
                                  <input id="logo" type="file" class="custom-file-input" name="foto_temuan" style="flex-grow: 1;">
                                  <label for="logo" id="cameraLabel" class="custom-file-label" style="margin-right:0; white-space: nowrap;">Choose file or take picture</label>
                                </div>
                                
                              </div>
                        </div>
                        

                    <div class="col-sm-1">
                        <button class="btn btn-info mt-3 mt-sm-0" data-toggle="modal" data-target="#myModal4" type="button"><i class="fa fa-paste"></i>Preview Sebelumnya</button>
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
                                    <div id="image-to-rotate1" class="ibox-content no-padding border-left-right">
                                        <img alt="image" class="img-fluid" src="{{ asset('gambar/foto_temuan/'.$laporan->foto_temuan) }}" style="width: 100%; height: 100%; object-fit: cover;">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <a id="rotate-button1" class="btn btn-white"><i class="fa fa-repeat" aria-hidden="true"></i></a>
                                    <a type="button" class="btn btn-white" data-dismiss="modal">Close</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="hr-line-dashed"></div>

                    <div class="form-group row"><label class="col-sm-2 col-form-label" >Kategori <span class="btn btn-sm btn-info" data-toggle="modal" data-target="#info_kategori"><i class="fa fa-question-circle"></i></span></label>
                        <div class="col-sm-4">
                            <select class="select2_demo_3 form-control" name="kategori" required>
                                <option></option>
                                <option value="5R" @if($laporan->kategori == "5R") selected @endif>5R</option>
                                <option value="A" @if($laporan->kategori == "A") selected @endif>A</option>
                                <option value="B" @if($laporan->kategori == "B") selected @endif>B</option>
                                <option value="C" @if($laporan->kategori == "C") selected @endif>C</option>
                                <option value="D" @if($laporan->kategori == "D") selected @endif>D</option>
                                <option value="E" @if($laporan->kategori == "E") selected @endif>E</option>
                                <option value="f" @if($laporan->kategori == "F") selected @endif>f</option>
                                <option value="G" @if($laporan->kategori == "G") selected @endif>G</option>
                                <option value="O" @if($laporan->kategori == "O") selected @endif>O</option>
                            </select>
                        </div>

                            <label class="col-sm-1 col-form-label pr-0">RANK <span class="btn btn-sm btn-info" data-toggle="modal" data-target="#info_rank"><i class="fa fa-question-circle"></i></span></label>
                            <div class="col-sm-4">
                                <select class="form-control" name="rank" required id="rankSelect">
                                    <option></option>
                                    <option value="A" @if($laporan->rank == "A") selected @endif>A</option>
                                    <option value="B" @if($laporan->rank == "B") selected @endif>B</option>
                                    <option value="C" @if($laporan->rank == "C") selected @endif>C</option>
                                </select>
                            </div>
                    </div>

                    <div class="hr-line-dashed"></div>

                    
                <div class="form-group row">
                <label class="col-sm-2 col-form-label">Due Date</label>
                        <div class="col-sm-4" id="data_1">
                            <div class="input-group date">
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control" name="deadline_date" value="@dateWithDay($laporan->deadline_date)"  id="due_date">
                            </div>
                        </div>
                </div>

                    <div class="hr-line-dashed"></div>

                    <div class="form-group row">
                        <div class="col-sm-4 col-sm-offset-2">
                            <a class="btn btn-white btn-sm" href="{{ route('detailLaporan', ['id' => $laporan->id]) }}" type="submit">Cancel</a>
                            <button id="submitButton" class="btn btn-warning btn-sm" type="submit">Save Changes</button>
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
