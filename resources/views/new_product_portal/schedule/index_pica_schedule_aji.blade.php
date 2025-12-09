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
      <h4>Project Pending Item</h4>
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
          <select name="customer" class="select2 form-control" id="customers_dropdown" required>
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
              @foreach ($project_titles as $title)
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
        <label for="">Milestone</label>
        <select name="milestone" class="select2 form-control" id="milestones_dropdown" required>
            <option value="-">all</option>
            @foreach ($milestones as $milestone)
                <option value="{{$milestone->milestone}}">{{$milestone->milestone}}</option>
            @endforeach
        </select>
    </div>
      <div class="col-sm-2">
          <label for="">Dept</label>
          <select name="project_title" class="select2 form-control" id="depts_dropdown" required>
              <option value="-">all</option>
              @foreach ($depts as $dept)
                  <option value="{{$dept->code}}">{{$dept->code}}</option>
              @endforeach
          </select>
      </div>
      <div class="col-sm-2 ">
        <label for="">Category Problem</label>
          <select name="category_problem" class="select2 form-control" id="category_problems_dropdown" required>
              <option value="-">all</option>
              @foreach ($category_problem as $item)
                  <option value="{{$item->category}}">{{$item->category}}</option>
              @endforeach
          </select>
          {{-- <button class="btn btn-white btn-bitbucket sync"><i class="fa fa-exchange"></i></button> --}}
          <div class="text-right">
            <a href="{{route('pica_schedule_aji_internal_export')}}" class="btn btn-default mt-2"><i class="fa fa-download"></i> DOWNLOAD</a>
          </div>
      </div>
    </div>
    <div style="overflow-x:auto">
      <table id="master" class="table table-bordered">
        <thead>
          <tr>
            <th class="text-center"> no</th>
            <th class="text-center"> customer</th>
            <th class="text-center"> project</th>
            <th class="text-center"> product</th>
            <th class="text-center"> event</th>
            <th class="text-center"> detail description</th>
            <th class="text-center"> Milestone</th>
            <th class="text-center"> type</th>
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
            <th class="text-center"> last updated at</th>
            <th class="text-center"> last edit by</th>
            <th class="text-center"> judge</th>
            <th class="text-center"> judge by</th>
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

  <div class="modal inmodal" id="myModal" tabindex="-1" role="dialog" aria-hidden="true">
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
                          "url": "{{route('NewProductPortalPicaScheduleAjiController.index')}}",
                          "data":function (d) {
                            d.project_title = $('#project_title_dropdown').val();
                            d.dept = $('#depts_dropdown').val();
                            d.category_problem = $('#category_problems_dropdown').val();
                            d.customer = $('#customers_dropdown').val();
                            d.milestone = $('#milestones_dropdown').val();
                            d.product = $('#product_dropdown').val();
                      },
              },
              "columns": [
                  { data: null, className: 'dt-body-center',
                        'render': function (data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                  },
                  { data: 'customer', className: 'dt-body-center'},
                  { data: 'project_title', className: 'dt-body-center'},
                  { data: 'product', className: 'dt-body-center'},
                  { data: 'event', className: 'dt-body-center'},
                  { data: 'detail_description', className: 'dt-body-center'},
                  { data: 'milestone', className: 'dt-body-center'},
                  { data: 'type', className: 'dt-body-center'},
                  { data: 'category_problem', className: 'dt-body-center'},
                  { data: 'problem', className: 'dt-body-center'},
                  { data: 'root_cause', className: 'dt-body-center'},
                  { data: 'countermeasure', className: 'dt-body-center'},
                  { data: 'attachment', className: 'dt-body-center','render': function(data,type,row){
                    var url = "{{ URL::to('/')}}/npd/pica/"+data+row['type_attachment'];
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
                  { data: 'updated_at', className: 'dt-body-center'},
                  { data: 'last_edit_by', className: 'dt-body-center'},
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
                  { data: 'id', className: 'dt-body-center', 'render': function(data, type, row){
                    // cek apakah data pic sama dengan dept user 
                    var dept = "{{ auth()->user()->department->code }}";
                    var detail_dept = "{{ auth()->user()->detail_department->id }}";
                                  if (row['dept'].toUpperCase() == dept.toUpperCase() || detail_dept == "3" ){
                                    return "<div class='btn-group'><a href='{{URL::to('/')}}/NewProductPortal/pica_schedule_aji_internal/"+data+"/edit_pica_aji_internal' class='btn btn-xs btn-default'><i class='fa fa-pencil'></i></a><a onClick='return confirm("+'"are you sure  ?"'+")' href='{{URL::to('/')}}/NewProductPortal/pica_schedule_aji_internal/"+data+"/delete_pica_aji_internal' class='btn btn-xs btn-danger'><i class='fa fa-trash'></i></a></div>";
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
                              url: "{{route('NewProductPortalPicaScheduleAjiController.update_judge')}}",
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
                  $("#myModal").modal("show");
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
          $("#milestones_dropdown").change(function(){
                table.ajax.reload(null,true)
          }); 
          $("#products_dropdown").change(function(){
                table.ajax.reload(null,true)
          }); 
          $("#customers_dropdown").change(function(){
                table.ajax.reload(null,true)
          }); 

          


          
      });



    </script>
@endpush

