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
      <h4>Upload Detail Schedule</h4>
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
    <form action="{{route('NewProductPortalScheduleAjiController.store')}}"  method="POST" id="upload_form"  enctype="multipart/form-data">
        <div class="row">
            <div class="col-lg-6 border-right">
                    @csrf
                    <input type="hidden" class="form-group" name="uploaded_by" value="{{Auth::user()->name}}">
                    {{-- aji master file --}}
                        <label for="">
                            <h4>Project</h4>
                        </label>
                        <div class="form-group">
                            <input type="text" name="project_title" id="project_title" class="form-control" placeholder="project title" required>
                        </div>
                        <label for="">
                            <h4>Product</h4>
                        </label>
                        <div class="form-group">
                            <input type="text" name="product" id="product" class="form-control" placeholder="product" required>
                        </div>
                        <label for="">
                            <h4>Customer</h4>
                        </label>
                        <div class="form-group">
                            <select name="customer" id="customer" class="form-control">
                                <option value="-">-</option>
                                @foreach ($customers as $customer)
                                <option value="{{$customer->code}}">{{$customer->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <label for="">
                            <h4>File</h4>
                        </label>
                        <div class="custom-file">
                            <input id="logo" type="file" class="custom-file-input" name="file" >
                            <label for="logo" class="custom-file-label">Choose file...</label>
                           <div class="form-group mt-2 d-flex justify-content-between align-items-center">
    <a href="{{ asset('templates/Detail Schedule K2VM.csv') }}" class="btn btn-sm btn-outline-primary">
        <i class="fa fa-download"></i> Download Template CSV
    </a>
    <p class="text-danger mb-0"><b>*Csv Only</b></p>
</div>

                        </div>
            </div>
            <div class="col-lg-6">
                <div class="row border-bottom mb-2"><div class="col-lg-12"><h4>Delete Imported Schedule</h4></div></div>
                <div class="row mb-2">
                    <div class="col-sm-3">
                        <label for="">Project</label>
                        <select name="project_title_search" class="select2 form-control" id="project_title_dropdown_search" required>
                            <option value="-">all</option>
                            @foreach ($project_titles as $title)
                                <option value="{{$title->project_title}}">{{$title->project_title}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-sm-3">
                        <label for="">Product</label>
                        <select name="product_search" class="select2 form-control" id="product_dropdown_search" required>
                            <option value="-">all</option>
                            @foreach ($products as $product)
                                <option value="{{$product->product}}">{{$product->product}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-sm-3">
                        <label for="">Customer</label>
                        <select name="customer_search" class="select2 form-control" id="customers_dropdown_search" required>
                            <option value="-">all</option>
                            @foreach ($customers_in as $customer)
                                <option value="{{$customer->customer}}">{{$customer->customer}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-sm-3">
                        <button class="btn btn-primary float-right btn_search" type="button"><i class="fa fa-search"></i></button>
                    </div>
                  </div>
                  <div class="row mt-3 border-top border-bottom">
                    <div class="col-lg-3 text_search mt-2"></div>
                    <div class="col-lg-3 div_hapus mt-2 mb-2"></div>
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
        // check input
            $('.custom-file-input').on('change', function() {
                let fileName = $(this).val().split('\\').pop();
                var ext = fileName.split('.').pop();
                if ( ext == "csv" || ext == "CSV" ) {
                $(this).next('.custom-file-label').addClass("selected").html(fileName);
                } else {
                $(this).html("");
                swal("Oops!", "Only CSV file!", "error");
                }
            }); 
        // search mau hapus after import (salah import)
        $(".btn_search").click(function(){
            var project = $("#project_title_dropdown_search").val();
            var product = $("#product_dropdown_search").val();
            var customer = $("#customers_dropdown_search").val();

            if (project == "-" || product =="-" || customer=="-") {
                $(".text_search").empty();
                $(".div_hapus").empty();
                $(".text_search").html("<b> Data : 0 rows</b>");
            } else {
                // krim ke controller 
                $.ajax({
                        url: "{{route('NewProductPortalScheduleAjiController.search_schedule_aji_upload')}}",
                        type: "post",
                        data: {
                            _token: '{{csrf_token()}}',
                            project:project,
                            product:product,
                            customer:customer,
                        },
                        dataType: 'json',
                        success: function (res) {
                                $(".text_search").empty();
                                $(".text_search").html("<b> Data : "+res+" rows</b>");

                                if (res > 0) {
                                    $(".div_hapus").html("<button type='button' class='btn btn-danger hapus'>Delete</button>");
                                }else{
                                    $(".div_hapus").empty();
                                }


                                // mulai btn hapus
                                    // hapus rows sesuai search
                                        $(".hapus").click(function(){
                                            var result = confirm("Are you sure?");
                                            if (result) {
                                                var project = $("#project_title_dropdown_search").val();
                                                var product = $("#product_dropdown_search").val();
                                                var customer = $("#customers_dropdown_search").val();  

                                                if (project == "-" || product =="-" || customer=="-") {
                                                    $(".text_search").empty();
                                                    $(".div_hapus").empty();
                                                    $(".text_search").html("<b> Data : 0 rows</b>");
                                            } else {
                                                    // krim ke controller 
                                                    $.ajax({
                                                            url: "{{route('NewProductPortalScheduleAjiController.search_schedule_aji_upload')}}",
                                                            type: "post",
                                                            data: {
                                                                _token: '{{csrf_token()}}',
                                                                project:project,
                                                                product:product,
                                                                customer:customer,
                                                                delete:1,
                                                            },
                                                            dataType: 'json',
                                                            success: function (res) {
                                                                console.log(res);
                                                                    if (res == "0") {
                                                                        swal("Oops!", "Delete error!", "error");
                                                                    } else {
                                                                        swal("success!", "Delete success!", "success");
                                                                        location.reload();
                                                                    }
                                                            } 
                                                        });    
                                                }
                                            } else {
                                               
                                            }
                                           
                                        });
                        } 
                    });    
            }

            
            
        });
      });



    </script>
@endpush

