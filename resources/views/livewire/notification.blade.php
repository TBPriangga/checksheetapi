    <li wire:ignore class="dropdown">
        <a class="dropdown-toggle count-info" data-toggle="dropdown" onclick="refresh()">
            <i class="fa fa-bell"></i>
            @if($count != 0 && $count != null)
                <span class="label label-danger">{{ $count }}</span>
            @endif
        </a>
        <ul class="dropdown-menu dropdown-messages">
            @if($log->isEmpty() || $log == null)
                <li>
                    <div class="dropdown-messages-box row">
                        <div class="col-12">
                            <center><strong>Tidak ada pemberitahuan terbaru</strong></center>
                        </div>
                    </div>
                </li>
            @else
                @foreach($log as $notif)
                    <li class="mb-3">
                        <div class="dropdown-messages-box row">
                            <div class="col-3">
                                <a class="dropdown-item float-left"
                                href="{{ $notif->laporan_log && $notif->laporan_log->genba_id == null
                                            ? route('detailLaporan', ['id' => $notif->laporan_id])
                                            : route('detailTemuan', ['id' => $notif->laporan_log?->id ?? $notif->laporan_id]) }}">
                                    <img alt="image" class="rounded-circle" src="{{ asset('img/info.png') }}">
                                </a>
                            </div>
                            <div class="col-9">
                                <a class="float-left p-0"
                                href="{{ $notif->laporan_log && $notif->laporan_log->genba_id == null
                                            ? route('detailLaporan', ['id' => $notif->laporan_id])
                                            : route('detailTemuan', ['id' => $notif->laporan_log?->id ?? $notif->laporan_id]) }}"
                                style="font-size:12px; color:black">{{ $notif->deskripsi }}</a>
                                <br>
                                <small class="text-muted float-right">
                                    {{ $notif->created_at->diffForHumans() }} - {{ $notif->created_at->format('g:i a - d.m.Y') }}
                                </small>
                            </div>
                        </div>
                    </li>
                @endforeach
            @endif
            <li class="dropdown-divider"></li>
            <li>
                <div class="text-center link-block">
                    <a href="{{ url('activity-logbs') }}" class="dropdown-item">
                        <i class="fa fa-bell"></i> <strong>Lihat Semua Aktifitas</strong>
                    </a>
                </div>
            </li>
        </ul>
    </li>

@push('scripts')
<script src="{{ asset('js/jquery-3.1.1.min.js') }}"></script>
<script>
    function refresh() {
        Livewire.emit('refreshNotification');
    }
</script>
@endpush            
@push('scripts')
<script src={{ asset('js/jquery-3.1.1.min.js') }}></script>

<script>
    function refresh() {
    // Masukkan kode JavaScript Anda di sini
            livewire.emit('refreshNotification');
}
    </script>
@endpush