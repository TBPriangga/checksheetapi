@extends('component.navbar')

@section('content')
@include('component.message')

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>LIST LAPORAN TOTAL TEMUAN</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><strong>List Laporan</strong></li>
        </ol>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <!-- CARD SUMMARY -->
    <div class="row mb-4">
        <div class="col-md-6 col-12">
            <div class="ibox"><div class="ibox-content text-center">
                <h3 class="font-bold mb-2">Total Laporan Temuan</h3>
                <h2 id="totalLaporan" class="text-muted">{{ $totalLaporan }}</h2>
            </div></div>
        </div>
        <div class="col-md-6 col-12">
            <div class="ibox"><div class="ibox-content text-center">
                <h3 class="font-bold mb-2">Total Poin</h3>
                <h2 id="totalPoin" class="text-muted">{{ $totalPoin }}</h2>
            </div></div>
        </div>
    </div>

    <!-- TABEL LAPORAN -->
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-title bg-info">
                    <h5 class="text-white">Tabel Laporan</h5>
                </div>
                <div class="ibox-content">

                    <!-- FILTER & BUTTONS (TANPA FORM) -->
                    <div class="row g-2 align-items-center mb-3">
                        <!-- Area Filter -->
                        <div class="col-sm-2 col-12">
                            <select class="form-control form-control-sm" id="area-filter">
                                <option value="">All Area</option>
                                @foreach ($areas as $area)
                                    <option value="{{ $area->id }}" {{ $area_id == $area->id ? 'selected' : '' }}>
                                        {{ $area->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- NPK Filter -->
                        <div class="col-sm-2 col-12">
                            <input type="text" class="form-control form-control-sm" id="npk-filter"
                                   placeholder="Enter NPK" value="{{ $npk }}">
                        </div>

                        <!-- Filter Button -->
                        <div class="col-sm-2 col-6">
                            <button type="button" class="btn btn-sm btn-primary w-100" id="filter-button">
                                Filter
                            </button>
                        </div>

                        <!-- Reset Button -->
                        <div class="col-sm-2 col-6">
                            <button type="button" class="btn btn-sm btn-secondary w-100" id="reset-filter">
                                Reset
                            </button>
                        </div>

                        <!-- DOWNLOAD PDF (AJAX - TANPA TAB) -->
                        <div class="col-sm-2 col-6">
                            <button type="button" id="download-pdf-btn" class="btn btn-sm btn-success w-100">
                                Filter & Export PDF
                            </button>
                        </div>

                        <!-- Export All (Opsional) -->
                        <div class="col-sm-2 col-6">
                            <a href="{{ route('exportLaporanPdf') }}" class="btn btn-sm btn-danger w-100" download>
                                Export All
                            </a>
                        </div>
                    </div>

                    <!-- TABEL -->
                    <div class="table-responsive">
                        <table id="laporanTable" class="table table-striped table-bordered table-hover dataTables-example w-100">
                            <thead class="text-center">
                                <tr>
                                    <th>No</th>
                                    <th>Tanggal</th>
                                    <th>Nama Penemu</th>
                                    <th>NPK</th>
                                    <th>Area Temuan</th>
                                    <th>Temuan</th>
                                    <th>Potensi Bahaya</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    console.log('ListLaporan JS Loaded');

    // DataTables
    var table = $('#laporanTable').DataTable({
        processing: true,
        serverSide: true,
        autoWidth: false,
        responsive: true,
        dom: '<"top d-flex flex-column align-items-start mb-2"l i>rt<"bottom d-flex justify-content-between align-items-center mt-3"p>',
        ajax: {
            url: '{{ route("laporan.list.index") }}',
            type: 'GET',
            data: function(d) {
                d.area = $('#area-filter').val();
                d.npk = $('#npk-filter').val();
            },
            dataSrc: function(json) {
                $('#totalLaporan').text(json.totalLaporan);
                $('#totalPoin').text(json.totalPoin);
                return json.data;
            }
        },
        columns: [
            { data: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'created_at' },
            { data: 'nama_penemu' },
            { data: 'npk' },
            { data: 'area_name' },
            { data: 'temuan' },
            { data: 'potensi_bahaya' }
        ],
        pageLength: 10,
        lengthMenu: [10, 25, 50, 100],
        language: { processing: "Loading...", emptyTable: "No data available" }
    });

    // Filter Button
    $('#filter-button').on('click', function() {
        table.ajax.reload();
    });

    // Reset Button
    $('#reset-filter').on('click', function() {
        $('#area-filter').val('');
        $('#npk-filter').val('');
        table.ajax.reload();
    });

    // Auto reload on filter change
    $('#area-filter, #npk-filter').on('change', function() {
        table.ajax.reload();
    });

    // DOWNLOAD PDF - TANPA TAB, TANPA RELOAD
    $('#download-pdf-btn').on('click', function () {
        const area = $('#area-filter').val() || '';
        const npk = $('#npk-filter').val() || '';

        let url = '{{ route("exportLaporanPdf") }}';
        const params = new URLSearchParams();
        if (area) params.append('area', area);
        if (npk) params.append('npk', npk);
        if (params.toString()) url += '?' + params.toString();

        const btn = $(this);
        const originalText = btn.html();
        btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Downloading...');

        fetch(url, {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/pdf'
            }
        })
        .then(response => {
            if (!response.ok) {
                return response.text().then(text => { throw new Error(text || 'Gagal download PDF') });
            }
            const disposition = response.headers.get('Content-Disposition') || '';
            let filename = 'Laporan_Temuan.pdf';
            const match = disposition.match(/filename="?([^"]+)"?/);
            if (match) filename = match[1];

            return response.blob().then(blob => ({ blob, filename }));
        })
        .then(({ blob, filename }) => {
            const link = document.createElement('a');
            link.href = URL.createObjectURL(blob);
            link.download = filename;
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
            URL.revokeObjectURL(link.href);
        })
        .catch(error => {
            console.error('Download error:', error);
            alert('Gagal download: ' + error.message);
        })
        .finally(() => {
            btn.prop('disabled', false).html(originalText);
        });
    });
});
</script>
@endpush