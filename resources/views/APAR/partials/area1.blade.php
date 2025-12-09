{{-- resources/views/APAR/partials/area1.blade.php --}}
<div class="aparmoni-image-container position-relative">
    <img src="{{ asset('Layout-apar-satu.jpg') }}" alt="Peta Area 1" class="aparmoni-map-img w-100">

    @php
        $positions = [
            1 => ['top' => '24.5%', 'left' => '18.3%', 'title' => 'Office Lt 1 (Tenis Meja)'],
            2 => ['top' => '20.7%', 'left' => '45.1%', 'title' => 'Office Lt 1 (Pantry)'],
            3 => ['top' => '34.3%', 'left' => '72.6%', 'title' => 'Office Lt 2 (Toilet)'],
            4 => ['top' => '47.0%', 'left' => '12.4%', 'title' => 'Office Lt 2 (Kemuning)'],
            5 => ['top' => '40.2%', 'left' => '38.5%', 'title' => 'Office Lt 3 (Toilet)'],
            6 => ['top' => '53.9%', 'left' => '61.2%', 'title' => 'Office Lt 3 (Ruang ATK)'],
            7 => ['top' => '67.0%', 'left' => '25.8%', 'title' => 'Loading Dock Mold'],
            8 => ['top' => '80.3%', 'left' => '48.7%', 'title' => 'Belakang MC. Inj BMC'],
            9 => ['top' => '27.1%', 'left' => '88.4%', 'title' => 'Belakang MC. Inj 6'],
            10 => ['top' => '60.7%', 'left' => '82.0%', 'title' => 'Belakang MC. Inj 4'],
            11 => ['top' => '45.5%', 'left' => '55.9%', 'title' => 'Belakang Area Molding'],
            12 => ['top' => '74.1%', 'left' => '15.6%', 'title' => 'Belakang MC. Inj 8'],
            13 => ['top' => '87.8%', 'left' => '72.3%', 'title' => 'Depan MC. Inj 11'],
            14 => ['top' => '31.4%', 'left' => '31.7%', 'title' => 'Depan MC. Inj 12'],
            15 => ['top' => '64.6%', 'left' => '42.1%', 'title' => 'Depan MC. Inj 13'],
            16 => ['top' => '41.8%', 'left' => '79.2%', 'title' => 'Belakang MC. Inj 11'],
            17 => ['top' => '78.4%', 'left' => '33.9%', 'title' => 'Depan VM 2 1 (Luar)'],
            18 => ['top' => '22.2%', 'left' => '62.5%', 'title' => 'Oase Injection'],
            19 => ['top' => '56.1%', 'left' => '19.8%', 'title' => 'Depan VM 2 2 (Luar)'],
            20 => ['top' => '70.7%', 'left' => '68.4%', 'title' => 'Samping VM 1 (APAB)'],
            21 => ['top' => '35.9%', 'left' => '51.3%', 'title' => 'Depan VM 1 Luar'],
            22 => ['top' => '83.2%', 'left' => '58.6%', 'title' => 'Depan PCB (APAB)'],
            23 => ['top' => '49.8%', 'left' => '28.1%', 'title' => 'Depan Workshop'],
        ];
    @endphp

    @foreach($apars as $apar)
        @if(!$apar->nomor || !isset($positions[$apar->nomor]))
            @continue
        @endif

        @php
            $nomor = $apar->nomor;
            $pos = $positions[$nomor];
            $status = $apar->computed_status ?? 'need_inspection';

            $colorClass = match($status) {
                'inspected', 'inspected_expired' => 'bg-success text-white',
                'need_attention'                 => 'bg-warning text-dark',
                'need_inspection'                => 'bg-danger text-white',
                default                          => 'bg-secondary text-white',
            };

            $badge = match($status) {
                'inspected'              => 'OK',
                'inspected_expired'      => 'EXPIRED',
                'need_attention'         => 'NG',
                'need_inspection'        => 'BELUM DICEK',
                default                  => 'UNKNOWN',
            };

            $showPulse = in_array($status, ['need_inspection', 'need_attention', 'inspected_expired']);
        @endphp

        <!-- TOMBOL NOMOR APAR -->
        <a href="{{ route('inspeksi-apar.show', $apar->id) }}"
        class="aparmoni-visit-btn {{ $colorClass }} position-absolute rounded-circle d-flex align-items-center justify-content-center text-decoration-none"
        style="
            top: {{ $pos['top'] }};
            left: {{ $pos['left'] }};
            transform: translate(-50%, -50%);
            width: 40px;
            height: 40px;
            font-size: 10px;
            z-index: 10;
        "
        data-bs-toggle="tooltip"
        data-bs-placement="top"
        title="{{ $pos['title'] }} - {{ $badge }} - {{ $apar->kode_apar }}">
            {{ $nomor }}
        </a>

        <!-- DOT MERAH: pojok kanan atas -->
        @if($showPulse)
            <span class="status-pulse position-absolute"
                style="
                    top: {{ $pos['top'] }};
                    left: {{ $pos['left'] }};
                    transform: translate(60%, -110%);
                    z-index: 11;
                "
                data-bs-toggle="tooltip"
                title="{{ $status === 'inspected_expired' ? 'EXPIRED!' : ($status === 'need_attention' ? 'ADA NG!' : 'BELUM DICEK!') }}">
            </span>
        @endif
    @endforeach
</div>