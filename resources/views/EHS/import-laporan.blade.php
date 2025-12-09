@extends('component.navbar')

@section('content')
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-title">
                    <h5>Import Patrol & Temuan dari Excel </h5>
                </div>
                <div class="ibox-content">
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    <p class="text-muted mt-2">Upload file Excel dari Google Form. Kolom diharapkan: Tanggal (Excel serial date atau DD-MM-YYYY), Area (nama area), Nama Penemu, NPK, Temuan, Potensi Bahaya (opsional), Kategori (5R/A/B/C/D/E/F/G/O), Rank (A/B/C), Saran Perbaikan (opsional), URL Foto Temuan (opsional, link Google Drive publik).</p>

                    <form action="{{ route('laporan.import.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label>Pilih File Excel</label>
                            <input type="file" name="excel_file" class="form-control" accept=".xlsx,.xls" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Upload & Preview</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @if ($previewData->isNotEmpty())
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-title">
                    <h5>Preview Data</h5>
                </div>
                <div class="ibox-content">
                    <table class="table table-bordered dataTables-example">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Area</th>
                                <th>Nama Penemu</th>
                                <th>NPK</th>
                                <th>Temuan</th>
                                <th>Risiko Bahaya</th>
                                <th>Kategori</th>
                                <th>Rank</th>
                                <th>Saran Perbaikan</th>
                                <th>URL Foto Temuan</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($previewData as $index => $item)
                                <tr>
                                    <td>{{ $item['tanggal'] }}</td>
                                    <td>{{ $item['area'] }}</td>
                                    <td>{{ $item['nama_penemu'] }}</td>
                                    <td>{{ $item['npk'] }}</td>
                                    <td>{{ $item['temuan'] }}</td>
                                    <td>{{ $item['potensi_bahaya'] ?? 'N/A' }}</td>
                                    <td>{{ $item['kategori'] }}</td>
                                    <td>{{ $item['rank'] }}</td>
                                    <td>{{ $item['saran_perbaikan'] ?? 'N/A' }}</td>
                                    <td>
                                        @if(!empty($item['url_foto_temuan']) && preg_match('/drive\.google\.com\/(?:file\/d\/|open\?id=)(.+?)(?:\/view|$)/', $item['url_foto_temuan'], $matches))
                                            <br>
                                            <a href="{{ $item['url_foto_temuan'] }}" target="_blank" class="btn btn-info btn-sm mt-2">Lihat di Google Drive</a>
                                        @elseif(!empty($item['url_foto_temuan']))
                                            <a href="{{ $item['url_foto_temuan'] }}" target="_blank">Lihat Gambar</a>
                                            <br>
                                            <small class="text-warning">Link tidak valid untuk thumbnail</small>
                                        @else
                                            Tidak ada gambar
                                        @endif
                                        <small class="text-warning">Pastikan link Google Drive publik ("Anyone with the link").</small>
                                    </td>
                                    <td>
                                        <a href="{{ route('laporan.import.cancel', ['index' => $index]) }}" class="action-icon text-danger" title="Cancel">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <a href="{{ route('laporan.import.save') }}" class="btn btn-success">Simpan Semua</a>
                </div>
            </div>
        </div>
    </div>
    @else
    <div class="row">
        <div class="col-lg-12">
            <div class="alert alert-info">
                Tidak ada data untuk ditampilkan di preview. Silakan upload file Excel terlebih dahulu.
            </div>
        </div>
    </div>
    @endif
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        if (document.querySelector('.dataTables-example')) {
            $('.dataTables-example').DataTable({
                pageLength: 10,
                lengthChange: true,
                lengthMenu: [10, 25, 50, 100],
                responsive: true,
                dom: '<"html5buttons"B>lTfgitp',
                buttons: [],
                columnDefs: [
                    { responsivePriority: 1, targets: [0, 2, 5, -1] },
                    { responsivePriority: 2, targets: [3, 4] }
                ],
                language: {
                    lengthMenu: "Show _MENU_ entries",
                    info: "Showing _START_ to _END_ of _TOTAL_ entries",
                    search: "Search:",
                    paginate: {
                        first: "First",
                        last: "Last",
                        next: "Next",
                        previous: "Previous"
                    }
                }
            });
        } else {
            console.log('Tabel dengan class dataTables-example tidak ditemukan.');
        }
    });
</script>
<style>
    .action-icon {
        margin: 0 5px;
        font-size: 18px;
        text-decoration: none;
        color: #dc3545;
    }
    .action-icon:hover {
        opacity: 0.7;
        color: #c82333;
    }
    @media (max-width: 768px) {
        .table-responsive {
            overflow-x: auto;
        }
        .dataTables_wrapper .dataTables_length,
        .dataTables_wrapper .dataTables_filter {
            text-align: left;
            margin-bottom: 10px;
        }
    }
</style>
@endpush
@endsection