{{-- resources/views/APAR/partials/area2.blade.php --}}
<div class="aparmoni-image-container position-relative">
    <img src="{{ asset('Layout-apar-dua.jpg') }}" alt="Peta Area 2" class="aparmoni-map-img w-100">

    @php
        $positions = [
            24 => ['top' => '26.5%', 'left' => '18.3%', 'title' => 'Office Produksi (Kiri)'],
            25 => ['top' => '22.7%', 'left' => '45.1%', 'title' => 'Office Produksi (Kanan)'],
            26 => ['top' => '36.3%', 'left' => '72.6%', 'title' => 'Belakang VM 1'],
            27 => ['top' => '49.0%', 'left' => '12.4%', 'title' => 'Final VM 1'],
            28 => ['top' => '42.2%', 'left' => '38.5%', 'title' => 'Storage SFG WH VM'],
            29 => ['top' => '55.9%', 'left' => '61.2%', 'title' => 'Dekat CO2 System VM 2'],
            30 => ['top' => '69.0%', 'left' => '25.8%', 'title' => 'Belakang VM 2 (APAB)'],
            31 => ['top' => '82.3%', 'left' => '48.7%', 'title' => 'Autopainting'],
            32 => ['top' => '29.1%', 'left' => '88.4%', 'title' => 'WH Rank Material'],
            33 => ['top' => '62.7%', 'left' => '82.0%', 'title' => 'Gate QC dekat KOJA'],
            34 => ['top' => '47.5%', 'left' => '55.9%', 'title' => 'Pintu Trolley KOJA'],
            35 => ['top' => '76.1%', 'left' => '15.6%', 'title' => 'Depan Rak KOJA'],
            36 => ['top' => '89.8%', 'left' => '72.3%', 'title' => 'KOJA MC Inj 9'],
            37 => ['top' => '33.4%', 'left' => '31.7%', 'title' => 'Painting Lens'],
            38 => ['top' => '66.6%', 'left' => '42.1%', 'title' => 'KOJA Assy'],
            39 => ['top' => '43.8%', 'left' => '79.2%', 'title' => 'KOJA ALVM'],
            40 => ['top' => '80.4%', 'left' => '33.9%', 'title' => 'Mezzanine WH Lt.1'],
            41 => ['top' => '24.2%', 'left' => '62.5%', 'title' => 'OASE WH'],
            42 => ['top' => '58.1%', 'left' => '19.8%', 'title' => 'WH Lift Barang'],
            43 => ['top' => '72.7%', 'left' => '68.4%', 'title' => 'Assembling HPW 5'],
            44 => ['top' => '37.9%', 'left' => '51.3%', 'title' => 'Assembling HPW 3'],
            45 => ['top' => '85.2%', 'left' => '58.6%', 'title' => 'Assembling Manual Pos'],
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