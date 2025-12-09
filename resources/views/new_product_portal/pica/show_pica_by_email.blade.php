@extends('layouts.app-master')
 
@section('title', 'AJI MIS | DELIVERY')
 
 
@section('content')

{{-- datatable library css --}}
<link href="{{asset('css/dataTables.dateTime.min.css')}}" rel="stylesheet">
<link href="{{asset('css/jquery.dataTables.min.css')}}" rel="stylesheet">
<link href="{{asset('css/plugins/select2/select2.min.css')}}" rel="stylesheet">

<link href="{{asset('css/css_agil/responsive.dataTables.css')}}" rel="stylesheet">

<!-- Sweet Alert -->
<link href="{{asset('css/plugins/sweetalert/sweetalert.css')}}" rel="stylesheet">
{{-- <div class="modal inmodal" id="myModal" tabindex="-1" data-backdrop="static"  role="dialog" aria-hidden="true">
    <div class="modal-dialog">
    <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <h4 class="modal-title">PICA</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            </div>
            <div class="modal-body">
              <form action="{{route('NewProductPortalScheduleAjiController.syncToPica')}}"  method="POST" id="upload_form"  enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id_schedule" id="id-schedule" value="{{$data}}">
                <div class="form-group">
                  <label>Type</label>
                  <select name="type" id="type" class="form-control">
                    @if ($type == "delay_start")
                      <option value="Delay Start">Delay Start</option>
                    @endif
                    @if ($type == "delay_end")
                    <option value="Delay End">Delay End</option>
                    @endif
                  </select>
                </div>
                <input type="hidden" name="dept" id="dept" value="{{ auth()->user()->department->code ?? 1 }}">
                <div class="form-group">
                  <label>Problem</label> <input type="text" name="problem" id="problem" placeholder="Problem" class="form-control">
                </div>
                <div class="form-group">
                  <label>Root cause</label> <textarea name="root_cause" placeholder="Root Cause" class="form-control"></textarea>
                </div>
                <div class="form-group">
                  <label>Counter Measure</label> <textarea name="countermeasure" placeholder="Counter Measure" class="form-control"></textarea>
                </div>
                <div class="form-group">
                  <label>Due Date</label> <input type="date" name="due_date" id="due_date" placeholder="Due date" class="form-control" required>
                </div>
                <div class="form-group">
                  <label>Attachment not required (image)</label>
                  <div class="custom-file">
                      <input id="logo" type="file" class="custom-file-input" name="file" >
                      <label for="logo" class="custom-file-label">Choose file...</label>
                  </div>
                </div>
            </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary btn_submit">Submit</button>
            </div>
        </div>
    </div>
  </div> --}}
  <div class="modal inmodal" id="myModal" tabindex="-1" data-backdrop="static"  role="dialog" aria-hidden="true">
    <div class="modal-dialog">
    <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <h4 class="modal-title">PICA</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            </div>
            <div class="modal-body">
              <form action="{{route('NewProductPortalScheduleAjiController.syncToPica')}}"  method="POST" id="upload_form"  enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id_schedule" id="id-schedule" value="{{$data}}">
                <div class="form-group">
                  <label>Type</label>
                  <select name="type" id="type" class="form-control">
                    @if ($type == "delay_start")
                      <option value="Delay Start">Delay Start</option>
                    @endif
                    @if ($type == "delay_end")
                    <option value="Delay End">Delay End</option>
                    @endif
                  </select>
                </div>
                <input type="hidden" name="dept" id="dept" value="{{ auth()->user()->department->code }}">
                <div class="form-group">
                  <label>Problem</label> <input type="text" name="problem" id="problem" placeholder="Problem" class="form-control">
                </div>
                <div class="form-group">
                  <label>Root cause</label> <textarea name="root_cause" placeholder="Root Cause" class="form-control"></textarea>
                </div>
                <div class="form-group">
                  <label>Counter Measure</label> <textarea name="countermeasure" placeholder="Counter Measure" class="form-control"></textarea>
                </div>
                <div class="form-group">
                  <label>Due Date</label> <input type="date" name="due_date" id="due_date" placeholder="Due date" class="form-control" required>
                </div>
                <div class="form-group">
                  <label>Attachment not required </label>
                  <div class="custom-file">
                      <input id="logo" type="file" class="custom-file-input" name="file" >
                      <label for="logo" class="custom-file-label">Choose file...</label>
                  </div>
                </div>
              </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary btn_submit">Submit</button>
            </div>
        </div>
    </div>
  </div>
  
  

  
@endsection

@push('scripts')
  <script src="{{asset('js/jquery.dataTables.min.js')}}"></script>
  <script src="{{asset('js/dataTables.dateTime.min.js')}}"></script>
  <script src="{{asset('js/plugins/select2/select2.full.min.js')}}"></script>
  <script src="{{asset('js/js_agil/dataTables.responsive.js')}}"></script>
  <script src="{{asset('js/moment.min.js')}}"></script>
  <script src="{{asset('js/plugins/sweetalert/sweetalert.min.js')}}"></script>

  <script>
    $(document).ready(function(){
        $("#myModal").modal("show");
        $('.btn_submit').click(function() {
                    var problem = $('#problem').val();
                      var due_date = $('#due_date').val();
                      if (problem === '') {
                        swal("Oops!", "Please enter the problem.", "error");
                        return;
                      }
                      if (due_date === '') {
                        swal("Oops!", "Please enter due date.", "error");
                        return;
                      }

                    $('#upload_form').submit();
        });
        // check input
        $('.custom-file-input').on('change', function() {
                        let fileName = $(this).val().split('\\').pop();
                        var ext = fileName.split('.').pop();
                        if ( 
                              ext == "png" || ext == "PNG" ||
                              ext == "JPG"|| ext == "jpg" ||
                              ext == "JPEG"|| ext == "jpeg" || 
                              ext == "pdf" || ext == "PDF" || 
                              ext =="pptx" || ext =="docx"|| 
                              ext =="PPTX" || ext =="DOCX"||
                              ext =="XLS" || ext =="XLSX"||
                              ext =="xls" || ext =="xlsx"
                            )
                        {
                            $(this).next('.custom-file-label').addClass("selected").html(fileName);
                        } else {
                            $(this).html("");
                            swal("Oops!", "file type not allowed!", "error");
                        }
                    }); 
    });
  </script>
@endpush