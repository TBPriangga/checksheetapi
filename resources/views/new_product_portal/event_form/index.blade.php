@extends('layouts.app-master')

@section('content')
    {{-- datatable library css --}}
    <link href="{{asset('css/dataTables.dateTime.min.css')}}" rel="stylesheet">
    <link href="{{asset('css/jquery.dataTables.min.css')}}" rel="stylesheet">
    <link href="{{asset('css/plugins/select2/select2.min.css')}}" rel="stylesheet">

    <link href="{{asset('css/css_agil/responsive.dataTables.css')}}" rel="stylesheet">

    <!-- Sweet Alert -->
    <link href="{{asset('css/plugins/sweetalert/sweetalert.css')}}" rel="stylesheet">
        <div class="ibox">
            <div class="ibox-title">
                <h4>Project Checklist</h4>
            </div>
            <div class="ibox-content">
                <div>
                    @if(session()->has('success'))
                        <div class="alert alert-primary">{{session('success')}}</div>
                    @endif
                    @if(session()->has('fail'))
                        <div class="alert alert-danger">{{session('fail')}}</div>
                    @endif
                </div>
                <div class="row mb-3">
                    <div class="col-lg-6">
                        <div class="col-8">
                            <form action="{{route('form_event.store')}}"  method="POST" id="upload_form"  enctype="multipart/form-data">
                                @csrf
                                <div class="custom-file">
                                    <input id="logo" type="file" class="custom-file-input" name="file" >
                                    <label for="logo" class="custom-file-label">Choose file...</label>
                                    <div class="form-group mt-2">
                                        <p class="text-danger text-right"><b>*Excel, Csv Only</b></p>
                                    </div>
                                </div>
                            </div>
                        <div class="col-4">
                            <button class="btn btn-primary">Upload</button>
                            </form>
                        </div>
                    </div>
                    <div class="col-lg-6 text-right">
                        <a class="btn btn-primary  m-4 text-center" href="{{route('form_event.create')}}">Create</a>
                    </div>
                </div>
            <div class="hr-line-dashed"></div>
            <div class="row">
                <div class="col-4 text-center">
                    <select name="milestone_dropdown" id="milestone_dropdown" class="form-control">
                        <option value="-">-</option>
                        @foreach ($data['milestones'] as $milestone)
                        <option value="{{$milestone->milestone}}">{{$milestone->milestone}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-4 text-center">
                     <select name="event_dropdown" id="event_dropdown" class="form-control">
                        <option value="-">-</option>
                        @foreach ($data['events'] as $event)
                        <option value="{{$event->event}}">{{$event->event}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-4 text-center">
                     <select name="detail_description_dropdown" id="detail_description_dropdown" class="form-control">
                        <option value="-">-</option>
                        @foreach ($data['detail_descriptions'] as $detail_description)
                        <option value="{{$detail_description->form_type}}">{{$detail_description->form_type}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="hr-line-dashed"></div>
            <table id="master" class="table table-bordered   ">
                <thead>
                    <tr class="text-center">
                        <th>No</th>
                        <th>milestone</th>
                        <th>Event</th>
                        <th>Detail Description</th>
                        <th>Task no</th>
                        <th>Task</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>         
            </table>
    
           
    
        </div>
    </div>
@endsection

@push('scripts')
<script type="text/javascript" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>

<script type="text/javascript">
  $(document).ready(function() {
      // check input
      $('.custom-file-input').on('change', function() {
                let fileName = $(this).val().split('\\').pop();
                var ext = fileName.split('.').pop();
                if ( ext == "csv" || ext == "CSV" || ext == "xls" || ext == "XLS") {
                $(this).next('.custom-file-label').addClass("selected").html(fileName);
                } else {
                $(this).html("");
                swal("Oops!", "Only XLS, CSV file!", "error");
                }
            });  
      // datatable
      var table = $('#master').DataTable( {
              "processing": true,
              "serverSide": true,
              "filter":true,
              "ajax": {
                          "url": "{{route('form_event.index')}}",
                          "data":function (d) {
                            d.milestone = $('#milestone_dropdown').val();
                            d.event = $('#event_dropdown').val();
                            d.form_type = $('#detail_description_dropdown').val();
                      },
              },
              "columns": [
                  { data: null, className: 'dt-body-center'},
                  { data: "milestone", className: 'dt-body-center'},
                  { data: "event", className: 'dt-body-center'},
                  { data: "form_type", className: 'dt-body-center'},
                  { data: "task_no", className: 'dt-body-center'},
                  { data: "task", className: 'dt-body-center'},
                  { data: 'id', className: 'dt-body-center', 
                        "render": function ( data, type, row ) {
                            var deleteUrl = '{{ route("form_event.destroy", ":id") }}'.replace(':id', data);
                            return '<div class="btn-group">' +
                                    '<a href="{{ URL::to("/") }}/NewProductPortal/form_event/' + data + '/edit" class="btn btn-xs btn-default"><i class="fa fa-pencil"></i></a>' +
                                    // '<form style="display:inline-block;" action="' + deleteUrl + '" method="POST">' +
                                    // '@csrf' +
                                    // '@method("DELETE")' +
                                    // '<button type="submit" onclick="return confirm(\'Are you sure?\')" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></button>' +
                                    // '</form>' +
                                    '</div>';
                            },
                  },
                ],
              "columnDefs": [ {
                  "searchable": true,
                  "orderable": true,
                  "targets": 0
              } ],
              "order": [[ 1, 'asc' ]]
          } );

          // number
          table.on('draw.dt', function () {
              var info = table.page.info();
              table.column(0, { search: 'applied', order: 'applied', page: 'applied' }).nodes().each(function (cell, i) {
                  cell.innerHTML = i + 1 + info.start;
              });
          });

          $("#detail_description_dropdown").change(function(){
            table.ajax.reload(null,true)
          }); 
          $("#event_dropdown").change(function(){
            table.ajax.reload(null,true)
          }); 
          $("#milestone_dropdown").change(function(){
            table.ajax.reload(null,true)
          }); 
  } );
</script>
@endpush
