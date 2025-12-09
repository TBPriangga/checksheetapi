@extends('component.navbar')
@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <!-- RIWAYAT PEMERIKSAAN - FULL WIDTH -->
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        RIWAYAT PEMERIKSAAN - {{ $apar->kode_apar }}
                        <small class="text-muted">({{ $apar->lokasi_apar }})</small>
                    </h5>
                </div>
                <div class="card-body">
                    <!-- FILTER -->
                    <div class="row g-2 mb-3 align-items-center">
                        <div class="col-sm-4">
                            <div class="btn-group btn-group-toggle w-100" data-toggle="buttons">
                                <label class="btn btn-outline-primary btn-sm active">
                                    <input type="radio" name="periode" value="1" checked> DAY
                                </label>
                                <label class="btn btn-outline-primary btn-sm">
                                    <input type="radio" name="periode" value="2"> MONTH
                                </label>
                                <label class="btn btn-outline-primary btn-sm">
                                    <input type="radio" name="periode" value="3"> YEARS
                                </label>
                            </div>
                        </div>
                        <div class="col-sm-5">
                            <div class="input-group input-group-sm">
                                <span class="input-group-text">FROM</span>
                                <input type="text" class="form-control datepicker" id="date-start">
                                <span class="input-group-text">TO</span>
                                <input type="text" class="form-control datepicker" id="date-end">
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <button class="btn btn-success btn-sm w-100">EXPORT</button>
                        </div>
                    </div>

                    <!-- TABEL RIWAYAT -->
                    <div class="table-responsive">
                        <table class="table table-sm table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th width="15%">Tanggal</th>
                                    <th width="20%">Checker</th>
                                    <th width="10%">Status</th>
                                    <th>Catatan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($history as $check)
                                <tr>
                                    <td>{{ $check->tanggal_pemeriksaan->format('d/m/Y') }}</td>
                                    <td>{{ $check->checker }}</td>
                                    <td>
                                        <div class="d-flex gap-1 align-items-center">
                                            <span class="badge bg-{{ $check->main_status_color }} fs-6">
                                                {{ $check->main_status_label }}
                                            </span>
                                            @if($check->is_near_expired)
                                                <span class="badge bg-danger text-dark fs-7">AKAN KADALUARSA</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        @if($check->catatan_lainnya)
                                            {{ Str::limit($check->catatan_lainnya, 80) }}
                                        @else
                                            <em class="text-muted">Tidak ada catatan</em>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted py-4">
                                        Belum ada riwayat pemeriksaan.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>

                        <!-- Pagination -->
                        <div class="mt-3">
                            {{ $history->appends(request()->query())->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection