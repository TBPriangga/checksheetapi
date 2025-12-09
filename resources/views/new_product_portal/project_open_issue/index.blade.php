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
      <h4>Project Open Issue</h4>
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
    <div class="row mb-2">
      <div class="col-sm-2">
          <label for="">Customer</label>
          <select name="customer" class="select2 form-control" id="customer_dropdown" required>
              <option value="-">all</option>
              @foreach ($customers as $title)
                  <option value="{{$title->customer}}">{{$title->customer}}</option>
              @endforeach
          </select>
      </div>
      <div class="col-sm-2">
          <label for="">Project</label>
          <select name="project_title" class="select2 form-control" id="project_title_dropdown" required>
              <option value="-">all</option>
              @foreach ($projects as $title)
                  <option value="{{$title->project_title}}">{{$title->project_title}}</option>
              @endforeach
          </select>
      </div>
      <div class="col-sm-2">
          <label for="">Product</label>
          <select name="product" class="select2 form-control" id="product_dropdown" required>
              <option value="-">all</option>
              @foreach ($products as $product)
                  <option value="{{$product->product}}">{{$product->product}}</option>
              @endforeach
          </select>
      </div>
      <div class="col-sm-2">
          <label for="">Dept</label>
          <select name="dept" class="select2 form-control" id="depts_dropdown" required>
              <option value="-">all</option>
              @foreach ($depts as $dept)
                  <option value="{{$dept->code}}">{{$dept->code}}</option>
              @endforeach
          </select>
      </div>
      <div class="col-sm-2">
        <label>Category Problem</label> 
        <select class="form-control select2" name="category_problem" id="category_problems_dropdown">
          <option value="-">all</option>
          @foreach ($category_problem as $item)
            <option value="{{$item->category}}">{{$item->category}}</option>
          @endforeach
        </select>
      </div>
      <div class="col-sm-2 text-right">
        <button class="btn btn-primary btn_issue"><i class="fa fa-plus"></i> Add Issue</button>
        <a href="{{ route('project_open_issue_export') }}" class="btn btn-default btn_download"><i class="fa fa-download"></i> Download</a>
      </div>
    </div>
    <div style="overflow-x:auto">
      <table id="master" class="table table-bordered">
        <thead>
          <tr>
            <th class="text-center"> no</th>
            <th class="text-center"> project</th>
            <th class="text-center"> product</th>
            <th class="text-center"> customer</th>
            {{-- <th clas s="text-center"> event</th> --}}
            {{-- <th class="text-center"> detail description</th> --}}
            {{-- <th class="text-center"> Milestone</th> --}}
            <th class="text-center"> category problem</th>
            <th class="text-center"> problem</th>
            <th class="text-center"> root cause</th>
            <th class="text-center"> counter measure</th>
            <th class="text-center"> Attachment</th>
            <th class="text-center"> pic</th>
            <th class="text-center"> dept</th>
            <th class="text-center"> duedate</th>
            <th class="text-center"> progress</th>
            <th class="text-center"> remark</th>
            <th class="text-center"> Judge</th>
            <th class="text-center"> Judge By</th>
            <th class="text-center"> last edit by</th>
            <th class="text-center"> action</th>
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

  <div class="modal inmodal" id="view_file" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-lg">
      <div class="modal-content animated bounceInRight modal-lg">
              <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                  <h4 class="modal-title">Attachment</h4>
              </div>
              <div class="modal-body">
                <iframe id="fileViewer" width="100%" height="800px" frameborder="0"></iframe>
              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
              </div>
          </div>
      </div>
  </div>

  <div class="modal inmodal" id="form_open_issue" tabindex="-1"  role="dialog" aria-hidden="true">
    <div class="modal-dialog">
    <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <h4 class="modal-title">Project Open Issue</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            </div>
            <div class="modal-body">
              <form action="{{route('project_open_issue.store')}}"  method="POST" id="upload_form"  enctype="multipart/form-data">
                @csrf
                {{-- <input type="hidden" name="id_schedule" id="id-schedule" value=""> --}}
                <div class="form-group">
                  <label>Customer</label>
                  <select name="customer" id="customer" class="form-control">
                    @foreach ($customers as $customer)
                      <option value="{{$customer->customer}}">{{$customer->customer}}</option>
                  @endforeach
                  </select>
                </div>
                <div class="form-group">
                  <label>Project</label>
                  <select name="project" id="project" class="form-control">
                    @foreach ($projects as $project)
                        <option value="{{$project->project_title}}">{{$project->project_title}}</option>
                    @endforeach
                  </select>
                </div>
                <div class="form-group">
                  <label>Product</label>
                  <select name="product" id="product" class="form-control">
                    @foreach ($products as $product)
                      <option value="{{$product->product}}">{{$product->product}}</option>
                  @endforeach
                  </select>
                </div>
                <div class="form-group">
                  <label>Category Problem</label>
                  <select name="category_problem" id="category_problem" class="form-control">
                      <option value="General">General</option>
                    @foreach ($category_problem as $item)
                      <option value="{{$item->category}}">{{$item->category}}</option>
                    @endforeach
                  </select>
                </div>
                <input type="hidden" name="dept" id="dept" value="{{ auth()->user()->department->code }}">
                <div class="form-group">
                  <label>Problem</label> <input type="text" name="problem" id="problem" placeholder="Problem" class="form-control" autocomplete="off">
                </div>
                <div class="form-group">
                  <label>Root cause</label> <textarea name="root_cause" placeholder="Root Cause" class="form-control" autocomplete="off"></textarea>
                </div>
                <div class="form-group">
                  <label>Counter Measure</label> <textarea name="countermeasure" placeholder="Counter Measure" class="form-control" autocomplete="off"></textarea>
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
                  { responsivePriority: 1, targets: 10 },
                  { responsivePriority: 2, targets: 9 },
                  { responsivePriority: 3, targets: 8 },
                  { responsivePriority: 3, targets: 8 },
                  { responsivePriority: 4, targets: 6 }
              ],
              "processing": true,
              "serverSide": true,
              "filter":true,
              "ajax": {
                          "url": "{{route('project_open_issue.index')}}",
                          "data":function (d) {
                            d.project_title = $('#project_title_dropdown').val();
                            d.dept = $('#depts_dropdown').val();
                            d.category_problem = $('#category_problems_dropdown').val();
                            d.product = $('#product_dropdown').val();
                            d.type = $('#type_dropdown').val();
                            d.customer = $('#customer_dropdown').val();
                      },
              },
              "columns": [
                  { data: null, className: 'dt-body-center',
                        'render': function (data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                  },
                  { data: 'project_title', className: 'dt-body-center'},
                  { data: 'product', className: 'dt-body-center'},
                  { data: 'customer', className: 'dt-body-center'},
                  // { data: 'event', className: 'dt-body-center'},
                  // { data: 'detail_description', className: 'dt-body-center'},
                  // { data: 'milestone', className: 'dt-body-center'},
                  { data: 'category_problem', className: 'dt-body-center'},
                  { data: 'problem', className: 'dt-body-center'},
                  { data: 'root_cause', className: 'dt-body-center'},
                  { data: 'countermeasure', className: 'dt-body-center'},
                  { data: 'attachment', className: 'dt-body-center','render': function(data,type,row){
                    var url = "{{ URL::to('/')}}/npd/openissue/"+data+row['type_attachment'];
                     if (data == "") {
                        return '';
                      } else {
                        return "<button class='btn btn-default btn_view_attachment' data-img='"+url+"' data-download='"+data+"'><i class='fa fa-eye'></i></button>";
                      }
                    },
                  },
                  { data: 'pic', className: 'dt-body-center'},
                  { data: 'dept', className: 'dt-body-center'},
                  { data: 'due_date', className: 'dt-body-center'},
                  { data: 'progress', className: 'dt-body-center', 'render':function(data){
                    if (data == "0") {
                      return "Open";
                    } else if(data == "1") {
                      return "Close"
                    } else if(data == "2"){
                      return "Cancel";
                    }else {
                      return "Postpone";
                    }
                  }},
                  { data: 'remark', className: 'dt-body-center'},
                  // { data: 'created_at', className: 'dt-body-center'},
                  {
                    data: 'id',
                    className: 'dt-body-center',
                    render: function(data, type, row) {
                      var roles = "{{ auth()->user()->roles->pluck('name') }}"; 
                      var judge = row['judge'];
                      
                      if (roles.includes("APQP Uploader") && judge == null && row['progress'] == "1" ) {
                        var button_ng= "<button class='btn btn-danger btn-md judge_btn' data-judge='0' data-id='" + data + "'>NG</button>";
                        return "<button class='btn btn-primary btn-md judge_btn' data-judge='1' data-id='" + data + "'>OK</button>";
                      } else if (judge != null) {
                        return (judge == 1) ? "OK" : "NG";
                      }else{
                        return '';
                      }
                    }
                  },
                  { data: 'judge_by', className: 'dt-body-center'},
                  { data: 'last_edit_by', className: 'dt-body-center'},
                  { data: 'id', className: 'dt-body-center', 'render': function(data, type, row){
                    // cek apakah data pic sama dengan dept user 
                    var dept = "{{ auth()->user()->department->code }}";
                    var detail_dept = "{{ auth()->user()->detail_department->id }}";
                    if (row['dept'].toUpperCase() == dept.toUpperCase() || detail_dept == "3" ){
                      return "<div class='btn-group'><a href='{{URL::to('/')}}/NewProductPortal/project_open_issue/"+data+"/edit' class='btn btn-xs btn-default'><i class='fa fa-pencil'></i></a><a onClick='return confirm("+'"are you sure  ?"'+")' href='{{URL::to('/')}}/NewProductPortal/project_open_issue/"+data+"' class='btn btn-xs btn-danger'><i class='fa fa-trash'></i></a></div>";
                    }
                    return '';
                  }},
                
              ],
              "columnDefs": [ {
                  "searchable": true,
                  "orderable": true,
                  "targets": 0
              } ],
              "order": [],
              "initComplete": function(settings, json) {
                // judge btn
                $("#master").on("click",".judge_btn",function(){
                      var judge = $(this).attr('data-judge');
                      var id = $(this).attr('data-id');
                      $.ajax({
                              url: "{{route('NewProductPortalOpenIssueController.update_judge')}}",
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
                // show image attachment
                $('.btn_view_attachment').click(function() {
                  var file = $(this).attr("data-img");
                  $('#fileViewer').attr("src", file);
                  $("#view_file").modal("show");
                });
                // trigger open modal form issue
                $(".btn_issue").click(function(){
                  $("#form_open_issue").modal("show");
                });

                $(".btn_submit").click(function(){
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
               
              }
          } );



          // selet2
          $(".select2").select2();

          $("#project_title_dropdown").change(function(){
                table.ajax.reload(null,true)
          }); 
          $("#depts_dropdown").change(function(){
                table.ajax.reload(null,true)
          }); 
          $("#category_problems_dropdown").change(function(){
                table.ajax.reload(null,true)
          }); 
          $("#type_dropdown").change(function(){
                table.ajax.reload(null,true)
          }); 
          $("#customer_dropdown").change(function(){
                table.ajax.reload(null,true)
          }); 
          $("#product_dropdown").change(function(){
                table.ajax.reload(null,true)
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
                    ext =="xls" || ext =="xlsx"||
                    ext =="csv" || ext =="CSV"
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

