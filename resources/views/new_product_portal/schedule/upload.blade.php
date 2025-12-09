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
      <h4>Upload Schedule</h4>
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
    <form action="{{route('NewProductPortalScheduleController.store')}}"  method="POST" id="upload_form"  enctype="multipart/form-data">
        <div class="row">
            <div class="col-sm-4">
                <label for="customer">customer</label>
                <select name="customer" class="select2 form-control" id="customer_dropdown" required>
                    @foreach ($customers as $customer)
                        <option value="{{$customer->code}}">{{$customer->code}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-sm-4">
                <label for="project">project</label>
                <input type="text" class="form-control" placeholder="project" id="project" name="project">
            </div>
            <div class="col-sm-4">
                <label for="product">product</label>
                <input type="text" class="form-control" placeholder="product" id="product" name="product">
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-lg-6">
                    @csrf
                    <input type="hidden" class="form-group" name="uploaded_by" value="{{Auth::user()->name}}">
                    {{-- aji master file --}}
                        <label for="">
                            <h4>AJI Master Schedule</h4>
                        </label>
                        <div class="form-group mt-2">
                            <div class="text-danger text-right">
                                <button type="button" class="btn button_remove_aji_master_schedule">
                                    <i class="fa fa-minus"></i>
                                </button>
                                <button type="button" class="btn button_add_aji_master_schedule">
                                    <i class="fa fa-plus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="div_aji_master_schedule">
                            <div class="custom-file form_aji_master_schedule">
                                <input id="logo" type="file" class="custom-file-input" name="aji_master_schedule[]" >
                                <label for="logo" class="custom-file-label">Choose file...</label>
                                <div class="form-group mt-2">
                                    <p class="text-danger text-right"><b>*PDF Only</b></p>
                                </div>
                            </div>
                        </div>
                    {{-- juoku master file --}}
                        <label for="">
                            <h4>Juoku Master Schedule</h4>
                        </label> 
                        <div class="form-group mt-2">
                            <div class="text-danger text-right">
                                <button type="button" class="btn button_remove_juoku_master_schedule">
                                    <i class="fa fa-minus"></i> 
                                </button>
                                <button type="button" class="btn button_add_juoku_master_schedule">
                                    <i class="fa fa-plus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="div_juoku_master_schedule">
                            <div class="custom-file form_juoku_master_schedule">
                                <input id="logo" type="file" class="custom-file-input" name="juoku_master_schedule[]" >
                                <label for="logo" class="custom-file-label">Choose file...</label>
                                <div class="form-group mt-2">
                                    <p class="text-danger text-right"><b>*PDF Only</b></p>
                                </div>
                            </div> 
                        </div>
                    {{-- customer file --}}
                        <label for="">
                            <h4>Customer Schedule</h4>
                        </label>
                        <div class="form-group mt-2">
                            <div class="text-danger text-right">
                                <button type="button" class="btn button_remove_customer_schedule">
                                    <i class="fa fa-minus"></i>
                                </button>
                                <button type="button" class="btn button_add_customer_schedule">
                                    <i class="fa fa-plus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="div_customer_schedule">
                            <div class="custom-file form_customer_schedule">
                                <input id="logo" type="file" class="custom-file-input" name="customer_schedule[]" >
                                <label for="logo" class="custom-file-label">Choose file...</label>
                                <div class="form-group mt-2">
                                    <p class="text-danger text-right"><b>*PDF Only</b></p>
                                </div>
                            </div> 
                        </div>
                    {{-- tooling progress report file --}}
                        <label for="">
                            <h4>Toolng Progress Report</h4>
                        </label>
                        <div class="form-group mt-2">
                            <div class="text-danger text-right">
                                <button type="button" class="btn button_remove_tooling_progres_report">
                                    <i class="fa fa-minus"></i>
                                </button>
                                <button type="button" class="btn button_add_tooling_progres_report">
                                    <i class="fa fa-plus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="div_tooling_progres_report">
                            <div class="custom-file form_tooling_progres_report">
                                <input id="logo" type="file" class="custom-file-input" name="tooling_progres_report[]" >
                                <label for="logo" class="custom-file-label">Choose file...</label>
                                <div class="form-group mt-2">
                                    <p class="text-danger text-right"><b>*PDF Only</b></p>
                                </div>
                            </div> 
                        </div>
                </div>
        </div>
    
</div>
  <div class="ibox-footer">
    <button class="btn  btn-primary upload_btn" >Upload</button>
</form>
    <button class="btn  btn-default " onClick="history.back()">Back</button>
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
        // selet2
            $(".select2").select2();
            
            var idModel = localStorage['product'] || '';
            var idCustomer = localStorage['customer'] || '';
            var idProduct = localStorage['project'] || '';
            if (idProduct == '' || idProduct == null) {
                    idProduct = '';
                } else{
                    $("#project").append('<option value="'+idProduct+'">' + idProduct + '</option>');
                    $("#project").val(idProduct).change();
                }
                
                $("#product").val(idModel).change();
                $("#customer_dropdown").val(idCustomer).change();
            

            $("#project").change(function(){
                localStorage['product'] = $('#product').val();
                localStorage['customer'] = $('#customer_dropdown').val();
                localStorage['project'] = $('#project').val();
            });
            $("#product").change(function(){
                localStorage['product'] = $('#product').val();
                localStorage['customer'] = $('#customer_dropdown').val();
                localStorage['project'] = $('#project').val();
            });
            $("#customer_dropdown").change(function(){
                localStorage['product'] = $('#product').val();
                localStorage['customer'] = $('#customer_dropdown').val();
                localStorage['project'] = $('#project').val();
            });

        // submit upload
            // $("#upload_form").submit(function(event){
            //     event.preventDefault();
                
            // });
        // check input
            function checkInput(){
                $('.custom-file-input').on('change', function() {
                    let fileName = $(this).val().split('\\').pop();
                    var ext = fileName.split('.').pop();
                    if ( ext == "pdf" || ext == "PDF" ) {
                    $(this).next('.custom-file-label').addClass("selected").html(fileName);
                    } else {
                    $(this).html("");
                    swal("Oops!", "Only PDF file!", "error");
                    }
                }); 
            }
            checkInput();
        // duplicate form_aji_master_schedule
            $(".button_add_aji_master_schedule").click(function(){
                var html = '<div class="custom-file form_aji_master_schedule">'+
                                '<input id="logo" type="file" class="custom-file-input" name="aji_master_schedule[]" >'+
                                '<label for="logo" class="custom-file-label">Choose file...</label>'+
                                '<div class="form-group mt-2"><p class="text-danger text-right"><b>*PDF Only</b></p></div>'+
                            '</div>';
                $(".div_aji_master_schedule").append(html);
                checkInput();
            });
            $(".button_remove_aji_master_schedule").click(function(){
                $(".div_aji_master_schedule :last-child").remove();
                checkInput();
            });

        // duplicate form_juoku_master_schedule
            $(".button_add_juoku_master_schedule").click(function(){
                var html = '<div class="custom-file form_juoku_master_schedule">'+
                                '<input id="logo" type="file" class="custom-file-input" name="juoku_master_schedule[]" >'+
                                '<label for="logo" class="custom-file-label">Choose file...</label>'+
                                '<div class="form-group mt-2"><p class="text-danger text-right"><b>*PDF Only</b></p></div>'+
                            '</div>';
                $(".div_juoku_master_schedule").append(html);
                checkInput();
            });
            $(".button_remove_juoku_master_schedule").click(function(){
                $(".div_juoku_master_schedule :last-child").remove();
                checkInput();
            });

        // duplicate form_customer_schedule
            $(".button_add_customer_schedule").click(function(){
                var html = '<div class="custom-file form_customer_schedule">'+
                                '<input id="logo" type="file" class="custom-file-input" name="customer_schedule[]" >'+
                                '<label for="logo" class="custom-file-label">Choose file...</label>'+
                                '<div class="form-group mt-2"><p class="text-danger text-right"><b>*PDF Only</b></p></div>'+
                            '</div>';
                $(".div_customer_schedule").append(html);
                checkInput();
            });
            $(".button_remove_customer_schedule").click(function(){
                $(".div_customer_schedule :last-child").remove();
                checkInput();
            });

        // duplicate form_customer_schedule
            $(".button_add_tooling_progres_report").click(function(){
                var html = '<div class="custom-file form_tooling_progres_report">'+
                                '<input id="logo" type="file" class="custom-file-input" name="tooling_progres_report[]" >'+
                                '<label for="logo" class="custom-file-label">Choose file...</label>'+
                                '<div class="form-group mt-2"><p class="text-danger text-right"><b>*PDF Only</b></p></div>'+
                            '</div>';
                $(".div_tooling_progres_report").append(html);
                checkInput();
            });
            $(".button_remove_tooling_progres_report").click(function(){
                $(".div_tooling_progres_report :last-child").remove();
                checkInput();
            });
      });



    </script>
@endpush

