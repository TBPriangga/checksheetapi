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
      <h4>Project Event</h4>
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
      <div class="col-sm-3">
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
          <select name="product" class="select2 form-control" id="products_dropdown" required>
              <option value="-">all</option>
              @foreach ($products as $title)
                  <option value="{{$title->product}}">{{$title->product}}</option>
              @endforeach
          </select>
      </div>
      <div class="col-sm-2">
          <label for="">Milestone</label>
          <select name="milestone" class="select2 form-control" id="milestones_dropdown" required>
              <option value="-">all</option>
              @foreach ($milestones as $title)
                  <option value="{{$title->milestone}}">{{$title->milestone}}</option>
              @endforeach
          </select>
      </div>
      <div class="col-sm-3">
          <label for="">Dept</label>
          <select name="dept" class="select2 form-control" id="depts_dropdown" required>
              <option value="-">all</option>
              @foreach ($depts as $dept)
                  <option value="{{$dept->code}}">{{$dept->code}}</option>
              @endforeach
          </select>
      </div>
      <div class="col-sm-2 text-right">
        <button class="btn btn-white btn-bitbucket d-none sync"><i class="fa fa-exchange"></i></button>
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
            <th class="text-center"> milestone</th>
            <th class="text-center"> event</th>
            <th class="text-center"> detail description</th>
            <th class="text-center"> Milestone</th>
            <th class="text-center"> type</th>
            <th class="text-center"> pic</th>
            <th class="text-center"> plan start</th>
            <th class="text-center"> plan end</th>
            <th class="text-center"> remark</th>
            <th class="text-center"> Sync time</th>
            <th class="text-center"> last edit by</th>
            <th class="text-center"> Edit Remark</th>
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
                  <h4 class="modal-title">Remark</h4>
              </div>
              <div class="modal-body">
                <input type="hidden" name="id_event" id="id_event">
                <div class="form-group">
                  <textarea class="form-control" name="remark" id="remark" rows="5"></textarea>
                </div>
              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-primary btn_submit" >Submit</button>
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
        // trigger sync
        $(".sync").trigger("click");
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
                          "url": "{{route('NewProductPortalProjectEventController.index')}}",
                          "data":function (d) {
                            d.project_title = $('#project_title_dropdown').val();
                            d.dept = $('#depts_dropdown').val();
                            d.product = $('#products_dropdown').val();
                            d.milestone = $('#milestones_dropdown').val();
                            d.customer = $('#customers_dropdown').val();
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
                  { data: 'milestone', className: 'dt-body-center'},
                  { data: 'event', className: 'dt-body-center'},
                  { data: 'detail_description', className: 'dt-body-center'},
                  { data: 'milestone', className: 'dt-body-center'},
                  { data: 'type', className: 'dt-body-center'},
                  { data: 'pic', className: 'dt-body-center'},
                  { data: 'plan_start', className: 'dt-body-center'},
                  { data: 'plan_end', className: 'dt-body-center'},
                  { data: 'remark', className: 'dt-body-center'},
                  { data: 'created_at', className: 'dt-body-center'},
                  { data: 'last_edit_by', className: 'dt-body-center'},
                  { data: 'id', className: 'dt-body-center', 'render': function(data, type, row){
                    // cek apakah data pic sama dengan dept user 
                    var dept = "{{ auth()->user()->department->code }}";
                    var detail_dept = "{{ auth()->user()->detail_department->id }}";
                                  if (row['pic'].split(" | ")[0].toUpperCase() == dept.toUpperCase() || detail_dept == "3" ){
                                    return "<div class='btn-group'><button class='btn btn-md btn-default show_modal_remark' data-id='"+row['id']+"'><i class='fa fa-pencil'></i></button></div>";
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
                // show image attachment
                $('#master').on('click', '.show_modal_remark', function() {
                    var id = $(this).data('id'); // Use .data() method instead of .attr()
                    $("#id_event").val(id);
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

                  $(".sync").trigger("click");
              }
          } );

        // submit remark
            $(".btn_submit").click(function(){
              var remark = $("#remark").val();
              var id_event = $("#id_event").val();
              var url = "{{route('NewProductPortalProjectEventController.edit',['data'=>'dataku'])}}";
              var url = url.replace('dataku', id_event);
              $("#myModal").modal("hide");

              $.ajax({
                        url: url,
                        type: "post",
                        data: {
                            _token: '{{csrf_token()}}',
                            remark: remark,
                        },
                        success: function (res) {
                           if (res == 0) {
                            alert("Failed update remark!");
                            } else {
                              alert("Success update remark!");
                            }
                            location.reload();
                        } 
                });
            });



        // selet2
          $(".select2").select2();

          $("#project_title_dropdown").change(function(){
                table.ajax.reload(null,true)
          }); 
          $("#depts_dropdown").change(function(){
                table.ajax.reload(null,true)
          }); 
          $("#customers_dropdown").change(function(){
                table.ajax.reload(null,true)
          }); 
          $("#products_dropdown").change(function(){
                table.ajax.reload(null,true)
          }); 
          $("#milestones_dropdown").change(function(){
                table.ajax.reload(null,true)
          }); 

          


          
      });



    </script>
@endpush

