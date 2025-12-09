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
    <div class="row">
      <div class="col-sm-4">
        <label for="customer">customer</label>
          <select name="customer" class="select2 form-control" id="customer_dropdown" required>
              <option value="-">all</option>
              @foreach ($customers as $customer)
                  <option value="{{$customer->code}}">{{$customer->code}}</option>
              @endforeach
          </select>
      </div>
      <div class="col-sm-4">
        <label for="project">project</label>
          <select name="project" class="select2 form-control" id="project_dropdown" required>
            <option value="-">all</option>
            @foreach ($projects as $project)
                  <option value="{{$project->project}}">{{$project->project}}</option>
              @endforeach
          </select>
      </div>
      <div class="col-sm-4">
        <label for="product">product</label>
          <select name="product" class="select2 form-control" id="product_dropdown" required>
            <option value="-">all</option>
              @foreach ($products as $product)
                  <option value="{{$product->product}}">{{$product->product}}</option>
              @endforeach
          </select>
      </div>
  </div>
  <hr>
    <table id="master" class="table table-bordered">
        <thead>
          <tr>
            <th class="text-center">no</th>
            <th class="text-center">customer</th>
            <th class="text-center">project</th>
            <th class="text-center">product</th>
            <th class="text-center">aji master </th>
            <th class="text-center">juoku master </th>
            <th class="text-center">customer </th>
            <th class="text-center">tpr</th>
            <th class="text-center"> by</th>
            <th class="text-center">action</th>
          </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
  </div>
  <div class="ibox-footer">
    <button class="btn  btn-default " onClick="history.back()">Back</button>
  </div>
</div>

<div class="modal inmodal" id="myModal4" tabindex="-1" role="dialog"  aria-hidden="true">
  <div class="modal-dialog modal-lg" >
      <div class="modal-content animated fadeIn">
          <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
              <h4 class="modal-title">Attachment</h4>
          </div>
          <div class="modal-body" >
            <div class="cover" style="position:absolute; background-color:transparent;width:720px;height:500px;">
            </div>
            <div class="cover">
              <iframe  width="100%" height="100%" class="iframe_pdf" style="min-height: 500px;" class="pdf" frameborder="0" oncontextmenu="return false;"></iframe>
            </div>
          </div>
          <div class="modal-footer">
              <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
              <a href="" target="_blank" class="btn btn-primary btn_download">Download</a>
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
        // datatable
        var table = $('#master').DataTable( {
              'responsive': true,
              'columnDefs': [
              ],
              "processing": true,
              "serverSide": true,
              "filter":true,
              "ajax": {
                          "url": "{{route('NewProductPortalScheduleController.index')}}",
                          "data":function (d) {
                            d.customer = $('#customer_dropdown').val();
                            d.product = $('#product_dropdown').val();
                            d.project = $('#project_dropdown').val();
                      },
              },
              "columns": [
                  { data: null, className: 'dt-body-center'},
                  { data: 'customer', className: 'dt-body-center'},
                  { data: 'project', className: 'dt-body-center'},
                  { data: 'product', className: 'dt-body-center'},
                  { data: "file1", className: 'dt-body-center', "render": function ( data, type, row ) {
                    var url = "";
                    if (data == "") {
                        return '';
                      } else {
                        var list = data.split("|");
                        var html_button_pdf = '';
                        list.forEach(element => {
                          url = "{{ URL::to('/')}}/npd/schedule/"+element;
                          html_button_pdf += "<button class='btn btn-default btn_pdf' data-pdf='"+url+"' data-download='"+element+"'><i class='fa fa-eye'></i></button>";
                        });
                        return html_button_pdf;
                      }
                    },
                  },
                  { data: "file2", className: 'dt-body-center', "render": function ( data, type, row ) {
                    var url = "";
                    if (data == "") {
                        return '';
                      } else {
                        var list = data.split("|");
                        var html_button_pdf = '';
                        console.log(list);
                        list.forEach(element => {
                          url = "{{ URL::to('/')}}/npd/schedule/"+element;
                          html_button_pdf += "<button class='btn btn-default btn_pdf' data-pdf='"+url+"' data-download='"+element+"'><i class='fa fa-eye'></i></button>";
                        });
                        return html_button_pdf;
                      }
                    },
                  },
                  { data: "file3", className: 'dt-body-center', "render": function ( data, type, row ) {
                      var url = "";
                      if (data == "") {
                          return '';
                        } else {
                          var list = data.split("|");
                          var html_button_pdf = '';
                          list.forEach(element => {
                            url = "{{ URL::to('/')}}/npd/schedule/"+element;
                            html_button_pdf += "<button class='btn btn-default btn_pdf' data-pdf='"+url+"' data-download='"+element+"'><i class='fa fa-eye'></i></button>";
                          });
                          return html_button_pdf;
                        }
                    },
                  },
                  { data: "file4", className: 'dt-body-center', "render": function ( data, type, row ) {
                    var url = "";
                    if (data == "") {
                        return '';
                      } else {
                        var list = data.split("|");
                        var html_button_pdf = '';
                        list.forEach(element => {
                          url = "{{ URL::to('/')}}/npd/schedule/"+element;
                          html_button_pdf += "<button class='btn btn-default btn_pdf' data-pdf='"+url+"' data-download='"+element+"'><i class='fa fa-eye'></i></button>";
                        });
                        return html_button_pdf;
                      }
                    },
                  },
                  { data: "uploaded_by", className: 'dt-body-center'},
                  { data: "id", className: 'dt-body-center',
                      'render' : function(data, type, row){
                        return "<a onclick='return confirm()' href='{{ URL::to('/')}}/NewProductPortal/schedule/"+data+"/delete' class='btn btn-danger'><i class='fa fa-trash text-white'></a>";
                      }
                  },
              ],
              "columnDefs": [ {
                  "searchable": true,
                  "orderable": true,
                  "targets": 0
              } ],
              "order": []
          } );


        // number
           table.on('draw.dt', function () {
              var info = table.page.info();
              table.column(0, { search: 'applied', order: 'applied', page: 'applied' }).nodes().each(function (cell, i) {
                  cell.innerHTML = i + 1 + info.start;
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
            // Refilter the table
              $('#customer_dropdown, #product_dropdown, #project_dropdown').on('change', function () {
                table.ajax.reload(null,true);
              });

            // caching 
            // var idModel = localStorage['model'] || 'defaultValue';
            // var idCustomer = localStorage['customer'] || 'defaultValue';
            // var idProduct = localStorage['project'] || 'defaultValue';
            // if (idProduct == 'defaultValue' || idProduct == null) {
            //         idProduct = '';
            //     } else{
            //         $("#project_dropdown").append('<option value="'+idProduct+'">' + idProduct + '</option>');
            //         $("#project_dropdown").val(idProduct).change();
            //     }
            //     console.log(idModel+" "+idCustomer+" "+idProduct);
            //     $("#model_dropdown").val(idModel).change();
            //     $("#customer_dropdown").val(idCustomer).change();
            
            // $("#model_dropdown").change(function(){
            //     $("#project_dropdown").html('');
            //     $("#project_dropdown").select2("val", "");
            //     $("#project_dropdown").html('<option value="-">all</option>');
                // var idModel = this.value;
                
                
                // $.ajax({
                //     url: "{{url('quality/model/fetchPart/')}}" + '/' + idModel,
                //     type: "GET",
                //     data: {
                //         model_id: idModel,
                //         _token: '{{csrf_token()}}'
                //     },
                //     dataType: 'json',
                //     success: function (res) {
                //         $('#project_dropdown').html('<option value="">-- Select Product --</option>');
                //         $.each(res.parts, function (key, value) {
                //             $("#project_dropdown").append('<option value="' + value.name + '">' + value.name + '</option>');
                //         });

                //         localStorage['model'] = $('#model_dropdown').val();
                //         localStorage['customer'] = $('#customer_dropdown').val();
                //         localStorage['project'] = $('#project_dropdown').val();
                //     }
                // });
            // });

            // $("#project_dropdown").change(function(){
            //     localStorage['model'] = $('#model_dropdown').val();
            //     localStorage['customer'] = $('#customer_dropdown').val();
            //     localStorage['project'] = $('#project_dropdown').val();
            // });
            // $("#customer_dropdown").change(function(){
            //     localStorage['model'] = $('#model_dropdown').val();
            //     localStorage['customer'] = $('#customer_dropdown').val();
            //     localStorage['project'] = $('#project_dropdown').val();
            // });

          
      });



    </script>
@endpush

