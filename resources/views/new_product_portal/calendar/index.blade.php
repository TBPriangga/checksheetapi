@extends('layouts.app-master')

@section('content')
    {{-- datatable library css --}}
    <link href="{{asset('css/jquery.dataTables.min.css')}}" rel="stylesheet">
    <link href="{{asset('css/plugins/sweetalert/sweetalert.css')}}" rel="stylesheet">
    <script src="{{asset('js/js_agil/index.global1.js')}}"></script>
    <script src="{{asset('js/js_agil/index.global.min.js')}}"></script>

    <!-- Sweet Alert -->
    <div class="ibox" >
        <div class="ibox-title">
            <h4>Calendar Event</h4>
        </div>
        <div class="ibox-content">
            <div class="mt-2">
                @include('layouts.partials.messages')
            </div>
            <div class="row">
                <div class="col-3">
                    <label for="">Customer</label>
                    <select name="customer_search" id="customer_search" class="form-control">
                        <option value="">-</option>
                        <option value="General">General</option>
                        @foreach ($customers as $customer)
                            <option value="{{$customer->code}}">{{$customer->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-2">
                    <label for="">Project</label>
                    <select name="project_search" id="project_search" class="form-control">
                        <option value="">-</option>
                        <option value="General">General</option>
                        @foreach ($projects as $project)
                            <option value="{{$project->project_title}}">{{$project->project_title}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-2">
                    <label for="">Product</label>
                    <select name="product_search" id="product_search" class="form-control">
                        <option value="">-</option>
                        <option value="General">General</option>
                        @foreach ($products as $product)
                            <option value="{{$product->product}}">{{$product->product}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-2">
                    <label for="">Dept</label>
                    <select name="dept_search" id="dept_search" class="form-control">
                        <option value="">-</option>
                        @foreach ($detail_dept_ids as $dept)
                            <option value="{{$dept->code}}">{{$dept->code}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-3 text-center">
                    <label for="">Month Year</label>
                    <input type="month" class="form-control mb-4" id="range-date" name="range-date">
                </div>
            </div>
            <div id="calendar"></div>
        </div>
    </div>

@role('APQP Uploader')
    <div class="modal inmodal" id="myModal" tabindex="-1"   role="dialog" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content animated bounceInRight">
                <div class="modal-header">
                    <h4 class="modal-title">Insert Event</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                </div>
                <div class="modal-body">
                    <form action="#" id="myForm">
                        {{csrf_field()}}
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Customer</label> 
                                    <select name="customer" id="customer" class="form-control">
                                        <option value="General">General</option>
                                        @foreach ($customers as $customer)
                                            <option value="{{$customer->code}}">{{$customer->name}}</option>
                                        @endforeach
                                    </select>
                                    @error('customer') 
                                        <div class="text-danger">
                                            {{$message}}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Project</label> 
                                    <select name="project" id="project" class="form-control">
                                        <option value="General">General</option>
                                        @foreach ($projects as $project)
                                            <option value="{{$project->project_title}}">{{$project->project_title}}</option>
                                        @endforeach
                                    </select>
                                    @error('project') 
                                        <div class="text-danger">
                                            {{$message}}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Product</label> 
                                    <select name="product" id="product" class="form-control">
                                        <option value="General">General</option>
                                        @foreach ($products as $product)
                                            <option value="{{$product->product}}">{{$product->product}}</option>
                                        @endforeach
                                    </select>
                                    @error('product') 
                                        <div class="text-danger">
                                            {{$message}}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Event Name</label> 
                                    <input type="text" placeholder="event name" name="name" class="form-control @error('name') is-invalid @enderror" value="{{old('name')}}" required>
                                    @error('name') 
                                        <div class="text-danger">
                                            {{$message}}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Description</label> 
                                    <input type="text" placeholder="description" name="description" class="form-control @error('description') is-invalid @enderror" value="{{old('description')}}" required>
                                    @error('description') 
                                        <div class="text-danger">
                                            {{$message}}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Date</label> 
                                    <input type="date" placeholder="date" name="date" class="form-control @error('date') is-invalid @enderror" value="{{old('date')}}">
                                    @error('date') 
                                        <div class="text-danger">
                                            {{$message}}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Label Color</label> 
                                    {{-- <select name="color" class="form-control" id="color">
                                        <option value="black" >Black </option>
                                        <option value="#1b7035" >Green </option>
                                        <option value="#18239e" >Blue </option>
                                        <option value="#c91827" >Red </option>
                                        <option value="#c2650e" >Brown </option>
                                    </select> --}}
                                    <input type="color" name="color" id="color" class="form-control">
                                    @error('event') 
                                        <div class="text-danger">
                                            {{$message}}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                </form>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary btn_submit">Add</button>  
                </div>
            </div>
        </div>
    </div>
@endrole
@role('APQP Viewer')
    <div class="modal inmodal" id="myModal" tabindex="-1"   role="dialog" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content animated bounceInRight">
                <div class="modal-header">
                    <h4 class="modal-title">Insert Event</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                </div>
                <div class="modal-body">
                    <form action="#" id="myForm">
                        {{csrf_field()}}
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Customer</label> 
                                    <select name="customer" id="customer" class="form-control">
                                        <option value="General">General</option>
                                        @foreach ($customers as $customer)
                                            <option value="{{$customer->code}}">{{$customer->name}}</option>
                                        @endforeach
                                    </select>
                                    @error('customer') 
                                        <div class="text-danger">
                                            {{$message}}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Project</label> 
                                    <select name="project" id="project" class="form-control">
                                        <option value="General">General</option>
                                        @foreach ($projects as $project)
                                            <option value="{{$project->project_title}}">{{$project->project_title}}</option>
                                        @endforeach
                                    </select>
                                    @error('project') 
                                        <div class="text-danger">
                                            {{$message}}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Product</label> 
                                    <select name="product" id="product" class="form-control">
                                        <option value="General">General</option>
                                        @foreach ($products as $product)
                                            <option value="{{$product->product}}">{{$product->product}}</option>
                                        @endforeach
                                    </select>
                                    @error('product') 
                                        <div class="text-danger">
                                            {{$message}}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Event Name</label> 
                                    <input type="text" placeholder="event name" name="name" class="form-control @error('name') is-invalid @enderror" value="{{old('name')}}" required>
                                    @error('name') 
                                        <div class="text-danger">
                                            {{$message}}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Description</label> 
                                    <input type="text" placeholder="description" name="description" class="form-control @error('description') is-invalid @enderror" value="{{old('description')}}" required>
                                    @error('description') 
                                        <div class="text-danger">
                                            {{$message}}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Date</label> 
                                    <input type="date" placeholder="date" name="date" class="form-control @error('date') is-invalid @enderror" value="{{old('date')}}">
                                    @error('date') 
                                        <div class="text-danger">
                                            {{$message}}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Label Color</label> 
                                    {{-- <select name="color" class="form-control" id="color">
                                        <option value="black" >Black </option>
                                        <option value="#1b7035" >Green </option>
                                        <option value="#18239e" >Blue </option>
                                        <option value="#c91827" >Red </option>
                                        <option value="#c2650e" >Brown </option>
                                    </select> --}}
                                    <input type="color" name="color" id="color" class="form-control">
                                    @error('event') 
                                        <div class="text-danger">
                                            {{$message}}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                </form>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary btn_submit">Add</button>  
                </div>
            </div>
        </div>
    </div>
@endrole

@endsection

@push('scripts')

<script type="text/javascript">

  $(document).ready(function() {
    
    var myObject = JSON.parse(@json($data));


    $(".btn_submit").click(function(){

        var form = document.getElementById('myForm');
        if ($("#myForm input[name='name']").val() != '' && $("#myForm input[name='date']").val() != null && $("#myForm input[name='description']").val() != '') {
            // Create a JavaScript object and populate it with input values
            var formData = {
                 name: $("#myForm input[name='name']").val(),
                 event: $("#myForm select[name='event']").val(),
                 customer: $("#myForm select[name='customer']").val(),
                 project: $("#myForm select[name='project']").val(),
                 product: $("#myForm select[name='product']").val(),
                 description: $("#myForm input[name='description']").val(),
                 date: $("#myForm input[name='date']").val(),
                 color: $("#myForm input[name='color']").val(),
                 pic:"{{ auth()->user()->detail_department->code }}",
            };
            $.ajax({
                    url: "{{route('calendar.store')}}",
                    type: "post",
                    data: {
                        _token: '{{csrf_token()}}',
                        form: JSON.stringify(formData, null, 2),
                    },
                    dataType: 'json',
                    success: function (res) {
                        
                        if (res == "0") {
                            swal("oops!", "add failed!", "error");
                        } else {
                            console.log(res);
                            $("#myModal").modal('hide');
                            form.reset();
                            swal("success!", "add success!", "success");
                            location.reload();
                        }
                    } 
                });
        } else {
            swal("oops!", "add failed! fill all inputs!", "error");
        }

    });
    // Use the map() modif key name ke title, date ke start
     let updatedArray = myObject.map(obj => {
        const { name, date, ...rest } = obj; 
        return {
            ...rest,
            title: name, 
            start: date, 
        };
    });

    console.log(updatedArray);


    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
      eventStartEditable: false,
      headerToolbar: {
        left: 'prevYear,prev,next,nextYear today',
        center: 'title',
        right: 'dayGridMonth,dayGridWeek,dayGridDay'
      },
      initialDate: new Date(),
      selectable: true,
      navLinks: true, // can click day/week names to navigate views
      editable: true,
      dayMaxEvents: true, // allow "more" link when too many events
      events: updatedArray,
      dateClick: function(info) {
                var userResponse = confirm("Insert Event ?");
                    
                // Check the user's response
                if (userResponse) {
                    var date_selected = info.dateStr;
                    $("input[name='date']").val(date_selected);
                    $("#myModal").modal('show');
                } else {
                }
            // if ('{{Auth::user()->hasRole("APQP Uploader")}}') {
            //     var userResponse = confirm("Insert Event ?");
                    
            //     // Check the user's response
            //     if (userResponse) {
            //         var date_selected = info.dateStr;
            //         $("input[name='date']").val(date_selected);
            //         $("#myModal").modal('show');
            //     } else {
            //     }
            // } else {
            // }
      },
      eventDidMount: function (info) {
            var description = info.event.extendedProps.description || '';
            var customer = info.event.extendedProps.customer || '';
            var project = info.event.extendedProps.project || '';
            var product = info.event.extendedProps.product || '';
            var pic = info.event.extendedProps.pic || '';
            var detail_dept_id = info.event.extendedProps.detail_dept_id || '';
            
            // Set the event title as well as the description as the title attribute
            info.el.setAttribute('title', "\n event : "+ info.event.title + '\n desc: ' + description+ '\n customer: ' + customer+ '\n project: ' + project+ '\n product: ' + product+ '\n pic: ' + pic + '\n dept: ' + detail_dept_id);
        },
      eventClick: function(info) {
            var id_event=info.event._def.publicId;
            var detail_dept_id = info.event.extendedProps.detail_dept_id || '';
            if ('{{Auth::user()->hasRole("APQP Uploader")}}' || '{{auth()->user()->detail_department->code}}' == detail_dept_id ) {
            var userResponse = confirm("Delete Event ?");
                
                // Check the user's response
                if (userResponse) {
                //    kirim hapus
                    $.ajax({
                        url: "{{route('calendar.store')}}",
                        type: "post",
                        data: {
                            _token: '{{csrf_token()}}',
                            id: id_event,
                        },
                        dataType: 'json',
                        success: function (res) {
                            
                            if (res == "0") {
                                swal("oops!", "delete failed!", "error");
                                location.reload();

                            } else {
                                swal("success!", "delete success!", "success");
                                location.reload();

                            }
                        } 
                    });
                } else {

                }
        }
      },
      
    });

    calendar.render();

    $("#range-date").change(function(){
        calendar.gotoDate( this.value );
    });
    // Add event listener for search input
    $('#customer_search, #project_search, #product_search, #dept_search').on('change', function() {
        var keyword1 = $('#customer_search').val().toLowerCase();
        var keyword2 = $('#project_search').val().toLowerCase();
        var keyword3 = $('#product_search').val().toLowerCase();
        var keyword4 = $('#dept_search').val().toLowerCase();console.log(keyword4);
        var matchingEventYear = null;
        // Filter and display events based on the keyword
        calendar.getEvents().forEach(function(event) {
            var eventTitle = event.title.toLowerCase();
            var customer = event.extendedProps.customer.toLowerCase();
            var project = event.extendedProps.project.toLowerCase();
            var product = event.extendedProps.product.toLowerCase();
            var dept = event.extendedProps.detail_dept_id.toLowerCase();
            if (customer.includes(keyword1) &&  project.includes(keyword2)  &&  product.includes(keyword3)  &&  dept.includes(keyword4) ) {
                event.setProp('display', 'auto');
                // Get the year of the matching event
                var eventYear = event.start.getFullYear();
                
                // If we haven't set a matching year yet, set it
                if (matchingEventYear === null) {
                    matchingEventYear = eventYear;
                } else if (eventYear < matchingEventYear) {
                    matchingEventYear = eventYear; // Update to the earliest year
                }
            } else {
            event.setProp('display', 'none');
            }
        });
    });

  });

  // Apply custom CSS to change event title color to white
    document.addEventListener('DOMContentLoaded', function() {
        var styleTag = document.createElement('style');
        styleTag.innerHTML = '.fc-event-title { color: white; }';
        document.head.appendChild(styleTag);
    });
</script>
<script src="{{asset('js/plugins/sweetalert/sweetalert.min.js')}}"></script>
<script src="{{asset('js/moment.min.js')}}"></script>

@endpush
