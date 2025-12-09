@extends('component.navbar')

@section('content')

@include('component.message')  
{{-- yield  content--}}
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Management Patrol</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="index.html">Management Patrol</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>Schedule</strong>
            </li>
        </ol>
    </div>
    <div class="col-lg-2">

    </div>
</div>


{{-- div content  --}}

    {{-- start dashboard  --}}

{{-- end dashboard  --}}

{{-- start table  --}}

<div class="wrapper wrapper-content animated fadeInRight">
    
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title bg-info">
                    <h5>Schedule</h5>
                </div>
                <div class="ibox-content">

                    <div class="row" style="margin-left:0">
                        <div class="col-sm-4 m-b-xs form-group " id="data_5">
                            <div class="input-daterange input-group" id="datepicker">
                                <span class="input-group-addon">From</span>
                                <input type="text" class="form-control-sm form-control" id="time-start" name="timeStart" value="01/01/2020"/>
                                <span class="input-group-addon">to</span>
                                <input type="text" class="form-control-sm form-control" id="time-end" name="timeEnd" value="{{  now()->addWeeks(2)->format('d/m/Y') }}" />
                            </div>
                        </div>
                        
                        <div class="col-lg-5">

                        </div>
                        @if(auth()->user()->roles[0]->name == "EHS")
                        <div class="col-lg-3 m-3 m-sm-0">
                            <a class="btn btn-block btn-primary compose-mail" href="/genba/schedule/create">Buat Jadwal Patrol</a>
                        </div>
                        @endif
                    </div>
                          
                                {{-- start table 1 --}}
                    <div class="table-responsive mt-3">
                        <table class="table table-striped table-bordered table-hover dataTables-example-schedule">
                            <thead>
                            <tr>
                                <th class="text-center">No</th>
                                <th class="text-center">Nama Team</th>
                                <th class="text-center">Area</th>
                                <th class="text-center">Tanggal Patrol</th>
                                <th class="text-center">Action</th>
                            </tr>
                            </thead>
                            
                            <tfoot>
                                    
                            </tfoot>
                        </table>
                    </div>
                    {{-- end table 1 --}}
          
                </div>
                {{-- end ibox-content --}}
            </div>
        </div>

    </div>
</div>
{{-- end table  --}}

{{-- end div content  --}}

{{-- end yield content --}}
@endsection

@section('scripts')
<script src={{ asset('js/jquery-3.1.1.min.js') }}></script>
    <script src={{ asset('js/popper.min.js') }}></script>
<script src={{ asset('js/plugins/select2/select2.full.min.js') }}></script>
<script src={{ asset('js/plugins/dataTables/datatables.min.js') }}></script>
<script src={{ asset('js/plugins/dataTables/dataTables.bootstrap4.min.js') }}></script>
<script>
    $(document).ready(function () {
            var table =   $('.dataTables-example-schedule').DataTable({
                    pageLength: 10,
                    responsive: true,
                    columnDefs: [
                        { responsivePriority: 1, targets: 0 }, // Prioritas responsif untuk kolom pertama (No)
                        { responsivePriority: 2, targets: -1 }, // Prioritas responsif untuk kolom Nama Team, Area, dan Tanggal Patrol
                         // Prioritas responsif untuk kolom Action
                    ],
                    dom: '<"html5buttons"B>lTfgitp',
                    buttons: [],
                    "processing": true,
                    "serverSide": true,
                    "ajax": {
                        "url": "{{ config('app.link_website') }}/genba/schedule",
                        // "url": "http://172.0.0.1:8000/genba/schedule",
                        // "url": "http://10.14.143.89/portal-web/public/genba/schedule",
                        "type": "GET", // Menentukan metode HTTP yang digunakan
                        "data": function (d) {
                            // Kirim parameter tambahan ke server
                            d.start = d.start || 0; // Mulai dari indeks 0 jika tidak didefinisikan
                            d.length = d.length || 10; // Panjang halaman 10 jika tidak didefinisikan
                            d._token = "{{ csrf_token() }}";
                            d.timeStart = $('#time-start').val();
                            d.timeEnd = $('#time-end').val();
                            return d;
                        }
                    },
                    "columns": [
                    {"data": "iteration"},
                    {"data": "team", "orderable": false},
                    {"data": "area", "orderable": false},
                    {"data": "tanggal", "orderable": false},
                    {"data": "action", "orderable": false},
                ],
                
                "drawCallback": function(settings) {
                    // Menengahkan teks di dalam setiap sel pada tabel
                    $('.dataTables-example-schedule').find('td').css('text-align', 'center');
                }
                });
                $('#time-start, #time-end').on('change', function() {
                    table.ajax.reload();
                });
                
                $('.dataTables-example-schedule').on('draw.dt', function () {
                    // Tempatkan inisialisasi Peity di sinile.order();
                    var order = table.order();
                    // console.log(order);
                    // Dapatkan informasi halaman DataTables
                    if (order && order.length > 0 && order[0][1] === 'desc') {
                        var pageInfo = table.page.info();
                        var start = pageInfo.start;

                        // Perbarui nomor iterasi sesuai dengan urutan baru
                        $('.dataTables-example-schedule').DataTable().column(0, { search: 'applied', order: 'applied' }).nodes().each(function (cell, i) {
                            cell.innerHTML = pageInfo.recordsTotal - start - i;
                        });
                    } else if (order && order.length > 0 && order[0][1] === 'asc') {
                        var pageInfo = table.page.info();
                        var start = pageInfo.start;
                        $('.dataTables-example-schedule').DataTable().column(0, { search: 'applied', order: 'applied' }).nodes().each(function (cell, i) {
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



        // $(document).ready(function(){
        //     $('.dataTables-example-schedule').DataTable({
        //         pageLength: 25,
        //         responsive: true,
        //         dom: '<"html5buttons"B>lTfgitp',
        //         buttons: [ ],
        //     });
    // });

            
</script>
@endsection