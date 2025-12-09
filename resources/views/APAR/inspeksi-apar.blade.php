{{-- resources/views/apar/inspeksi-apar.blade.php --}}
@extends('component.navbar')

@push('stylesheets')
    <link rel="stylesheet" href="{{ asset('css/aparStyle.css') }}">
@endpush

@section('content')
    <div class="apar-scan-container">
        <h4>Scan atau Masukkan Kode APAR</h4>

        @if (session('success'))
            <div class="apar-alert apar-alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="apar-alert apar-alert-danger">{{ session('error') }}</div>
        @endif

        <!-- INPUT KODE APAR -->
        <div class="apar-input-group">
            <input 
                type="text" 
                id="kode_apar" 
                class="apar-scan-input" 
                placeholder="Scan barcode atau ketikan kode APAR..." 
                autofocus
                autocomplete="off"
            >
        </div>
    </div>

    <!-- FORM AKAN MUNCUL DI SINI -->
    <div id="form-result"></div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const kodeInput = document.getElementById('kode_apar');
    const formResult = document.getElementById('form-result');

    if (!kodeInput || !formResult) {
        console.error('Elemen tidak ditemukan!');
        return;
    }

    let debounceTimer;

    // FUNGSI INISIALISASI SELISIH BERAT (GLOBAL)
    window.initSelisihBerat = function() {
        const gross = document.querySelector('input[name="berat_gross"]');
        const cek   = document.querySelector('input[name="berat_saat_cek"]');
        const selisih = document.getElementById('selisih_berat');

        // Hapus listener lama (anti-duplikat)
        if (gross) gross.removeEventListener('input', hitung);
        if (cek) cek.removeEventListener('input', hitung);

        function hitung() {
            if (!gross || !cek || !selisih) return;
            const g = parseFloat(gross.value) || 0;
            const c = parseFloat(cek.value)   || 0;
            selisih.value = (g - c).toFixed(2);
        }

        if (gross && cek && selisih) {
            gross.addEventListener('input', hitung);
            cek.addEventListener('input', hitung);
            hitung(); // Hitung saat form pertama kali muncul
        }
    };

    // AUTO VERIFY SAAT MENGETIK
    function autoVerify() {
        clearTimeout(debounceTimer);
        const kode = kodeInput.value.trim();

        if (kode.length < 3) {
            formResult.innerHTML = '';
            return;
        }

        debounceTimer = setTimeout(() => {
            const formData = new FormData();
            formData.append('kode_apar', kode);

            fetch("{{ route('inspeksi-apar.verify') }}", {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    "Accept": "application/json"
                },
                body: formData
            })
            .then(response => {
                const contentType = response.headers.get("content-type");
                if (!contentType || !contentType.includes("application/json")) {
                    throw new Error("Server error");
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    formResult.innerHTML = data.html;

                    // INI YANG PENTING: JALANKAN ULANG SETELAH AJAX
                    window.initSelisihBerat();

                    // Fokus ke input pertama
                    const firstField = formResult.querySelector('input, select, textarea');
                    if (firstField) {
                        setTimeout(() => firstField.focus(), 100);
                    }

                    // Re-init tooltip
                    formResult.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(el => {
                        new bootstrap.Tooltip(el);
                    });
                } else {
                    formResult.innerHTML = `
                        <div class="apar-alert apar-alert-danger">
                            ${data.message || 'Kode yang Anda masukan tidak sesuai.'}
                        </div>`;
                }
            })
            .catch(err => {
                console.error('Error:', err);
                formResult.innerHTML = `
                    <div class="apar-alert apar-alert-danger">
                        Terjadi kesalahan. Silakan coba lagi.
                    </div>`;
            });
        }, 600);
    }

    kodeInput.addEventListener('input', autoVerify);
    kodeInput.addEventListener('paste', autoVerify);

    // Fokus otomatis ke input kode saat halaman dimuat
    kodeInput.focus();
});
</script>
@endpush