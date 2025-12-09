<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Portal Web | {{ $title }}</title>

    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('font-awesome/css/font-awesome.css') }}" rel="stylesheet">
    <link href="{{ asset('css/plugins/iCheck/custom.css') }}" rel="stylesheet">
    <link href="{{ asset('css/animate.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('css/plugins/daterangepicker/daterangepicker-bs3.css') }}" rel="stylesheet">
    <link href="{{ asset('css/plugins/datapicker/datepicker3.css') }} " rel="stylesheet">
    <link href="{{ asset('css/plugins/select2/select2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/plugins/footable/footable.core.css') }}" rel="stylesheet">
    <link href="{{ asset('css/plugins/steps/jquery.steps.css')}}" rel="stylesheet">
    <link href="{{ asset('css/plugins/dataTables/datatables.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/plugins/nouslider/jquery.nouislider.css') }}" rel="stylesheet">

    <link href="{{ asset('css/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css') }}" rel="stylesheet">
    @livewireStyles
    @stack('stylesheets')
    
</head>

<body>


    <div id="wrapper">


    <nav class="navbar-default navbar-static-side" role="navigation">
        <div class="sidebar-collapse">
            <ul class="nav metismenu" id="side-menu">


                <li class="nav-header">
                    <div class="dropdown profile-element">
                        {{-- <img alt="image" class="rounded-circle" src="img/profile_small.jpg"/> --}}
                        <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <span class="block m-t-xs font-bold">{{ auth()->user()->name }}</span>
                            <span class="text-muted text-xs block">{{ auth()->user()->detail->name }}</span>
                        </a>
                    </div>
                    <div class="logo-element">
                        AJI
                    </div>
                </li>


                <li class="@if($halaman == "Dashboard") {{ 'active' }} @endif">
                    <a href="{{url('/')}}"><i class="fa fa-line-chart"></i> <span class="nav-label">Dashboards</span></a>
                </li>


                <li class="@if($halaman == "Laporan") {{ 'active' }} @endif">
                    <a href="#"><i class="fa fa-file-text"></i> <span class="nav-label">EHS Patrol</span> <span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level collapse">
                        <li class="@if($active == "Laporan Patrol") {{ 'active' }} @endif"><a href="{{url('patrolEHS')}}">Laporan Patrol</a></li>
                        @if(auth()->user()->roles[0]->name != "Admin" && auth()->user()->roles[0]->name != "Departement Head EHS" && auth()->user()->roles[0]->name != "member")
                        <li class="@if($active == "Laporan Saya") {{ 'active' }} @endif"><a href="{{url('table')}}">Temuan Saya</a></li>
                        @endif
                        @if(auth()->user()->roles[0]->name != "PIC" && auth()->user()->roles[0]->name != "Departement Head PIC" )
                        <li class="@if($active == "Semua Laporan") {{ 'active' }} @endif"><a href="{{url('alltable')}}">Semua Temuan</a></li>
                        @endif
                        {{-- @role('EHS')
                        <li class="@if($active == "Pembuatan Laporan") {{ 'active' }} @endif"><a href="{{ url('createform') }}">Buat Laporan</a></li>
                        @endrole --}}
                    </ul>
                </li>
               
                {{-- <li  class="@if($halaman == "genba") {{ 'active' }} @endif">
                    <a href="#"><i class="fa fa-empire"></i> <span class="nav-label">Management Patrol</span><span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level collapse">
                        <li class="@if($active == "schedule") {{ 'active' }} @endif"><a href="{{ url('genba/schedule') }}">Schedule Genba</a></li>
                        <li class="@if($active == "temuan_genba") {{ 'active' }} @endif"><a href="{{ url('genba/table') }}">Temuan Genba</a></li>
                        @if(auth()->user()->roles[0]->name == "EHS")
                        <li class="@if($active == "team") {{ 'active' }} @endif"><a href="{{ url('genba/team') }}">Team Management</a></li>
                        @endif
                    </ul>
                </li> --}}


                @if(auth()->user()->roles[0]->name == "Admin" )
                <li  class="@if($halaman == "Setting") {{ 'active' }} @endif">
                    <a href="#"><i class="fa fa-sitemap"></i> <span class="nav-label">Setting Management</span><span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level collapse">
                        <li class="@if($active == "Account Management") {{ 'active' }} @endif"><a href="{{ url('karyawan') }}">Account Management</a></li>
                        <li class="@if($active == "area Management") {{ 'active' }} @endif"><a href="{{ url('area') }}">Area Management</a></li>
                    </ul>
                </li>
                @endif
            </ul>


        </div>
    </nav>


        <div id="page-wrapper" class="gray-bg">
        <div class="row border-bottom">
        <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
        <div class="navbar-header">
            <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>
        </div>
            <ul class="nav navbar-top-links navbar-right">
                <li>
                    <span class="m-r-sm text-muted welcome-message">Welcome To Portal Web</span>
                </li>
                @livewire('notification')
                @stack('scripts')
                <li>
                    <form action="{{ url('logout') }}" method="post">
                        @csrf
                        <button type="submit" class="text-muted border-0 btn">
                            <i class="fa fa-sign-out "></i> Log out
                        </button>
                    </form>
                </li>
            </ul>


        </nav>
        </div>


        <div class="wrapper wrapper-content animated fadeInRight ecommerce">




            <div class="ibox-content m-b-sm border-bottom">
                <div class="row">
                    <div class="col-sm-4 m-b-xs form-group " id="data_5">
                        <label class="col-form-label" for="quantity">Range Date</label>
                        <div class="input-daterange input-group" id="datepicker">
                           
                            <span class="input-group-addon">From</span>
                            <input type="text" class="form-control-sm form-control" id="time-start" name="timeStart" value="01/01/2000"/>
                            <span class="input-group-addon">to</span>
                            <input type="text" class="form-control-sm form-control" id="time-end" name="timeEnd" value="{{ date('d/m/Y') }}" />
                        </div>
                    </div>
                </div>


            </div>


            <div class="row">
                <div class="col-lg-12">
                    <div class="ibox">
                        <div class="ibox-content">
                        <div>


                            <div class="table-responsive mt-3 ">
                                <table class="table table-striped table-bordered table-hover dataTables-example" >
                                    <thead>
                                    <tr>
                                        <th class="all">No</th>
                                        <th class="text-center all">Event </th>
                                        <th class="text-center" >user </th>
                                        <th class="text-center" >area</th>
                                        <th class="text-center" >deskripsi</th>
                                        <th class="text-center all" >Waktu</th>
                                        <th class="text-center" >Action</th>
                                    </tr>
                                    </thead>
                                   
                                    <tfoot>
                                           
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                        </div>
                    </div>
                </div>
            </div>




        </div>
        <div class="footer">
            <div>
                <strong>PT. Astra Juoku Indonesia</strong>
            </div>
        </div>
       
    </div>
</div>

<script src={{ asset('js/jquery-3.1.1.min.js') }}></script>
    <script src={{ asset('js/popper.min.js') }}></script>
    <script src={{ asset('js/bootstrap.js') }}></script>
    <script src={{ asset('js/plugins/slimscroll/jquery.slimscroll.min.js') }}></script>
    <script src={{ asset('js/plugins/datapicker/bootstrap-datepicker.js') }}></script>
    <script src={{ asset('js/plugins/dataTables/datatables.min.js') }}></script>
    <script src={{ asset('js/plugins/dataTables/dataTables.bootstrap4.min.js') }}></script>
    <script src={{ asset('js/plugins/select2/select2.full.min.js') }}></script>
    <script src={{ asset('js/plugins/footable/footable.all.min.js') }}></script>
    <script src={{ asset('js/plugins/nouslider/jquery.nouislider.min.js') }}></script>
    <script src={{ asset('js/demo/peity-demo.js') }}></script>
    <script src={{ asset('js/plugins/peity/jquery.peity.min.js') }}></script>
    <script src={{ asset('js/plugins/metisMenu/jquery.metisMenu.js') }}></script>


     <!-- Steps -->
     <script src={{ asset("js/plugins/steps/jquery.steps.min.js") }}></script>

     <!-- Jquery Validate -->
     <script src={{ asset("js/plugins/validate/jquery.validate.min.js") }}></script>

    <!-- Custom and plugin javascript -->
    <script src={{ asset('js/inspinia.js') }}></script>
    <script src={{ asset('js/plugins/pace/pace.min.js') }}></script>

    <!-- iCheck -->
    <script src={{ asset('js/plugins/iCheck/icheck.min.js') }}></script>
        <script>
             $(document).ready(function () {
            var table =   $('.dataTables-example').DataTable({
                    pageLength: 10,
                    responsive: true,
                    dom: '<"html5buttons"B>lTfgitp',
                    buttons: [],
                    "processing": true,
                    "serverSide": true,
                    "ajax": {
                        "url": "{{ config('app.link_website') }}/activity-logbs",
                        // "url": "http://10.14.143.89/portal-web/public/activity-logbs",
                        "type": "GET", // Menentukan metode HTTP yang digunakan
                        "data": function (d) {
                            // Kirim parameter tambahan ke server
                            d.start = d.start || 0; // Mulai dari indeks 0 jika tidak didefinisikan
                            d.length = d.length || 10; // Panjang halaman 10 jika tidak didefinisikan
                            d.kategori = $('#kategori-filter').val();
                            d.rank = $('#rank-filter').val();
                            d.area = $('#area-filter').val();
                            d.timeStart = $('#time-start').val();
                            d.timeEnd = $('#time-end').val();
                            d.tipeTable = $('#tipeTable').val();
                            d.genba_table = $('#genba_table').val();
                            d.status = $('#status-filter').val();
                            d._token = "{{ csrf_token() }}";
                            return d;
                        }
                    },
                    "columns": [
                    {"data": "iteration"},
                    {"data": "event", "orderable": false},
                    {"data": "user", "orderable": false},
                    {"data": "area", "orderable": false},
                    {"data": "deskripsi", "orderable": false},
                    {"data": "waktu", "orderable": false},
                    {"data": "action", "orderable": false},
                    
                ],
                
                "drawCallback": function(settings) {
                    // Menengahkan teks di dalam setiap sel pada tabel
                    $('.dataTables-example').find('td').css('text-align', 'center');
                }
                });
                $('#kategori-filter, #rank-filter,#area-filter, #status-filter, #time-start, #time-end').on('change', function() {
                    table.ajax.reload();
                });
                
                $('.dataTables-example').on('draw.dt', function () {
                    // Tempatkan inisialisasi Peity di sinile.order();
                    var order = table.order();
                    // console.log(order);
                    // Dapatkan informasi halaman DataTables
                    if (order && order.length > 0 && order[0][1] === 'desc') {
                        var pageInfo = table.page.info();
                        var start = pageInfo.start;

                        // Perbarui nomor iterasi sesuai dengan urutan baru
                        $('.dataTables-example').DataTable().column(0, { search: 'applied', order: 'applied' }).nodes().each(function (cell, i) {
                            cell.innerHTML = pageInfo.recordsTotal - start - i;
                        });
                    } else if (order && order.length > 0 && order[0][1] === 'asc') {
                        var pageInfo = table.page.info();
                        var start = pageInfo.start;
                        $('.dataTables-example').DataTable().column(0, { search: 'applied', order: 'applied' }).nodes().each(function (cell, i) {
                            cell.innerHTML = start + i + 1;
                        });
                    }
                });
                $('#data_5 .input-daterange').datepicker({
                format: 'dd/mm/yyyy', // Format tampilan
                keyboardNavigation: false,
                forceParse: false,
                autoclose: true
                });

                var currentDate = new Date();
                var mem = $('#data_1 .input-group.date').datepicker({
                format: 'dd/mm/yyyy', // Format tampilan
                todayBtn: "linked",
                keyboardNavigation: false,
                forceParse: false,
                calendarWeeks: true,
                autoclose: true
            });
            });
        </script>
</body>

</html>
