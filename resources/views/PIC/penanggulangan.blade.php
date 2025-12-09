 @extends('component.navbar')


@section('content')


@include('component.message')


{{-- <div class="modal inmodal fade" id="myModal5" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Gambar Penanggulangan</h4>
            </div>
            <div class="modal-body">
                <div id="cameraOutput"></div>
            </div>
        </div>
    </div>
</div> --}}


<div class="modal inmodal" id="myModalFoto" tabindex="-1" role="dialog"  aria-hidden="true">
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
                <button id="rotate-button1" class="btn btn-white"><i class="fa fa-repeat" aria-hidden="true"></i></button>
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
                <a href="{{url('patrolEHS')}}">Table EHS Patrol</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{url('patrolEHS/'.$laporan->laporan_patrol->id)}}" >Detail Laporan</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{url('/detail/'. $laporan->id)}}" >Detail Temuan</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>Update Perbaikan</strong>
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
                <strong>Form Penanggulangan</strong>
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
                   
                <div class="col-sm-4">
                    <div class="custom-file">
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
                <form id="submitForm" method="post" action="{{route('laporanPenanggulanganStore')}}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" value={{ $laporan->id }} name="laporan_id">
                    <input type="hidden" value={{ $laporan->progress }} id="progress_default" name="progress_default">
                    @if($inputSementara)
                    <div class="form-group row"><label class="col-sm-2 col-form-label">Catatan Perbaikan Sementara</label>


                        <div class="col-sm-10  @error('temporary_solution') has-error  @enderror"><input type="text" class="form-control" name="temporary_solution" @if($laporan->temporary_solution == null) value="{{ old('temporary_solution') }}" @else value="{{ $laporan->temporary_solution }}" @endif  required></div>
                    </div>
                    @else
                    <input type=hidden name="temporary_solution" value="-">
                    @endif


                    <div class="form-group row"><label class="col-sm-2 col-form-label">Penanggulangan </label>
                        <div class="col-sm-10  @error('penanggulangan') has-error  @enderror" >
                            <input type="text" style="text-transform:none;"  class="form-control" name="penanggulangan" @if($laporan->penanggulangan == null) value="{{ old('penanggulangan') }}" @else value="{{ $laporan->penanggulangan }}" @endif  >
                            <small id="noteWO" style="display: none;"><strong>Note : Mohon cantumkan nomer WO jika penanggulangan memerlukan WO</strong></small>
                            @error('penanggulangan')
                            <code>
                                {{ $message }}
                            </code>
                            @enderror</div>
                       
                    </div>




                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Need Support</label>
                        <div class="col-lg-10 mt-2 d-flex">
                            <div class="form-check mr-3">
                                <input class="form-check-input wo-checkbox" type="checkbox" name="wo" value="PE" id="peCheck"
                                @if ($laporan->wo == 'PE') checked @endif>
                                <label class="form-check-label" for="peCheck">
                                    PE
                                </label>
                            </div>
                            <div class="form-check mr-3">
                                <input class="form-check-input wo-checkbox" type="checkbox" name="wo" value="ME" id="meCheck"
                                @if ($laporan->wo == 'ME') checked @endif>
                                <label class="form-check-label" for="meCheck">
                                    ME
                                </label>
                            </div>
                            <div class="form-check mr-3">
                                <input class="form-check-input wo-checkbox" type="checkbox" name="wo" value="GA" id="jeCheck"
                                @if ($laporan->wo == 'GA') checked @endif>
                                <label class="form-check-label" for="jeCheck">
                                    GA
                                </label>
                            </div>
                        </div>
                       
                        {{-- <input type="hidden" id="sliderValue" name="progress"> --}}
                    </div>
                    @if ($laporan->wo != null)
                    <div id="nomerWO" @if ($laporan->wo != null)  @else style="display: none;" @endif >
                        <div class="form-group row d-flex" >
                            <label class="col-sm-2 col-form-label">Nomer WO</label>
                            <div class="col-lg-10 ">
                                <input type="text" class="form-control" value="{{$laporan->noWO}}" name="noWO">
                            </div>
                           
                        </div>
                    </div>
                    @else
                    <div id="nomerWO" @if ($laporan->wo != null)  @else style="display: none;" @endif >
                        <div class="form-group row d-flex" >
                            <label class="col-sm-2 col-form-label">Nomer WO</label>
                            <div class="col-lg-10 ">
                                <input type="text" class="form-control" name="noWO">
                            </div>
                           
                        </div>
                    </div>
                    @endif
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Progress</label>
                        <div class="col-lg-10 mt-2 ">
                            <div id="basic_slider"></div>
                            <div class="mt-2" id="percentageDisplay"></div>
                        </div>
                        <input type="hidden" id="sliderValue" name="progress">
                    </div>
                    <p><strong>Keterangan Progress :</strong></p>
                             <div id="noteProgress" class="pl-2">
                                 <p><strong>0%</strong> Belum ada perbaikan</p>
                                 <p><strong>25%</strong> Sedang Proses Perbaikan</p>
                                 <p><strong>50%</strong> Telah selesai dilakukan Perbaikan</p>
                                 <p><strong>75%</strong> Telah selesai dilakukan Perbaikan namun belum efektif
                                     diimplementasikan</p>
                                 <p><strong>100%</strong> Telah selesai dilakukan Perbaikan dan diimplementasikan dengan
                                     efektif</p>


                             </div>

                   
                    <div class="hr-line-dashed"></div>
@if($laporan->foto_penanggulangan == null)
                    <div class="form-group row"><label class="col-sm-2 col-form-label">Foto Perbaikan</label>


                        <div class="col-sm-10 ">
                            <div class="custom-file" style="display: flex; align-items: center;">
                                <div class="col" style="margin-right:0">
                                  <input id="logo" type="file" class="custom-file-input" name="foto_penanggulangan" style="flex-grow: 1;">
                                  <label for="logo" id="cameraLabel" class="custom-file-label" style="margin-right:0; white-space: nowrap;">Choose file or take picture</label>
                                </div>
                                {{-- <div class="col-2" style="padding:0; margin:0;">
                                  <button type="button" id="openCameraButtonPenanggulangan" style="border: 0;" data-toggle="modal" data-target="#myModal5">
                                      <img src="{{ asset('kamera.png') }}" alt="Logo Camera" style="height: 34px;">
                                  </button>
                                </div> --}}
                              </div>
                            @error('foto_penanggulangan')
                            <code>
                                {{ $message }}
                            </code>
                            @enderror
                    </div>
                    </div>
@else
                    <div class="form-group row"><label class="col-sm-2 col-form-label">Foto Perbaikan</label>


                        <div class="col-sm-7">
                            <div class="custom-file" style="display: flex; align-items: center;">
                                <div class="col" style="margin-right:0">
                                  <input id="logo" type="file" class="custom-file-input" name="foto_penanggulangan" style="flex-grow: 1;">
                                  <label for="logo" id="cameraLabel" class="custom-file-label" style="margin-right:0; white-space: nowrap;">Choose file...</label>
                                </div>
                                {{-- <div class="col-2" style="padding:0; margin:0;">
                                  <button type="button" id="openCameraButtonPenanggulangan" style="border: 0;" data-toggle="modal" data-target="#myModal5">
                                      <img src="{{ asset('kamera.png') }}" alt="Logo Camera" style="height: 34px;">
                                  </button>
                                </div> --}}
                              </div>
                            @error('foto_penanggulangan')
                            <code>
                                {{ $message }}
                            </code>
                            @enderror
                        </div>


                    <div class="col-sm-2">
                        <button class="btn btn-info" data-toggle="modal" data-target="#myModal4" type="button"><i class="fa fa-paste"></i>Preview Sebelumnya</button>
                       
                    </div>


                    <div class="modal inmodal" id="myModal4" tabindex="-1" role="dialog"  aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content animated fadeIn">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                    <h4 class="modal-title">Foto Perbaikan</h4>
                                    <small>Penanggulangan berupa {{ $laporan->penanggulangan }} yang dikerjakan oleh {{ $laporan->PIC->name }} pada tanggal {{ $laporan->PIC_submit_at }}</small>
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
                    </div>
@endif


                    <div class="hr-line-dashed"></div>


                    @if ($laporan->status_due_date_lanjutan )
                    <div class="form-group row">
                        <label class="col-sm-2  form-label">Due Date Lanjutan</label>
                                <div class="col-sm-4 " id="data_3">
                                    <div class="input-group date">
                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control" name="deadline_date_lanjutan" value="{{ date('d/m/Y') }}">
                                    </div>
                                </div>
                    </div>
                    @endif
                    <div class="hr-line-dashed"></div>
                    <div class="form-group row">
                        <div class="col-sm-4 col-sm-offset-2">
                            <a class="btn btn-white btn-sm" href="{{route('detailLaporan',['id' => $laporan->id])}}" type="submit">Cancel</a>
                            <button id="submitButton" class="btn btn-primary btn-sm" type="submit" disabled>Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>
@endsection




@section('scripts')
<script>
    var peCheck = document.getElementById('peCheck');
    var meCheck = document.getElementById('meCheck');
    var jeCheck = document.getElementById('jeCheck');
    var noteWO = document.getElementById('noteWO');
    var tidakWO = document.getElementById('tidakWO');
    var nomerWO = document.getElementById('nomerWO');


    peCheck.addEventListener('change',function(){
        if (peCheck.checked) {
            noteWO.style.display = 'block';
            nomerWO.style.display = 'block';
        } else {
            noteWO.style.display = 'none';
            nomerWO.style.display = 'none';
        }
    });
    meCheck.addEventListener('change',function(){
        if (meCheck.checked) {
            noteWO.style.display = 'block';
            nomerWO.style.display = 'block';
        } else {
            noteWO.style.display = 'none';
            nomerWO.style.display = 'none';
        }
    });
    jeCheck.addEventListener('change',function(){
        if (jeCheck.checked) {
            noteWO.style.display = 'block';
            nomerWO.style.display = 'block';
        } else {
            noteWO.style.display = 'none';
            nomerWO.style.display = 'none';
        }
    });
   


    document.querySelectorAll('.wo-checkbox').forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            if (this.checked) {
                document.querySelectorAll('.wo-checkbox').forEach(box => {
                    if (box !== this) {
                        box.checked = false;
                    }
                });
            }
        });
    });






</script>
@endsection
{{--
@section('scripts')
<script>


document.addEventListener('DOMContentLoaded', function () {


    var openCameraButton = document.getElementById('openCameraButtonPenanggulangan');
    var fileInput = document.getElementById('logo');
    var cameraOutput = document.getElementById('cameraOutput');
    var gambar = false;
    var video;
    var stream;


    openCameraButton.addEventListener('click', function () {
        if (!gambar) {
            navigator.mediaDevices.getUserMedia({ video: true })
                .then(function (str) {
                    stream = str;
                    video = document.createElement('video');
                    video.srcObject = stream;
                    video.autoplay = true;


                    cameraOutput.innerHTML = '';
                    cameraOutput.appendChild(video);


                    var takePhotoButton = document.createElement('button');
                    takePhotoButton.textContent = 'Take Photo';
                    takePhotoButton.classList.add('btn', 'btn-success', 'centered', 'mt-3');
                    takePhotoButton.addEventListener('click', takePhoto);
                    cameraOutput.appendChild(takePhotoButton);
                })
                .catch(function (err) {
                    console.error('Error accessing camera: ', err);
                });
        }
    });


    function takePhoto() {
        gambar = true;
        var canvas = document.createElement('canvas');
        var context = canvas.getContext('2d');
        canvas.width = video.videoWidth;
        canvas.height = video.videoHeight;
        context.drawImage(video, 0, 0, canvas.width, canvas.height);


        canvas.toBlob(function (blob) {
            simpanGambarKeInputFileCustom(blob);
            var newImage = document.createElement('img');
            newImage.src = URL.createObjectURL(blob);
            cameraOutput.innerHTML = '';
            cameraOutput.appendChild(newImage);


            var retakePhotoButton = document.createElement('button');
            retakePhotoButton.textContent = 'Ambil Foto Ulang';
            retakePhotoButton.classList.add('btn', 'btn-success', 'centered', 'mt-3');
            retakePhotoButton.addEventListener('click', function () {
                gambar = false;
                cameraOutput.innerHTML = '';
                $('.custom-file-label').addClass("selected").html("choose file...");
                $('#myModal5').modal('hide');
                // Stop the stream only if it exists
                if (stream) {
                    stream.getTracks().forEach(function (track) {
                        track.stop();
                    });
                }
            });
            cameraOutput.appendChild(retakePhotoButton);
            if (stream) {
                stream.getTracks().forEach(function (track) {
                    track.stop();
                });
            }
            var fileName = 'photo.jpg';
            $('.custom-file-label').addClass("selected").html(fileName);
            $('#myModal5').modal('hide'); // Hide modal after taking photo
        }, 'image/jpeg');
    }


function simpanGambarKeInputFileCustom(blob) {
//         // Buat elemen input baru
        var newInput = document.createElement('input');
        newInput.type = 'file';
        newInput.id = 'logo';
        newInput.name = 'foto_penanggulangan';
        newInput.className = 'custom-file-input';
        newInput.required = true;


        // Buat objek File dari blob gambar
        var file = new File([blob], 'photo.jpg', { type: 'image/jpeg' });


        // // Buat FileList baru dan tambahkan objek File ke dalamnya
        var fileList = new DataTransfer();
        fileList.items.add(file);


        // // Atur FileList ke dalam elemen input file
        newInput.files = fileList.files;


        // Gantikan elemen input yang lama dengan yang baru
        var oldInput = document.getElementById('logo');
        console.log(newInput);
        oldInput.parentNode.replaceChild(newInput, oldInput);


    }
});


</script>


@endsection --}}
