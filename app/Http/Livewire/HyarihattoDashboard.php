@extends('component.navbar')

@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Hyarihatto Dashboard</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item active">
                <strong>Dashboard Point</strong>
            </li>
        </ol>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-12">
            <div class="ibox">
                <div class="ibox-title">
                    <h5>Unsafe Condition Reports (With NPK & Name)</h5>
                    <button id="exportScreenshot" class="btn btn-success btn-sm float-end">Export as Image</button>
                </div>
                <div class="ibox-content">
                    <div class="row mt-4">
                        <div class="col-md-6">
                            <canvas id="reportsChart" style="width: 100%; height: 400px;"></canvas>
                        </div>
                        <div class="col-md-6">
                            <div class="ibox">
                                <div class="ibox-title">
                                    <h5>Total Reports</h5>
                                </div>
                                <div class="ibox-content text-center">
                                    <h1>{{ $totalReports }}</h1>
                                </div>
                            </div>
                            <div class="ibox">
                                <div class="ibox-title">
                                    <h5>Top 5 Reporters</h5>
                                </div>
                                <div class="ibox-content">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Employee</th>
                                                <th>Reports</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($topReporters as $reporter)
                                                <tr>
                                                    <td>{{ $reporter['nama_penemu'] }}</td>
                                                    <td>{{ $reporter['jumlah_temuan'] }}</td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="2" class="text-center">No data available</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        console.log('DOM loaded, checking canvas:', document.getElementById('reportsChart'));
        const ctx = document.getElementById('reportsChart')?.getContext('2d');
        if (ctx) {
            try {
                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: @json($labels),
                        datasets: [
                            {
                                label: 'Open',
                                data: @json($openData),
                                backgroundColor: 'rgba(255, 99, 132, 0.6)', // Merah
                                borderColor: 'rgba(255, 99, 132, 1)',
                                borderWidth: 1
                            },
                            {
                                label: 'Closed',
                                data: @json($closedData),
                                backgroundColor: 'rgba(75, 192, 192, 0.6)', // Teal
                                borderColor: 'rgba(75, 192, 192, 1)',
                                borderWidth: 1
                            },
                            {
                                label: 'Total Findings',
                                data: @json($totalData),
                                backgroundColor: 'rgba(54, 162, 235, 0.6)', // Biru
                                borderColor: 'rgba(54, 162, 235, 1)',
                                borderWidth: 1
                            }
                        ]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        },
                        plugins: {
                            legend: {
                                display: true
                            }
                        }
                    }
                });
                console.log('Chart initialized successfully with controller data');
            } catch (error) {
                console.error('Chart initialization failed:', error);
            }
        } else {
            console.error('Canvas element not found');
        }

        // Ekspor gambar
        document.getElementById('exportScreenshot').addEventListener('click', function() {
            const element = document.querySelector('.wrapper-content');
            html2canvas(element).then(canvas => {
                const link = document.createElement('a');
                link.download = 'Hyarihatto_Dashboard_' + new Date().toISOString().slice(0, 10) + '.png';
                link.href = canvas.toDataURL('image/png');
                link.click();
            }).catch(error => console.error('Export failed:', error));
        });
    });
</script>
@endpush
@endsection