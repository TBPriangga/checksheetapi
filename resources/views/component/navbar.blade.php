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
    {{-- style css file APAR --}}
    <link href="{{ asset('css/aparStyle.css') }}" rel="stylesheet">
    <link href="{{ asset('css/plugins/daterangepicker/daterangepicker-bs3.css') }}" rel="stylesheet">
    <link href="{{ asset('css/plugins/datapicker/datepicker3.css') }} " rel="stylesheet">
    <link href="{{ asset('css/plugins/select2/select2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/plugins/footable/footable.core.css') }}" rel="stylesheet">
    <link href="{{ asset('css/plugins/steps/jquery.steps.css')}}" rel="stylesheet">
    <link href="{{ asset('css/plugins/dataTables/datatables.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/plugins/nouslider/jquery.nouislider.css') }}" rel="stylesheet">
    <link href="{{ asset('css/plugins/chosen/bootstrap-chosen.css') }}" rel="stylesheet">

    <link href="{{ asset('css/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css') }}" rel="stylesheet">
    @livewireStyles

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
                            @if(auth()->user()->hasRole('PIC') || auth()->user()->hasRole('EHS'))
                            <span class="text-muted text-xs block">{{ auth()->user()->detail->name }}</span>
                            @else
                            <span class="text-muted text-xs block">{{ auth()->user()->department->name }}</span>
                            @endif
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
                        @role(['EHS','Departement Head EHS'])
                        <li class="@if($active == "Semua Laporan") {{ 'active' }} @endif"><a href="{{url('alltable')}}">Semua Temuan</a></li>
                        @endif
                        {{-- @role('EHS')
                        <li class="@if($active == "Pembuatan Laporan") {{ 'active' }} @endif"><a href="{{url('createform')}}">Buat Laporan</a></li>
                        @endrole --}}
                    </ul>
                </li>
                {{-- <li class="@if($halaman == 'Hyarihatto Activity') {{ 'active' }} @endif">
                    <a href="#"><i class="fa fa-tasks"></i> <span class="nav-label">Hyarihatto Activity</span> <span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level collapse">
                        @if (auth()->user()->hasRole('EHS'))
                            <li class="@if($active == "hyarihatto") {{ 'active' }} @endif">
                                <a href="{{ route('dashboard.point') }}">Dashboard point</a>
                            </li>
                            <li class="@if($active == "import-laporan") {{ 'active' }} @endif">
                                <a href="{{ route('laporan.import.index') }}">Import Excel</a>
                            </li>
                            <li class="@if($active == 'list-laporan') {{ 'active' }} @endif">
                                <a href="{{ route('laporan.list.index') }}">List Laporan</a>
                            </li>
                        @endif
                    </ul>
                </li> --}}
                <li class="@if($halaman == 'Hyarihatto Activity') {{ 'active' }} @endif">
                        <a href="#"><i class="fa fa-tasks"></i> <span class="nav-label">Hyarihatto Activity</span> <span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level collapse">
                            @role(['Admin', 'EHS', 'PIC', 'Departement Head PIC', 'Departement Head EHS'])
                                <li class="@if($active == 'hyarihatto') {{ 'active' }} @endif">
                                    <a href="{{ route('dashboard.point') }}">Dashboard Point</a>
                                </li>
                            @endrole
                            @role(['Admin', 'EHS'])
                                <li class="@if($active == 'import-laporan') {{ 'active' }} @endif">
                                    <a href="{{ route('laporan.import.index') }}">Import Excel</a>
                                </li>
                            @endrole
                            @role(['Admin', 'EHS', 'PIC', 'Departement Head PIC', 'Departement Head EHS'])
                                <li class="@if($active == 'list-laporan') {{ 'active' }} @endif">
                                    <a href="{{ route('laporan.list.index') }}">List Laporan</a>
                                </li>
                            @endrole
                        </ul>
                </li>
                <li class="@if($halaman == 'Inspeksi APAR') {{ 'active' }} @endif">
                    <a href="#"><i class="fa fa-fire-extinguisher"></i> <span class="nav-label">Inspeksi APAR</span> <span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level collapse">
                        @if (auth()->user()->hasRole('EHS'))
                            <li class="@if($active == "form-pemeriksaan") {{ 'active' }} @endif">
                                <a href="{{ route('inspeksi-apar.index') }}">Form Pemeriksaan</a>
                            </li>
                            <li class="@if($active == "monitoring-apar") {{ 'active' }} @endif">
                                <a href="{{ route('monitoring-apar') }}">Monitoring APAR</a>
                            </li>
                            <li class="@if($active == 'manage-pic') {{ 'active' }} @endif">
                                <a href="">Kelola PIC</a>
                            </li>
                        @endif
                    </ul>
                </li>
                @if(auth()->user()->roles[0]->name != "Admin")
                <li class="@if($halaman == "Profile") {{ 'active' }} @endif">
                    <a href="{{url('/profile')}}"><i class="fa fa-user-o"></i> <span class="nav-label">Profile</span></a>
                </li>
                @endif

                {{-- <li  class="@if($halaman == "genba") {{ 'active' }} @endif">
                    <a href="#"><i class="fa fa-empire"></i> <span class="nav-label">Management Patrol</span><span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level collapse">
                        <li class="@if($active == "schedule") {{ 'active' }} @endif"><a href="/genba/schedule">Laporan Patrol</a></li>
                        <li class="@if($active == "temuan_genba") {{ 'active' }} @endif"><a href="/genba/table">Temuan Genba</a></li>
                        @if(auth()->user()->roles[0]->name == "EHS")
                        <li class="@if($active == "team") {{ 'active' }} @endif"><a href="/genba/team">Team Management</a></li>
                        @endif
                    </ul>
                </li> --}}

                @if(auth()->user()->roles[0]->name == "Admin")
                <li  class="@if($halaman == "Setting") {{ 'active' }} @endif">
                    <a href="#"><i class="fa fa-sitemap"></i> <span class="nav-label">Setting Management</span><span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level collapse">
                        <li class="@if($active == "Account Management") {{ 'active' }} @endif"><a href="{{url('karyawan')}}">Account Management</a></li>
                        <li class="@if($active == "area Management") {{ 'active' }} @endif"><a href="{{url('area')}}">Area Management</a></li>
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
                    <span class="m-r-sm text-muted welcome-message">{{ auth()->user()->name }}</span>
                    <span class="m-r-sm text-muted mobile-profile">{{ auth()->user()->name }}</span>
                </li>
                @livewire('notification')
                @stack('scripts')
                <li>
                    <form action="{{ route('logout') }}" method="post" id="logoutForm">
                        @csrf
                        <button type="submit" class="text-muted border-0 btn" id="logoutBtn">
                            <i class="fa fa-sign-out "></i> Log out
                        </button>
                    </form>
                </li>
            </ul>

        </nav>
        </div>

@yield('content')

        <div class="footer">
            <div>
                <strong>PT. Astra Juoku Indonesia</strong>
            </div>
        </div>

    </div>
</div>
@yield('scripts')


    <!-- Mainly scripts -->
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
   <script src="https://cdn.canvasjs.com/canvasjs.stock.min.js"></script>
    <script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>

@livewireScripts
    <script>
        document.getElementById('logoutForm').addEventListener('submit', function() {
            document.getElementById('logoutBtn').disabled = true;
        });
    </script>
    <script>
        document.getElementById('rotate-button1').addEventListener('click', function() {
            const image = document.getElementById('image-to-rotate1');
            let currentRotation = parseInt(image.getAttribute('data-rotation')) || 0;

            // Rotate by 90 degrees
            currentRotation += 90;
            if (currentRotation >= 360) {
                currentRotation = 0;
            }

            image.style.transform = `rotate(${currentRotation}deg)`;
            image.setAttribute('data-rotation', currentRotation);
        });

        document.getElementById('rotate-button2').addEventListener('click', function() {
            const image = document.getElementById('image-to-rotate2');
            let currentRotation = parseInt(image.getAttribute('data-rotation')) || 0;

            // Rotate by 90 degrees
            currentRotation += 90;
            if (currentRotation >= 360) {
                currentRotation = 0;
            }

            image.style.transform = `rotate(${currentRotation}deg)`;
            image.setAttribute('data-rotation', currentRotation);
        });


    </script>


    <!-- iCheck -->
    <script src={{ asset('js/plugins/iCheck/icheck.min.js') }}></script>
        <script>
            $.fn.dataTable.ext.errMode = 'none';
            $(document).ready(function () {
                // uppercase
                 function convertTextToUppercase(node) {
                    if (node.nodeType === 3) { // Node.TEXT_NODE
                        var text = node.textContent || node.innerText;
                        var uppercaseText = text.toUpperCase();
                        if (node.textContent) {
                            node.textContent = uppercaseText;
                        } else {
                            node.innerText = uppercaseText;
                        }
                    } else if (node.nodeType === 1) { // Node.ELEMENT_NODE
                        $(node).contents().each(function () {
                            convertTextToUppercase(this);
                        });
                    }
                }

                $("html").each(function() {
                    convertTextToUppercase(this);
                });


                    $(".pie").peity("pie", {
                        fill: ["#1ab394", "#d7d7d7", "#ffffff"]
                    });

                    $(".pou").peity("pie", {
                        fill: ["#FFC300", "#d7d7d7", "#ffffff"] // Anda bisa gunakan kode warna kuning
                    });

                    $(".pop").peity("pie", {
                        fill: ["#FF2C2C", "#d7d7d7", "#ffffff"] // Anda bisa gunakan kode warna kuning
                    });

                    $(".pops").peity("pie", {
                        fill: ["#FF2C2C", "#FF2C2C", "#ffffff"] // Anda bisa gunakan kode warna kuning
                    });

                $('.dataTables-example-team').DataTable({
                pageLength: 25,
                responsive: true,
                dom: '<"html5buttons"B>lTfgitp',
                buttons: [ ],
            });

                $('.dataTables-example-temuan-patrol').DataTable({
                pageLength: 10,
                responsive: true,
                    columnDefs: [
                        { responsivePriority: 1, targets: 0 },
                        { responsivePriority: 2, targets: 2 },
                        { responsivePriority: 3, targets: 7 },
                        { responsivePriority: 4, targets: 5 },
                        { responsivePriority: 5, targets: 3 },
                        { responsivePriority: 6, targets: 4 },
                        { responsivePriority: 7, targets: 5 },
                        { responsivePriority: 8, targets: 6 },
                    ],
                dom: '<"html5buttons"B>lTfgitp',
                buttons: [ ],
            });


                $(".select2_demo_3").select2({
                placeholder: "Select a state",
                allowClear: true
                });

            var table =   $('.dataTables-example').DataTable({
                    pageLength: 10,
                    responsive: true,
                    columnDefs: [
                        { responsivePriority: 1, targets: 0 },
                        { responsivePriority: 2, targets: 2 },
                        { responsivePriority: 3, targets: 7 },
                        { responsivePriority: 4, targets: 5 },
                        { responsivePriority: 5, targets: 3 },
                        { responsivePriority: 6, targets: 4 },
                        { responsivePriority: 7, targets: 5 },
                        { responsivePriority: 8, targets: 6 },
                        { responsivePriority: 9, targets: 7 },
                    ],
                    dom: '<"html5buttons"B>lTfgitp',
                    buttons: [],
                    "processing": true,
                    "serverSide": true,
                    "ajax": {
                        "url": "{{ config('app.link_website') }}/table",
                        // "url": "http://10.14.143.89/portal-web/public/table",
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
                    {"data": "iteration" },
                    {"data": "temuan"},
                    {"data": "area"},
                    {"data": "kategori"},
                    {"data": "rank"},
                    {"data": "tanggal_laporan"},
                    {"data": "deadline"},
                    {"data": "progress"},
                    {"data": "assign_to"},
                    {"data": "action", "orderable": false},
                ],

                "drawCallback": function(settings) {
                    // Menengahkan teks di dalam setiap sel pada tabel
                    $('.dataTables-example').find('td').css('text-align', 'center');
                    $('.dataTables-example').find('td').css('font-size', '12px');
                    $('.dataTables-example').find('th').css('font-size', '12px');
                    $("td").each(function() {
                        convertTextToUppercase(this);
                    });
                }
                });
                $('#kategori-filter, #rank-filter,#area-filter, #status-filter, #time-start, #time-end').on('change', function() {
                    table.ajax.reload();
                });

                $('.dataTables-example').on('draw.dt', function () {
                    // Tempatkan inisialisasi Peity di sini
                    $(".pie").peity("pie", {
                        fill: ["#1ab394", "#d7d7d7", "#ffffff"]
                    });

                    $(".pou").peity("pie", {
                        fill: ["#FFC300", "#d7d7d7", "#ffffff"] // Anda bisa gunakan kode warna kuning
                    });

                    $(".pop").peity("pie", {
                        fill: ["#FF2C2C", "#d7d7d7", "#ffffff"] // Anda bisa gunakan kode warna kuning
                    });

                    $(".pops").peity("pie", {
                        fill: ["#FF2C2C", "#FF2C2C", "#ffffff"] // Anda bisa gunakan kode warna kuning
                    });
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

                // datatable genba

                var table_genba =   $('.dataTables-example-genba').DataTable({
                    pageLength: 10,
                    responsive: true,
                    fixedColumns: true, // Aktifkan kolom tetap
                    dom: '<"html5buttons"B>lTfgitp',
                    buttons: [],
                    "processing": true,
                    "serverSide": true,
                    "ajax": {
                        "url":  "{{ config('app.link_website') }}/table",
                        // "url": "http://10.14.143.89/portal-web/public/table",
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
                    {"data": "area"},
                    {"data": "kategori"},
                    {"data": "rank"},
                    {"data": "tanggal_laporan"},
                    {"data": "deadline"},
                    {"data": "progress"},
                    {"data": "action", "orderable": false},
                ],

                "drawCallback": function(settings) {
                    // Menengahkan teks di dalam setiap sel pada tabel
                    $('.dataTables-example-genba').find('td').css('text-align', 'center');
                    $("td").each(function() {
                        convertTextToUppercase(this);
                    });
                }
                });
                $('#kategori-filter, #rank-filter,#area-filter, #status-filter, #time-start, #time-end').on('change', function() {
                    table_genba.ajax.reload();
                });

                $('.dataTables-example-genba').on('draw.dt', function () {
                    // Tempatkan inisialisasi Peity di sini
                    $(".pie").peity("pie", {
                        fill: ["#1ab394", "#d7d7d7", "#ffffff"]
                    });

                    $(".pou").peity("pie", {
                        fill: ["#FFC300", "#d7d7d7", "#ffffff"] // Anda bisa gunakan kode warna kuning
                    });

                    $(".pop").peity("pie", {
                        fill: ["#FF2C2C", "#d7d7d7", "#ffffff"] // Anda bisa gunakan kode warna kuning
                    });

                    $(".pops").peity("pie", {
                        fill: ["#FF2C2C", "#FF2C2C", "#ffffff"] // Anda bisa gunakan kode warna kuning
                    });
                    var order = table_genba.order();
                    // console.log(order);
                    // Dapatkan informasi halaman DataTables
                    if (order && order.length > 0 && order[0][1] === 'desc') {
                        var pageInfo = table_genba.page.info();
                        var start = pageInfo.start;

                        // Perbarui nomor iterasi sesuai dengan urutan baru
                        $('.dataTables-example-genba').DataTable().column(0, { search: 'applied', order: 'applied' }).nodes().each(function (cell, i) {
                            cell.innerHTML = pageInfo.recordsTotal - start - i;
                        });

                    } else if (order && order.length > 0 && order[0][1] === 'asc') {
                        var pageInfo = table_genba.page.info();
                        var start = pageInfo.start;
                        $('.dataTables-example-genba').DataTable().column(0, { search: 'applied', order: 'applied' }).nodes().each(function (cell, i) {
                            cell.innerHTML = start + i + 1;
                        });
                    }
                });



                $('.i-checks').iCheck({
                    checkboxClass: 'icheckbox_square-green',
                    radioClass: 'iradio_square-green',
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
                // calendarWeeks: true,
                autoclose: true,
            });

            var mem = $('#data_2 .input-group.date').datepicker({
                format: 'dd/mm/yyyy', // Format tampilan
                todayBtn: "linked",
                keyboardNavigation: false,
                forceParse: false,
                // calendarWeeks: true,
                autoclose: true,
                endDate:currentDate,
            });

            var mem = $('#data_3 .input-group.date').datepicker({
                format: 'dd/mm/yyyy', // Format tampilan
                todayBtn: "linked",
                keyboardNavigation: false,
                forceParse: false,
                // calendarWeeks: true,
                autoclose: true,
                startDate:currentDate,
            });

                // $('.custom-file-input').on('change', function() {
                //     console.log('ada');
                // let fileName = $(this).val().split('\\').pop();
                // $(this).next('.custom-file-label').addClass("selected").html(fileName);
                // });

                var basic_slider = document.getElementById('basic_slider');
                var sliderValueInput = document.getElementById('sliderValue');
                var defaultSlider = document.getElementById('progress_default');
                noUiSlider.create(basic_slider, {
                    start: defaultSlider.value,
                    behaviour: 'tap',
                    connect: 'lower',
                    range: {
                        'min':  0,
                        'max':  10
                        },
                    step: 2.5,

                    });
                basic_slider.noUiSlider.on('update', function(values, handle) {
                sliderValueInput.value = values[handle];
                var percentage = (values[handle] / 10) * 100;
                if(values[handle] > 10) {
                var percentage = (10 / 10) * 100;
                }
                // validasi slider tidak 0
                if (values[handle] > 0) {
                        $('#submitButton').prop('disabled', false);
                    } else {
                        $('#submitButton').prop('disabled', true);
                    }

                // Tampilkan persentase di bawah slider
                percentageDisplay.innerText = percentage.toFixed(0) + '%';
                });

            });
                $(document).on('change', '.custom-file-input', function() {
                    console.log('ada');
                    let fileName = $(this).val().split('\\').pop();
                    $(this).next('.custom-file-label').addClass("selected").html(fileName);
            });

        var submitForm = document.getElementById('submitForm');
        var submitButton = document.getElementById('submitButton');

        // Tambahkan event listener untuk menangani klik tombol "Submit"
        submitForm.addEventListener('submit', function(event) {
        // Nonaktifkan tombol "Kirim Notifikasi" setelah formulir dikirim
        submitButton.disabled = true;
        });

//             document.addEventListener('DOMContentLoaded', function () {
//     var openCameraButton = document.getElementById('openCameraButton');
//     var fileInput = document.getElementById('logo');
//     var cameraOutput = document.getElementById('cameraOutput');
//     var gambar = false;
//     var video;
//     var stream;

//     openCameraButton.addEventListener('click', function () {
//         if (!gambar) {
//             navigator.mediaDevices.getUserMedia({ video: true })
//                 .then(function (str) {
//                     stream = str;
//                     video = document.createElement('video');
//                     video.srcObject = stream;
//                     video.autoplay = true;

//                     cameraOutput.innerHTML = '';
//                     cameraOutput.appendChild(video);

//                     var takePhotoButton = document.createElement('button');
//                     takePhotoButton.textContent = 'Take Photo';
//                     takePhotoButton.classList.add('btn', 'btn-success', 'centered', 'mt-3');
//                     takePhotoButton.addEventListener('click', takePhoto);
//                     cameraOutput.appendChild(takePhotoButton);
//                 })
//                 .catch(function (err) {
//                     console.error('Error accessing camera: ', err);
//                 });
//         }
//     });

//     function takePhoto() {
//         gambar = true;
//         var canvas = document.createElement('canvas');
//         var context = canvas.getContext('2d');
//         canvas.width = video.videoWidth;
//         canvas.height = video.videoHeight;
//         context.drawImage(video, 0, 0, canvas.width, canvas.height);

//         canvas.toBlob(function (blob) {
//             simpanGambarKeInputFileCustom(blob);
//             var newImage = document.createElement('img');
//             newImage.src = URL.createObjectURL(blob);
//             cameraOutput.innerHTML = '';
//             cameraOutput.appendChild(newImage);

//             var retakePhotoButton = document.createElement('button');
//             retakePhotoButton.textContent = 'Ambil Foto Ulang';
//             retakePhotoButton.classList.add('btn', 'btn-success', 'centered', 'mt-3');
//             retakePhotoButton.addEventListener('click', function () {
//                 gambar = false;
//                 cameraOutput.innerHTML = '';
//                 $('.custom-file-label').addClass("selected").html("choose file...");
//                 $('#myModal5').modal('hide');
//                 // Stop the stream only if it exists
//                 if (stream) {
//                     stream.getTracks().forEach(function (track) {
//                         track.stop();
//                     });
//                 }
//             });
//             cameraOutput.appendChild(retakePhotoButton);
//             if (stream) {
//                 stream.getTracks().forEach(function (track) {
//                     track.stop();
//                 });
//             }
//             var fileName = 'photo.jpg';
//             $('.custom-file-label').addClass("selected").html(fileName);
//             $('#myModal5').modal('hide'); // Hide modal after taking photo
//         }, 'image/jpeg');
//     }

// function simpanGambarKeInputFileCustom(blob) {
// //         // Buat elemen input baru
//         var newInput = document.createElement('input');
//         newInput.type = 'file';
//         newInput.id = 'logo';
//         newInput.name = 'foto_temuan';
//         newInput.className = 'custom-file-input';
//         newInput.required = true;

//         // Buat objek File dari blob gambar
//         var file = new File([blob], 'photo.jpg', { type: 'image/jpeg' });

//         // // Buat FileList baru dan tambahkan objek File ke dalamnya
//         var fileList = new DataTransfer();
//         fileList.items.add(file);

//         // // Atur FileList ke dalam elemen input file
//         newInput.files = fileList.files;

//         // Gantikan elemen input yang lama dengan yang baru
//         var oldInput = document.getElementById('logo');
//         console.log(newInput);
//         oldInput.parentNode.replaceChild(newInput, oldInput);

//     }
// });




        </script>
</body>

</html>
