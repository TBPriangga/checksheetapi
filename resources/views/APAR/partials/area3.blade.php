{{-- resources/views/APAR/partials/area3.blade.php --}}
<div class="aparmoni-image-container position-relative">
    <img src="{{ asset('Layout-apar-satu.jpg') }}" alt="Peta Area 3" class="aparmoni-map-img w-100">

    @php
        $positions = [
            46 => ['top' => '26.5%', 'left' => '18.3%', 'title' => 'Assembling HPW 1'],
            47 => ['top' => '22.7%', 'left' => '45.1%', 'title' => 'Ruang WHRM A PCB'],
            48 => ['top' => '36.3%', 'left' => '72.6%', 'title' => 'Ruang WHRM A PCB (2)'],
            49 => ['top' => '49.0%', 'left' => '12.4%', 'title' => 'Administrasi Delivery'],
            50 => ['top' => '42.2%', 'left' => '38.5%', 'title' => 'Preparation SP Delivery'],
            51 => ['top' => '55.9%', 'left' => '61.2%', 'title' => 'Finish Good Delivery (1)'],
            52 => ['top' => '69.0%', 'left' => '25.8%', 'title' => 'Finish Good Delivery (2)'],
            53 => ['top' => '82.3%', 'left' => '48.7%', 'title' => 'Finish Good Delivery (3)'],
            54 => ['top' => '29.1%', 'left' => '88.4%', 'title' => 'Incoming QC'],
            55 => ['top' => '62.7%', 'left' => '82.0%', 'title' => 'Pos Security Gd. Baru'],
            56 => ['top' => '47.5%', 'left' => '55.9%', 'title' => 'Gate 1 Gd. Baru'],
            57 => ['top' => '76.1%', 'left' => '15.6%', 'title' => 'Gate 2 Gd. Baru'],
            58 => ['top' => '89.8%', 'left' => '72.3%', 'title' => 'Gate 4 Gd. Baru'],
            59 => ['top' => '33.4%', 'left' => '31.7%', 'title' => 'Gate 3 Gd. Baru'],
            60 => ['top' => '66.6%', 'left' => '42.1%', 'title' => 'Area Winker'],
            61 => ['top' => '43.8%', 'left' => '79.2%', 'title' => 'Pos Utama Security'],
            62 => ['top' => '80.4%', 'left' => '33.9%', 'title' => 'Ruang Dojo'],
            63 => ['top' => '24.2%', 'left' => '62.5%', 'title' => 'Depan Panel Room Trafo (APAB)'],
            64 => ['top' => '58.1%', 'left' => '19.8%', 'title' => 'Depan Ruang Kompresor'],
            65 => ['top' => '72.7%', 'left' => '68.4%', 'title' => 'Depan Ruang Hydrant'],
            66 => ['top' => '37.9%', 'left' => '51.3%', 'title' => 'Depan Ruang Genset'],
            67 => ['top' => '85.2%', 'left' => '58.6%', 'title' => 'Depan Pencucian Jig'],
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

            // WARNA TOMBOL
            $colorClass = match($status) {
                'inspected', 'inspected_expired' => 'bg-success text-white',
                'need_attention'                 => 'bg-warning text-dark',
                'need_inspection'                => 'bg-danger text-white',
                default                          => 'bg-secondary text-white',
            };

            // BADGE TEXT
            $badge = match($status) {
                'inspected'              => 'OK',
                'inspected_expired'      => 'EXPIRED',
                'need_attention'         => 'NG',
                'need_inspection'        => 'BELUM DICEK',
                default                  => 'UNKNOWN',
            };

            // DOT MERAH: need_inspection, need_attention, inspected_expired
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
               z-index: 10;"
           data-bs-toggle="tooltip"
           data-bs-placement="top"
           title="{{ $pos['title'] }} - {{ $badge }} - {{ $apar->kode_apar ?? 'N/A' }}">
            {{ $nomor }}
        </a>

        <!-- DOT MERAH: pojok kanan atas, lebih ke atas -->
        @if($showPulse)
            <span class="status-pulse position-absolute"
                  style="
                      top: {{ $pos['top'] }};
                      left: {{ $pos['left'] }};
                      transform: translate(60%, -110%);
                      z-index: 11;"
                  data-bs-toggle="tooltip"
                  title="{{ $status === 'inspected_expired' ? 'EXPIRED!' : ($status === 'need_attention' ? 'ADA NG!' : 'BELUM DICEK!') }}">
            </span>
        @endif
    @endforeach
</div>