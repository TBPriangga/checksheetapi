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


<div class="ibox" >
  <div class="ibox-title">
      <h4>Schedule</h4>
  </div>
  <div class="ibox-content" >
    <div>
      @if(session()->has('success'))
          <div class="alert alert-primary">{{session('success')}}</div>
      @endif
      @if(session()->has('fail'))
          <div class="alert alert-danger">{{session('fail')}}</div>
      @endif
    </div>
    {{-- <div class="row mb-2">
      <div class="col-sm-4">
          <label for="">Project</label>
          <select name="project_title" class="select2 form-control" id="project_title_dropdown" required>
              <option value="-">all</option>
              @foreach ($project_titles as $title)
                  <option value="{{$title->project_title}}">{{$title->project_title}}</option>
              @endforeach
          </select>
      </div>
      <div class="col-sm-4">
          <label for="">PIC</label>
          <select name="project_title" class="select2 form-control" id="depts_dropdown" required>
              <option value="-">all</option>
              @foreach ($depts as $dept)
                  <option value="{{$dept->code}}">{{$dept->code}}</option>
              @endforeach
          </select>
      </div>
      <div class="col-sm-4 text-right">
        <button class="btn btn-white btn-bitbucket sync"><i class="fa fa-exchange"></i></button>
      </div>
    </div> --}}
    <div style="overflow-x:auto">
      <table id="master" class="table table-bordered">
        <thead>
          <tr>
            <th rowspan="2" class="text-center align-middle">No</th>
            <th rowspan="2" class="text-center align-middle" >customer </th>
            <th rowspan="2" class="text-center align-middle" >project </th>
            <th rowspan="2" class="text-center align-middle" >product </th>
            <th rowspan="2" class="text-center align-middle" data-priority="1">Status</th>
            {{-- <th rowspan="2" class="text-center align-middle">milestone</th> --}}
            <th rowspan="2" class="text-center align-middle" >event</th>
            <th rowspan="2" class="text-center align-middle">description</th>
            <th rowspan="2" class="text-center align-middle" >pic</th>
            <th rowspan="2" class="text-center align-middle">koordinasi</th>
            <th rowspan="2" class="text-center align-middle">urgensi</th>
            <th rowspan="2" class="text-center  align-middle" >progress (%)</th>
            <th colspan="2" class="text-center" >Plan</th>
            <th colspan="2" class="text-center" >Actual</th>
            <th class="text-center align-middle" rowspan="2">Days Plan</th>
            <th class="text-center align-middle" rowspan="2">Days Actual</th>
            <th class="text-center  align-middle" rowspan="2">Action</th>
            <th class="text-center  align-middle" rowspan="2">Check List</th>
            <th class="text-center  align-middle" rowspan="2">PICA</th>
            <th class="text-center  align-middle" rowspan="2">Judge (NPD)</th>
          </tr>
          <tr>
            <th class="text-center"> start</th>
            <th class="text-center"> end</th>
            <th class="text-center"> start</th>
            <th class="text-center"> end</th>
          </tr>
        </thead>
        <tbody>
        </tbody>
      </table>
    </div>
  </div>
  <div class="ibox-footer">
    <button class="btn  btn-default " onClick="history.back()">Back</button>
  </div>
</div>

<div class="modal inmodal" id="myModal" tabindex="-1" data-backdrop="static" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content animated bounceInRight">
      <div class="modal-header">
        <h4 class="modal-title">PICA</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
      </div>
      <div class="modal-body">
        <form action="{{route('NewProductPortalScheduleAjiController.syncToPica')}}" method="POST" id="upload_form"
          enctype="multipart/form-data">
          @csrf
          <input type="hidden" name="id_schedule" id="id-schedule" value="">
          <input type="hidden" name="pica_tambah" id="pica_tambah" value="0">
          <div class="form-group">
            <label>Type</label>
            <select name="type" id="type" class="form-control">
              <option value="Delay Start">Delay Start</option>
              <option value="Delay End">Delay End</option>
            </select>
          </div>
          <input type="hidden" name="dept" id="dept" value="{{ auth()->user()->department->code }}">
          <div class="form-group">
            <label>Problem</label> <input type="text" name="problem" id="problem" placeholder="Problem"
              class="form-control" autocomplete="off">
          </div>
          <div class="form-group">
            <label>Category</label> 
            <select class="form-control" name="category_problem" id="category_problem">
              <option value="General">General</option>
              @foreach ($category_problem as $item)
                <option value="{{$item->category}}">{{$item->category}}</option>
              @endforeach
            </select>
          </div>
          <div class="form-group">
            <label>Root cause</label> <textarea name="root_cause" placeholder="Root Cause"
              class="form-control" autocomplete="off"></textarea>
          </div>
          <div class="form-group">
            <label>Counter Measure</label> <textarea name="countermeasure" placeholder="Counter Measure"
              class="form-control" autocomplete="off"></textarea>
          </div>
          <div class="form-group">
            <label>Due Date</label> <input type="date" name="due_date" id="due_date" placeholder="Due date"
              class="form-control" required>
          </div>
          <div class="form-group">
            <label>Attachment not required </label>
            <div class="custom-file">
              <input id="logo" type="file" class="custom-file-input" name="file">
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


<div class="modal inmodal" id="checklist_modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content animated bounceInRight">
      <div class="modal-header">
        <h4 class="modal-title title-checklist">Check List</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{route('history_form_event.insert')}}"  method="POST" id="checklist_form" enctype="multipart/form-data">
        @csrf
        @method('POST')
        <input type="hidden" name="id_event" id="id_event" value="">
        <input type="hidden" name="project" id="project" value="">
        <input type="hidden" name="pic" id="pic" value="">
        <input type="hidden" name="form_type" id="form_type" value="">
        <input type="hidden" name="jenis_form" id="jenis_form" value="">
      <div class="modal-body checklist-body">
          <!-- Add your form elements here -->
      </div>
      <div class="modal-footer checklist_footer">
      </div>
    </form>
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
      // iframe disable rigth click
      $(document). bind("contextmenu",function(e){ return false; });
      

      $(document).ready(function(){
        // minimalize navbar
          $(".navbar-minimalize").trigger("click");
        // font kecil
          $(".ibox").css({fontSize:9, textTransform:'Uppercase'});
          $("th").css({fontSize:9, textTransform:'Uppercase'});
        
        // datatable
          var table = $('#master').DataTable( {
              'responsive': true,
              'columnDefs': [
              ],
              "processing": true,
              "serverSide": true,
              "filter":true,
              "ajax": {
                          "url": "{{route('NewProductPortalScheduleAjiController.index_notification', ['id'=> $id])}}",
                          "data":function (d) {
                            d.project_title = $('#project_title_dropdown').val();
                            d.dept = $('#depts_dropdown').val();
                      },
              },
              "columns": [
                  { data: null, className: 'dt-body-center'},
                  { data: 'customer', className: 'dt-body-center'},
                  { data: 'project_title', className: 'dt-body-center'},
                  { data: 'product', className: 'dt-body-center'},
                  { data: 'status', className: 'dt-body-center status' },
                  // { data: 'milestone', className: 'dt-body-center'},
                  { data: 'event', className: 'dt-body-center'},
                  { data: 'detail_description', className: 'dt-body-center'},
                  { data: 'pic', className: 'dt-body-center'},
                  { data: 'koordinasi', className: 'dt-body-center'},
                  { data: 'urgent', className: 'dt-body-center', 'render': function(data){
                    if (data == "1") {
                      return "Normal";
                    } else if (data == "2") {
                      return "Urgent";
                    } else if (data == "3") {
                      return "Top Urgent";
                    }
                  }},
                  { data: 'progress', className: 'dt-body-center',
                          'render': function(data, type, row){
                            progress_value= 0;
                            if (data == null) {
                              
                            } else {
                              progress_value = data;
                              // var persen = (progress_value/row['total_checklist'])*100;
                            }
                            var dept = "{{ auth()->user()->department->code }}";
                            var color_progress= "";

                            // cek progress bar
                            if (progress_value >0 && progress_value< 100) {
                              color_progress = "progress-bar-striped progress-bar-animated progress-bar-success";
                            } 


                            // var input_no = '<div class="input-group mt-2" style="width:90px;"><input type="number" style="font-size:9px;" value="'+progress_value+'" max="'+row["total_checklist"]+'" min="'+row["current_checklist"]+'" class="form-control form-control-sm" id="progress_value_'+row["id"]+'"> <span class="input-group-append"> <button data-min-value="'+progress_value+'" data-id="'+row["id"]+'" type="button" class="btn btn-primary btn-xs btn_progress">Set</button> </span></div>';
                            
                            var progress = '<div class="progress" ><div class="progress-bar '+color_progress+'" style="width: '+progress_value+'%" role="progressbar" aria-valuenow="'+progress_value+'" aria-valuemin="'+progress_value+'" aria-valuemax="100"></div></div>';
                            // var by_name = (row['progress_by'] !== null) ? row['progress_by']: '';     
                            

                              // if (row['actual_start'] == null) {
                              //   return "";
                              // } else {
                              //   // cek apakah data pic sama dengan dept user 
                              //   if (row['pic'].toUpperCase() == dept.toUpperCase()) {
                              //     return progress+input_no+by_name;
                              //   }
                              //   return progress+by_name;
                              // }
                              return progress;
                          }},
                  { data: 'plan_start', className: 'dt-body-center',
                          'render':function(data, type, row){
                            var plan_start_time = data;
                            var by_name = row['plan_start_by'];     

                            // cek button ketika null ada input date dan button
                            if (plan_start_time == null) {
                              // cek apakah data pic sama dengan dept user 
                                  var dept = "{{ auth()->user()->department->code }}";
                                  if (row['pic'].toUpperCase() == dept.toUpperCase()) {
                                    return "<div class='input-group'><input type='date' id='plan_start_"+row["id"]+"' class='form-control' style='font-size:10px;max-width:70px'><span class='input-group-append'><button data-id='"+row["id"]+"' class='btn btn-primary btn-sm btn_plan_start'>set</button></span></div>";
                                  }
                                  return "";
                            } else {
                              return moment(moment(plan_start_time)).format("DD/MM/YYYY")+"</br>";
                            }
                          },
                  },
                  { data: 'plan_end', className: 'dt-body-center',
                          'render':function(data, type, row){
                            var plan_end_time = data;
                            var by_name = row['plan_end_by'];     

                            // cek button ketika null ada input date dan button
                            if (plan_end_time == null) {
                              // cek apakah data pic sama dengan dept user 
                                  var dept = "{{ auth()->user()->department->code }}";
                                  if (row['pic'].toUpperCase() == dept.toUpperCase()) {
                                    return "<div class='input-group'><input type='date' id='plan_end_"+row["id"]+"' class='form-control' style='font-size:10px;max-width:70px'><span class='input-group-append'><button data-id='"+row["id"]+"' class='btn btn-primary btn-sm btn_plan_end'>set</button></span></div>";
                                  }
                                  return "";
                            } else {
                              return moment(moment(plan_end_time)).format("DD/MM/YYYY")+"</br>";
                            }
                  }},
                  { data: 'actual_start', className: 'dt-body-center',
                          'render':function(data, type, row){
                            var start_time = data;
                            var by_name = row['actual_start_by'];     

                            // cek button ketika null ada input date dan button
                            if (row["plan_start"] == null || row["plan_end"] == null) {
                              return "";
                            }else if (start_time == null) {
                              // cek apakah data pic sama dengan dept user 
                                  var dept = "{{ auth()->user()->detail_department->code }}";
                                  if (row['pic'].toUpperCase() == dept.toUpperCase()) {
                                    return "<button data-id='"+row["id"]+"' data-plan-time='"+row["plan_start"]+"' class='btn btn-primary btn-sm btn_start'>start</button>";
                                  }
                                  return "";
                            } else {
                              return moment(moment(start_time)).format("DD/MM/YYYY")+"</br>";
                            }
                  }},
                  { data: 'actual_end', className: 'dt-body-center',
                          'render':function(data, type, row){
                            var end_time = data;
                            var by_name = row['actual_end_by'];     

                            // cek button ketika null ada input date dan button
                            if (row["actual_start"] == null) {
                              return "";
                            }else if (end_time == null || row['progress'] != 100) {
                              // cek apakah data pic sama dengan dept user 
                                  var dept = "{{ auth()->user()->detail_department->code }}";
                                  // if (row['pic'].toUpperCase() == dept.toUpperCase()){
                                  //   return "<button data-id='"+row["id"]+"' data-plan-time='"+row["plan_end"]+"' class='btn btn-primary btn-sm btn_end'>end</button>";
                                  // } 
                                  return "";
                            }  else {
                              return moment(moment(end_time)).format("DD/MM/YYYY")+"</br>";
                            }
                  }},
                  { data: 'plan_days', className: 'dt-body-center'},
                  { data: 'actual_days', className: 'dt-body-center'},
                  { data: 'id', className: 'dt-body-center',
                          'render': function(data, type, row){
                            
                            return "<div class='btn-group'><a href='{{URL::to('/')}}/NewProductPortal/schedule/"+data+"/edit_aji_internal' class='btn btn-xs btn-default'><i class='fa fa-pencil'></i></a><a onClick='return confirm("+'"are you sure  ?"'+")' href='{{URL::to('/')}}/NewProductPortal/schedule/"+data+"/delete_aji_internal' class='btn btn-xs btn-danger'><i class='fa fa-trash'></i></a></div>";

                          }
                  },
                  { data: 'id', className: 'dt-body-center', 'render': function(data, type, row){
                    var milestone = row['milestone'];
                    var event = row['event'];
                    var project = row['project_title'];
                    var detail_descrption = row['detail_description'];
                    var id = data;
                    var dept = "{{ auth()->user()->detail_department->code }}";
                    

                    // button dimunculkan ke semua user, namun checklist nya saja yg berbeda tampilan,
                    // pic bisa isi checklist
                    // bukan pic hanya bisa melihat checklist
                    // Admin NPD bisa isi dan uncheck checklist sama seperti pic
                    if (row['actual_start'] != null) {
                    return "<button class='btn btn-default checklist' data-id='"+id+"' data-project='"+project+"' data-milestone='"+milestone+"' data-pic='"+row['pic']+"' data-event='"+event+"' data-detail-description='"+detail_descrption+"'>Open</button>";
                    }else{
                        return '';
                    }
                  }},
                  { data: 'id', className: 'dt-body-center', 'render': function(data, type, row){
                    var milestone = row['milestone'];
                    var event = row['event'];
                    var detail_descrption = row['detail_description'];
                    var id = data;
                    var dept = "{{ auth()->user()->detail_department->code }}";

                    // cek apakah data pic sama dengan dept user 
                    if (row['pic'].toUpperCase() == dept.toUpperCase()) {
                      return "<button class='btn btn-default pica_btn' data-id='"+id+"' data-milestone='"+milestone+"' data-event='"+event+"' data-detail-description='"+detail_descrption+"'>Open</button>";
                    }else{
                      return '';
                    }
                  }},
                  {
                    data: 'id',
                    className: 'dt-body-center',
                    render: function(data, type, row) {
                      var roles = "{{ auth()->user()->roles->pluck('name') }}"; 
                      var judge = row['judge'];
                      
                      if (row['progress'] == 100 && roles.includes("APQP Uploader") && judge == null) {
                        return "<button class='btn btn-primary btn-md judge_btn' data-judge='1' data-id='" + data + "'>OK</button> <button class='btn btn-danger btn-md judge_btn' data-judge='0' data-id='" + data + "'>NG</button>";
                      } else if (judge != null) {
                        return (judge == 1) ? "OK" : "NG";
                      }else{
                        return '';
                      }
                    }
                  }

              ],
              "columnDefs": [ {
                  "searchable": true,
                  "orderable": true,
                  "targets": 0
              } ],
              "order": [],
              "initComplete": function(settings, json) {
                // submit form pica
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
                // upload file 
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
                            ){
                            $(this).next('.custom-file-label').addClass("selected").html(fileName);
                        } else {
                            $(this).html("");
                            swal("Oops!", "file type not allowed!", "error");
                        }
                    }); 

                // trigger ke table pica
                    $(".sync").click(function(){
                          // kirim ke table pica tapi cek dahulu id nya sudah ada atau belum ketika sudah ada tidak perlu insert
                          $.ajax({
                              url: "{{route('NewProductPortalScheduleAjiController.syncToPica')}}",
                              type: "post",
                              data: {
                                  _token: '{{csrf_token()}}',
                              },
                              dataType: 'json',
                              success: function (res) {
                                  if (res == "0") {
                                    swal("Oops!", "Sync error!", "error");
                                  } else {
                                    swal("success!", "Sync success!", "success");
                                  }
                              } 
                          });
                      }
                    );
                            
                // button set progress 
                    $("#master").on("click",".btn_progress",function(){
                      var id = $(this).attr("data-id");
                      var min_progress_value = $(this).attr('data-min-value');
                      var progress_value= $("#progress_value_"+id).val();

                      if (parseInt(progress_value) <= parseInt(min_progress_value)  || parseInt(progress_value) >= parseInt('101')) {
                        swal("Oops!", "failed set progress value!", "error");
                      }else{
                        // ajax update nilai progress
                        $.ajax({
                            url: "{{route('NewProductPortalScheduleAjiController.update_progress')}}",
                            type: "post",
                            data: {
                                progress_value: progress_value,
                                _token: '{{csrf_token()}}',
                                id:id,
                            },
                            dataType: 'json',
                            success: function (res) {
                                if (res == "1") {
                                  swal("success!", "Progress value updated!", "success");
                                  setTimeout(() => {
                                    location.reload();
                                  }, 2000);
                                } else {
                                  swal("Oops!", "failed update progress value!", "error");
                                }
                            }
                        });
                        // lalu trigger update table 
                      }
                    });
                // button set plan start time
                    $("#master").on("click",".btn_plan_start",function(){
                      var id = $(this).attr('data-id');
                      var plan_start_time= $("#plan_start_"+id).val();

                      if (plan_start_time == "") {
                        swal("Oops!", "Set date plan start!", "error");
                      }else{
                        // ajax insert date
                          $.ajax({
                              url: "{{route('NewProductPortalScheduleAjiController.update_plan_start')}}",
                              type: "post",
                              data: {
                                  plan_start_time: plan_start_time,
                                  _token: '{{csrf_token()}}',
                                  id:id,
                              },
                              dataType: 'json',
                              success: function (res) {
                                  if (res == "1") {
                                    swal("success!", "Plan start inserted!", "success");
                                    setTimeout(() => {
                                      location.reload();
                                    }, 2000);
                                  } else {
                                    swal("Oops!", "failed insert Plan start!", "error");
                                  }
                              }
                          });
                      }
                    });
                // button set plan end time
                    $("#master").on("click",".btn_plan_end",function(){
                      var id = $(this).attr('data-id');
                      var plan_end_time= $("#plan_end_"+id).val();

                      if (plan_end_time == "") {
                        swal("Oops!", "Set date plan end!", "error");
                      }else{
                        // ajax insert date
                          $.ajax({
                              url: "{{route('NewProductPortalScheduleAjiController.update_plan_end')}}",
                              type: "post",
                              data: {
                                  plan_end_time: plan_end_time,
                                  _token: '{{csrf_token()}}',
                                  id:id,
                              },
                              dataType: 'json',
                              success: function (res) {
                                  if (res == "1") {
                                    swal("success!", "Plan end inserted!", "success");
                                    setTimeout(() => {
                                      location.reload();
                                    }, 2000);
                                  } else {
                                    swal("Oops!", "failed insert plan end!", "error");
                                  }
                              }
                          });
                      }
                    });
                // button set actual start
                    $("#master").on("click",".btn_start",function(){
                      var id = $(this).attr('data-id');
                      var plan_time = $(this).attr('data-plan-time');
                      $("#id-schedule").val(id);
                      $("#type").val("Delay Start");
                      // ajax insert date
                      $.ajax({
                              url: "{{route('NewProductPortalScheduleAjiController.update_start_time')}}",
                              type: "post",
                              data: {
                                  _token: '{{csrf_token()}}',
                                  id:id,
                              },
                              dataType: 'json',
                              success: function (res) {
                                  if (res == "1") {
                                    // cek dulu apakah status nya delay tekat?
                                      const plannedDateTime = moment(plan_time);
                                      const currentDateTime = moment();
                                      const diffInMinutes = currentDateTime.diff(plannedDateTime, "minutes");
                                    
                                      if (diffInMinutes >= 1439) {
                                        // muncul modal untuk isi form pica
                                        $("#myModal").modal("show");
                                      } else {
                                        // ketika sudah dicek baru alert berhasil
                                          swal("success!", "Event started!", "success");
                                          setTimeout(() => {
                                            location.reload();
                                          }, 2000);
                                      }
                                  } else {
                                    swal("Oops!", "Start event failed!", "error");
                                  }
                              }
                          });
                    });
                // button set actual end
                    $("#master").on("click",".btn_end",function(){
                      var id = $(this).attr('data-id');
                      var plan_time = $(this).attr('data-plan-time');
                      $("#id-schedule").val(id);
                      $("#type").val("Delay End");

                      // ajax insert date
                      $.ajax({
                              url: "{{route('NewProductPortalScheduleAjiController.update_end_time')}}",
                              type: "post",
                              data: {
                                  _token: '{{csrf_token()}}',
                                  id:id,
                              },
                              dataType: 'json',
                              success: function (res) {
                                if (res == "1") {
                                    // cek dulu apakah status nya delay tekat?
                                      const plannedDateTime = moment(plan_time);
                                      const currentDateTime = moment();
                                      const diffInMinutes = currentDateTime.diff(plannedDateTime, "minutes");

                                      if (diffInMinutes >= 1439) {
                                        // muncul modal untuk isi form pica
                                        $("#myModal").modal("show");
                                      } else {
                                        // ketika sudah dicek baru alert berhasil
                                          swal("success!", "Event Ended!", "success");
                                          setTimeout(() => {
                                            location.reload();
                                          }, 2000);
                                      }
                                  } else {
                                    swal("Oops!", "End event failed!", "error");
                                  }
                              }
                          });
                    });
                // button checklist
                    $("#master").on("click",".checklist",function(){
                      var id = $(this).attr('data-id');
                      var milestone = $(this).attr('data-milestone');
                      var event = $(this).attr('data-event');
                      var project = $(this).attr('data-project');
                      var  pic= $(this).attr('data-pic');console.log(pic);
                      var detail_description = $(this).attr('data-detail-description');
                      var user_current_roles = @json(auth()->user()->roles->pluck('name')); //array roles current user
                      var dept = "{{ auth()->user()->detail_department->code }}";

                      if (user_current_roles.includes("APQP Uploader")|| dept == pic){
                        // ketika jenis form tidak null pake metode hapus dan insert
                        // jika null pake methode insert saja 
                        $("#jenis_form").val("1");
                      }


                      $(".title-checklist").html(event+"</br>"+detail_description);
                      $("#pic").val(pic);
                      $("#id_event").val(id);
                      $("#form_type").val(detail_description);
                      $("#project").val(project);

                      var formEvent = {
                        milestone: milestone,
                        event: event,
                        id: id,
                        project: project,
                        detail_description: detail_description
                      };

                      console.log(formEvent);
                      var url = "{{ route('form_event.show', ['form_event' => ':form_event']) }}";
                          url = url.replace(':form_event', JSON.stringify(formEvent));
                      
                      $.ajax({
                          url: url,
                          type: "GET",
                          data: {
                              _token: '{{ csrf_token() }}'
                          },
                          dataType: 'json',
                          success: function (res) {
                              // Open the modal
                                $("#checklist_modal").show();

                                // Populate the modal body
                                $(".checklist-body").empty(); // Clear any existing content
                                
                                // declare total checklist
                                var total_checklist=0;
                                const idArray = res.final_data.map(item => item.id);
                                var total_checked=0;
                                var all_id_soal=[];
                                
                                $.each(res.soal_data, function(index, item) {
                                  // hitung total checklist
                                  total_checklist += 1;
                                  all_id_soal.push(item.id);
                                  if(item.event == event) {
                                     if (idArray.includes(item.id)) 
                                     {
                                      if (user_current_roles.includes("APQP Uploader") || dept == pic) {
                                        var checkbox =' <div ><input type="checkbox" name="tasks[]" value="'+item.id+'" id="'+item.id+'" '+"checked " +'> <label "> '+item.task+' </label></div>';

                                      }else{
                                        var checkbox =' <div ><input type="checkbox" name="tasks[]" value="'+item.id+'" id="'+item.id+'" '+"checked disabled" +'> <label "> '+item.task+' </label></div>';
                                        total_checked += 1;

                                      }
                                     }else{
                                        
                                        // ketika bukan pic dan bukan role admin NPD maka read only
                                        if (!user_current_roles.includes("APQP Uploader") && dept != pic) {
                                          var checkbox =' <div ><input type="checkbox" name="tasks[]" value="'+item.id+'" id="'+item.id+'" '+" disabled" +'> <label "> '+item.task+' </label></div>';
                                          total_checked += 1;

                                        } else {
                                          var checkbox =' <div ><input type="checkbox" name="tasks[]" value="'+item.id+'" id="'+item.id+'" > <label "> '+item.task+' </label></div>';
                                        }
                                     }
                                  }else{
                                    var checkbox ='';
                                  }
                                  $(".checklist-body").append(checkbox);
                                }); 

                                console.log(res.soal_data);

                                // append input hidden total cheklist
                                $(".checklist-body").append("<input type='hidden' name='total_checklist' value='"+total_checklist+"'>");
                                $(".checklist-body").append("<input type='hidden' name='total_checked' value='"+total_checked+"'>");
                                $(".checklist-body").append("<input type='hidden' name='all_id_soal' value='"+all_id_soal+"'>");
                                if (user_current_roles.includes("APQP Uploader") || dept == pic) {
                                  $(".checklist_footer").html("");
                                  $(".checklist_footer").append( '<button type="submit" class="btn btn-primary btn_submit_checklist">Submit</button>');
                                }

                                $(".close").on("click", function() {
                                  $("#checklist_modal").hide();
                                });
                          },
                          error: function (xhr, status, error) {
                              console.error(xhr.responseText);
                          }
                      });
                    });

                // pica btn
                    $("#master").on("click",".pica_btn",function(){
                      var id = $(this).attr("data-id");
                      $('#myModal').attr('data-backdrop', null);
                      $("#id-schedule").val(id);
                      $("#myModal").modal("show");
                    });
                // judge btn
                    $("#master").on("click",".judge_btn",function(){
                      var judge = $(this).attr('data-judge');
                      var id = $(this).attr('data-id');
                      $.ajax({
                              url: "{{route('NewProductPortalScheduleAjiController.update_judge')}}",
                              type: "post",
                              data: {
                                  _token: '{{csrf_token()}}',
                                  id:id,
                                  judge:judge,
                              },
                              dataType: 'json',
                              success: function (res) {
                                if (res == "1") {
                                    swal("", "success", "success");
                                    location.reload();
                                  } else {
                                    swal("Oops!", "End event failed!", "error");
                                    location.reload();
                                  }
                              }
                          });
                     
                    });
                    
                    
                  }
         
                
                } );


        // number
           table.on('draw.dt', function () {
              var info = table.page.info();
              table.column(0, { search: 'applied', order: 'applied', page: 'applied' }).nodes().each(function (cell, i) {
                  cell.innerHTML = i + 1;
              });

              
          });
        
        //trigger btn pdf
         table.on('click', '.btn_pdf', function(){
            var pdf = $(this).attr('data-pdf')+'#toolbar=0';
            var pdf_download = $(this).attr('data-download');
            var download_pdf = "{{ route('NewProductPortalScheduleController.download',':path' )}}";
            download_pdf = download_pdf.replace(':path', pdf_download);

            $('#myModal4').modal('show');
            $('.iframe_pdf').attr('src', pdf);
            $('.btn_download').attr('href', download_pdf);
         });

          // selet2
            $(".select2").select2();


            setTimeout(function() {
              // Check if there is a previously selected option in localStorage
              var savedOption = localStorage.getItem('dept');
              if (savedOption) {
                // Set the selected option based on the saved value
                $('#depts_dropdown').val(savedOption).trigger('change');
                $('#depts_dropdown').select2().trigger('change');
              }
            }, 2000); 

            var dept = localStorage['dept'] || 'all';

          $("#project_title_dropdown").change(function(){
            table.ajax.reload(null,true);
          }); 
          $("#depts_dropdown").change(function(){
            var data = $(this).val();
            localStorage.setItem('dept', data);
            table.ajax.reload(null,true)
          }); 

          


          
      });



    </script>
@endpush

