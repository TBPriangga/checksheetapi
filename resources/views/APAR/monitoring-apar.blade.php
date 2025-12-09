{{-- resources/views/APAR/monitoring-apar.blade.php --}}
@extends('component.navbar')

@section('content')
<div class="aparmoni-container">

    <!-- Header -->
    <div class="simple-section mb-4">
        <h3 class="aparmoni-title">FIRE EXTINGUISHER INSPECTION REPORT</h3>
    </div>

    {{-- Filter Section --}}
    <div class="simple-section mb-4">
        <div class="ibox"><div class="ibox-content">
            <div class="row align-items-center g-3">
                <div class="col-sm-4 col-md-3">
                    <div class="btn-group btn-group-toggle w-100" data-toggle="buttons">
                        <label class="btn btn-outline-primary btn-sm active"><input type="radio" name="periode" value="1" checked> DAY</label>
                        <label class="btn btn-outline-primary btn-sm"><input type="radio" name="periode" value="2"> MONTH</label>
                        <label class="btn btn-outline-primary btn-sm"><input type="radio" name="periode" value="3"> YEARS</label>
                    </div>
                </div>
                <div class="col-sm-5 col-md-6">
                    <div class="input-daterange input-group">
                        <span class="input-group-addon">FROM</span>
                        <input type="text" class="form-control aparmoni-date" id="date-start">
                        <span class="input-group-addon">TO</span>
                        <input type="text" class="form-control aparmoni-date" id="date-end">
                    </div>
                </div>
                <div class="col-sm-3 col-md-3">
                    <button class="btn btn-primary w-100 aparmoni-btn" id="export-btn">EXPORT LAPORAN</button>
                </div>
            </div>
        </div></div>
    </div>

    {{-- Area Selector + Status Cards --}}
    <div class="simple-section mb-4">
        <div class="ibox"><div class="ibox-content">
            <div class="row g-3">
                <div class="col-lg-4 col-md-5">
                    <label class="form-label fw-bold mb-2">Pilih Area</label>
                    <select class="form-select aparmoni-select" id="area-selector">
                        <option value="1" selected>Area 1</option>
                        <option value="2">Area 2</option>
                        <option value="3">Area 3</option>
                        <option value="4">Area 4</option>
                    </select>
                </div>
                <div class="col-lg-8 col-md-7">
                    <label class="form-label fw-bold mb-0">FIRE EXTINGUISHERS STATUS</label>
                    <div class="row g-3 mt-2">
                        <div class="col-4"><div class="aparmoni-card">
                            <div class="aparmoni-number text-successs">{{ $inspected }}</div>
                            <div class="aparmoni-label">Inspected</div>
                            <small class="text-muted">Sudah dicek, semua OK</small>
                        </div></div>

                        <div class="col-4"><div class="aparmoni-card">
                            <div class="aparmoni-number text-warning">{{ $needAttention }}</div>
                            <div class="aparmoni-label">Need Attention</div>
                            <small class="text-muted">Ada item NG</small>
                        </div></div>

                        <div class="col-4"><div class="aparmoni-card">
                            <div class="aparmoni-number text-danger">{{ $needInspection }}</div>
                            <div class="aparmoni-label">Need Inspection</div>
                            <small class="text-muted">Belum pernah dicek</small>
                        </div></div>
                    </div>
                </div>
            </div>
        </div></div>
    </div>

    {{-- Map + Pie Chart --}}
    <div class="simple-section">
        <div class="row g-3">
            <div class="col-lg-8">
                <div id="map-container" class="border rounded p-3 bg-light">
                    @include('APAR.partials.area1', ['apars' => $apars])
                </div>
            </div>
            <div class="col-lg-4 d-flex align-items-center justify-content-center">
                <canvas id="pieChart" class="aparmoni-pie"></canvas>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('css/aparStyle.css') }}">
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const container = document.getElementById('map-container');

    // Init tooltips & events
    function initMap() {
        container.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(el => {
            new bootstrap.Tooltip(el);
        });

        container.querySelectorAll('.aparmoni-visit-btn').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                const href = this.getAttribute('href');
                if (href && href !== '#') window.location.href = href;
            });
        });
    }

    // Initial load
    initMap();

    // Area change
    document.getElementById('area-selector').addEventListener('change', function () {
        const area = this.value;
        container.innerHTML = '<div class="text-center p-5"><div class="spinner-border"></div></div>';

        fetch(`/inspeksi-apar/partial/${area}`)
            .then(r => r.ok ? r.text() : Promise.reject())
            .then(html => {
                container.innerHTML = html;
                initMap();
            })
            .catch(() => {
                container.innerHTML = '<div class="alert alert-danger">Gagal memuat area.</div>';
            });
    });

    // TOTAL APAR
    const totalApar = {{ $inspected + $needAttention + $needInspection }};

    // Pie Chart dengan CENTER LABEL
    const ctx = document.getElementById('pieChart').getContext('2d');
    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['Inspected', 'Need Attention', 'Need Inspection'],
            datasets: [{
                data: [{{ $inspected }}, {{ $needAttention }}, {{ $needInspection }}],
                backgroundColor: ['#28a745', '#ffc107', '#dc3545'],
                borderWidth: 0,
                weight: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { position: 'bottom' },
                tooltip: { enabled: true }
            },
            cutout: '70%',
            animation: {
                onComplete: function() {
                    const chart = this;
                    const ctx = chart.ctx;
                    ctx.font = 'bold 28px Arial';
                    ctx.fillStyle = '#333';
                    ctx.textAlign = 'center';
                    ctx.textBaseline = 'middle';

                    const centerX = (chart.chartArea.left + chart.chartArea.right) / 2;
                    const centerY = (chart.chartArea.top + chart.chartArea.bottom) / 2;

                    // TOTAL
                    ctx.fillText(totalApar, centerX, centerY - 10);

                    // LABEL KECIL
                    ctx.font = '12px Arial';
                    ctx.fillStyle = '#666';
                    ctx.fillText('TOTAL APAR', centerX, centerY + 15);
                }
            }
        }
    });
});
</script>
@endpush