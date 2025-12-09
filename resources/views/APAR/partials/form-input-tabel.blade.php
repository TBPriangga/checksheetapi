{{-- resources/views/apar/partials/form-input-tabel.blade.php --}}
<div class="apar-card">
    <div class="apar-card-header">
        <h3 class="apar-title">Form Pengecekan APAR</h3>
        <div class="apar-badge apar-badge-{{ $apar->jenis === 'CO2' ? 'co2' : 'powder' }}">
            {{ $apar->kode_apar }} ({{ $apar->jenis }})
        </div>
    </div>

    <div class="apar-card-body">
        <div class="apar-location">
            <svg class="apar-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
            <span>Lokasi: {{ $apar->lokasi_apar }}</span>
        </div>

        <form action="{{ route('inspeksi-apar.store-check', $apar) }}" method="POST" class="apar-form">
            @csrf

            <div class="apar-grid-sejajar">
                <!-- KOLOM KIRI: GAMBAR + INPUT -->
                <div class="apar-col-left">
                    <!-- GAMBAR -->

                        <div class="apar-guide-title">Panduan Check Points</div>
                        <img src="{{ asset('cekpoint.jpg') }}" alt="Panduan" class="apar-guide-img-full">


                    <!-- INPUT KIRI -->
                    <div class="apar-input-group-left">
                        <div class="apar-form-group">
                            <label class="apar-label">Segitiga APAR 2 Arah <span class="apar-required">*</span></label>
                            <small class="apar-help">Standar : Terpasang & tidak rusak</small>
                            <select name="segitiga_dua_arah" class="apar-input" required>
                                <option value="" disabled selected>Pilih status...</option>
                                <option value="OK">OK</option>
                                <option value="NG">NG</option>
                            </select>
                        </div>

                        <div class="apar-form-group">
                            <label class="apar-label">Segitiga APAR <span class="apar-required">*</span></label>
                            <small class="apar-help">Standar : Terpasang & tidak rusak</small>
                            <select name="segitiga_apar" class="apar-input" required>
                                <option value="OK">OK</option>
                                <option value="NG">NG</option>
                            </select>
                        </div>

                        <div class="apar-form-group">
                            <label class="apar-label">Nomor APAR <span class="apar-required">*</span></label>
                            <small class="apar-help">Standar : Terpasang & Sesuai Nomor , nomor APAR saat ini {{ $apar->kode_apar }}</small>
                            <select name="nomor_apar" class="apar-input" required>
                                <option value="OK">OK</option>
                                <option value="NG">NG</option>
                            </select>
                        </div>

                        <div class="apar-form-group">
                            <label class="apar-label">Pin Pengaman <span class="apar-required">*</span></label>
                            <small class="apar-help">Standar : Terpasang & tidak rusak</small>
                            <select name="pin_pengaman" class="apar-input" required>
                                <option value="OK">OK</option>
                                <option value="NG">NG</option>
                            </select>
                        </div>

                        <div class="apar-form-group">
                            <label class="apar-label">Segel <span class="apar-required">*</span></label>
                            <small class="apar-help">Standar : Terpasang & tidak rusak</small>
                            <select name="segel" class="apar-input" required>
                                <option value="OK">OK</option>
                                <option value="NG">NG</option>
                            </select>
                        </div>

                        <div class="apar-form-group">
                            <label class="apar-label">Selang <span class="apar-required">*</span></label>
                            <small class="apar-help">Standar : Tidak retak ataupun bocor</small>
                            <select name="selang" class="apar-input" required>
                                <option value="OK">OK</option>
                                <option value="NG">NG</option>
                            </select>
                        </div>

                        <div class="apar-form-group">
                            <label class="apar-label">Nozzle <span class="apar-required">*</span></label>
                            <small class="apar-help">Standar : Tidak retak, tidak bocor, tidak ada sumbatan</small>
                            <select name="nozzle" class="apar-input" required>
                                <option value="OK">OK</option>
                                <option value="NG">NG</option>
                            </select>
                        </div>

                        <div class="apar-form-group">
                            <label class="apar-label">Badan Tabung <span class="apar-required">*</span></label>
                            <small class="apar-help">Standar : Warna merah & tidak rusak/penyok</small>
                            <select name="badan_tabung" class="apar-input" required>
                                <option value="OK">OK</option>
                                <option value="NG">NG</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- KOLOM KANAN -->
                <div class="apar-col-right">


                    <div class="apar-form-group">
                        <label class="apar-label">Handle <span class="apar-required">*</span></label>
                        <small class="apar-help">Standar : Ada & tidak rusak</small>
                        <select name="handle" class="apar-input" required>
                            <option value="OK">OK</option>
                            <option value="NG">NG</option>
                        </select>
                    </div>

                    <div class="apar-form-group">
                        <label class="apar-label">Label APAR <span class="apar-required">*</span></label>
                        <small class="apar-help">Standar : Tersedia & tidak rusak</small>
                        <select name="label_apar" class="apar-input" required>
                            <option value="OK">OK</option>
                            <option value="NG">NG</option>
                        </select>
                    </div>

                    <div class="apar-form-group">
                        <label class="apar-label">Expired Date <span class="apar-required">*</span></label>
                        <small class="apar-help">Please input date</small>
                        <input type="date" name="expired_date" class="apar-input" required>
                    </div>

                    @if($apar->jenis === 'CO2')
                        <div class="apar-highlight-co2">
                            <div class="apar-form-group">
                                <label class="apar-label">Berat Gross (kg) <span class="apar-required">*</span></label>
                                <small class="apar-help">Berat yang tercantum dalam label</small>
                                <input type="number" step="0.01" name="berat_gross" class="apar-input" required>
                            </div>
                            <div class="apar-form-group">
                                <label class="apar-label">Berat Saat Cek (kg) <span class="apar-required">*</span></label>
                                <small class="apar-help">Berat saat ditimbang</small>
                                <input type="number" step="0.01" name="berat_saat_cek" class="apar-input" required>
                            </div>
                            <div class="apar-form-group">
                                <label class="apar-label">Selisih Berat (kg)</label>
                                <input type="text"
                                    id="selisih_berat"
                                    class="apar-input"
                                    readonly
                                    style="background:#f8f9fa;color:#555;">
                            </div>
                        </div>
                    @else
                        <div class="apar-form-group">
                            <label class="apar-label">DIKOCOK / BOLAK - BALIK 3x<span class="apar-required">*</span></label>
                            <small class="apar-help">Standar : Terdengar suara gemericik seperti pasir atau kerikil (Kondisi tidak beku)</small>
                            <select name="dikocok" class="apar-input" required>
                                <option value="OK">OK</option>
                                <option value="NG">NG</option>
                            </select>
                        </div>
                        <div class="apar-form-group">
                            <label class="apar-label">Preassure / Indikator Tekanan <span class="apar-required">*</span></label>
                            <small class="apar-help">Standar : Jarum Menunjukan Ke Warna Hijau. OK (Warna Hijau). NG (Warna Merah / Garis antara Merah & Hijau)</small>
                            <select name="preassure" class="apar-input" required>
                                <option value="OK">OK</option>
                                <option value="NG">NG</option>
                            </select>
                        </div>
                    @endif

                    <div class="apar-form-group">
                        <label class="apar-label">Akses APAR <span class="apar-required">*</span></label>
                        <small class="apar-help">Standar : Posisi yang mudah dilihat dengan jelas, mudah dicapai dan mudah diambil</small>
                        <select name="akses_apar" class="apar-input" required>
                            <option value="OK">OK</option>
                            <option value="NG">NG</option>
                        </select>
                    </div>

                    <div class="apar-form-group">
                        <label class="apar-label">Layout <span class="apar-required">*</span></label>
                        <small class="apar-help">Standar : Tersedia warna merah putih dan tidak rusak</small>
                        <select name="layout" class="apar-input" required>
                            <option value="OK">OK</option>
                            <option value="NG">NG</option>
                        </select>
                    </div>

                    <div class="apar-form-group">
                        <label class="apar-label">Manufacturing Date <span class="apar-required">*</span></label>
                        <small class="apar-help">Please input date</small>
                        <input type="date" name="manufacturing_date" class="apar-input" required>
                    </div>

                    <div class="apar-form-group">
                        <label class="apar-label">Catatan Lainnya</label>
                        <small class="apar-help">Contoh: Tabung sedikit berdebu, perlu dibersihkan</small>
                        <textarea 
                            name="catatan_lainnya" 
                            class="apar-input apar-textarea-normal" 
                            rows="3" 
                            placeholder="Tulis catatan jika ada kerusakan ringan atau informasi tambahan..."
                        ></textarea>
                    </div>

                    <div class="apar-form-group">
                        <label class="apar-label">Tanggal Pemeriksaan <span class="apar-required">*</span></label>
                        <small class="apar-help">Contoh: {{ now()->format('d-m-Y') }}</small>
                        <input type="date" name="tanggal_pemeriksaan" class="apar-input" value="{{ now()->format('Y-m-d') }}" required>
                    </div>
                </div>
            </div>

            <div class="apar-form-actions">
                <button type="submit" class="apar-btn apar-btn-primary">
                    Simpan Pengecekan
                </button>
            </div>
        </form>
    </div>
</div>
