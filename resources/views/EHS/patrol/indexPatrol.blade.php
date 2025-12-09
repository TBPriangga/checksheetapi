@extends('component.navbar')

@section('content')

@include('component.message')  
{{-- yield  content--}}
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>EHS Patrol</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <strong>Table EHS Patrol</strong>
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
                    <h5>Laporan EHS Patrol</h5>
                </div>
                <div class="ibox-content">

                    <div class="row" style="margin-left:0">
                
                        <div class="col-sm-2 m-b-xs"><select class="form-control-sm form-control input-s-sm inline" id="area-filter" name="area">
                            <option value="">All Area</option>
                            @foreach($areas as $area)
                            <option value="{{ $area->id }}">{{ $area->name }}</option>
                            @endforeach
                        </select>
                        </div>

                        <div class="col-sm-4 m-b-xs form-group " id="data_5">
                            <div class="input-daterange input-group" id="datepicker">
                                <span class="input-group-addon">From</span>
                                <input type="text" class="form-control-sm form-control" id="time-start" name="timeStart" value="01/01/2020"/>
                                <span class="input-group-addon">to</span>
                                <input type="text" class="form-control-sm form-control" id="time-end" name="timeEnd" value="{{ date('d/m/Y', strtotime('+1 month')) }}" />
                            </div>
                        </div>
                        
                        <div class="col-lg-3">

                        </div>
                        @if(auth()->user()->roles[0]->name == "EHS")
                        <div class="col-lg-3 m-3 m-sm-0">
                            <a class="btn btn-block btn-primary compose-mail" href="{{route('createPatrol')}}">Buat Laporan Patrol</a>
                        </div>
                        @endif
                    </div>
                          
                                {{-- start table 1 --}}
                    <div class="table-responsive mt-3">
                        <table class="table table-striped table-bordered table-hover dataTables-example-patrol" width="100%">
                            <thead>
                            <tr>
                                <th class="col-1" data-priority="1">No</th>
                                <th class="text-center" data-priority="2">Area</th>
                                <th class="text-center" data-priority="3">Tanggal Patrol</th>
                                <th class="text-center none" >Open</th>
                                <th class="text-center none" >Approval 1 (Dept Head PIC)</th>
                                <th class="text-center none" >Approval 2 (EHS)</th>
                                <th class="text-center none" >Approval 3 (Dept Head EHS)</th>
                                <th class="text-center none" >CLOSED</th>
                                <th class="text-center" data-priority="4">Action</th>
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
            var table =   $('.dataTables-example-patrol').DataTable({
                    pageLength: 10,
                    responsive: true,
                    columnDefs: [
                        { responsivePriority: 1, targets: 1 },
                        { responsivePriority: 2, targets: 0 },
                        { responsivePriority: 3, targets: 2 },
                        { responsivePriority: 4, targets: 7 },
                        { responsivePriority: 5, targets: 3 },
                        { responsivePriority: 6, targets: 4 },
                        { responsivePriority: 7, targets: 5 },
                        { responsivePriority: 8, targets: 6 },
                        { responsivePriority: 9, targets: 8 },
                    ],
                    dom: '<"html5buttons"B>lTfgitp',
                    buttons: [],
                    "processing": true,
                    "serverSide": true,
                    "ajax": {
                        "url": "{{ config('app.link_website') }}/patrolEHS",
                        // "url": "http://10.14.143.89/portal-web/public/patrolEHS",
                        "type": "GET", // Menentukan metode HTTP yang digunakan
                        "data": function (d) {
                            // Kirim parameter tambahan ke server
                            d.start = d.start || 0; // Mulai dari indeks 0 jika tidak didefinisikan
                            d.length = d.length || 10; // Panjang halaman 10 jika tidak didefinisikan
                            d._token = "{{ csrf_token() }}";
                            d.area = $('#area-filter').val();
                            d.timeStart = $('#time-start').val();
                            d.timeEnd = $('#time-end').val();
                            return d;
                        }
                    },
                    "columns": [
                    {"data": "iteration"},
                    {"data": "area", "orderable": false},
                    {"data": "tanggal", "orderable": false},
                    {"data": "open", "orderable": false},
                    {"data": "closed", "orderable": false},
                    {"data": "verified", "orderable": false},
                    {"data": "approve", "orderable": false},
                    {"data": "clear", "orderable": false},
                    {"data": "action", "orderable": false},
                ],
                
                "drawCallback": function(settings) {
                    // Menengahkan teks di dalam setiap sel pada tabel
                    $('.dataTables-example-patrol').find('td').css('text-align', 'center');
                }
                });
                $('#time-start, #time-end,#area-filter').on('change', function() {
                    table.ajax.reload();
                });
                
                $('.dataTables-example-patrol').on('draw.dt', function () {
                    // Tempatkan inisialisasi Peity di sinile.order();
                    var order = table.order();
                    // console.log(order);
                    // Dapatkan informasi halaman DataTables
                    if (order && order.length > 0 && order[0][1] === 'desc') {
                        var pageInfo = table.page.info();
                        var start = pageInfo.start;

                        // Perbarui nomor iterasi sesuai dengan urutan baru
                        $('.dataTables-example-patrol').DataTable().column(0, { search: 'applied', order: 'applied' }).nodes().each(function (cell, i) {
                            cell.innerHTML = pageInfo.recordsTotal - start - i;
                        });
                    } else if (order && order.length > 0 && order[0][1] === 'asc') {
                        var pageInfo = table.page.info();
                        var start = pageInfo.start;
                        $('.dataTables-example-patrol').DataTable().column(0, { search: 'applied', order: 'applied' }).nodes().each(function (cell, i) {
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
@endsection