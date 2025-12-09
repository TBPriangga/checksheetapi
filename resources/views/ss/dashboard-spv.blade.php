@extends('layouts.app-master')

@push('stylesheets')
<style>
    .form-section {
        background: #eaf2fb;
        padding: 16px;
        margin-bottom: 16px;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    }
    .form-section label {
        font-weight: bold;
        margin-bottom: 8px;
        display: block;
        color: #2c5282;
    }
    .highlight {
        background: #ffed4a;
        font-weight: bold;
        padding: 6px 12px;
        border-radius: 4px;
        display: inline-block;
        margin-right: 12px;
    }
    .upload-box {
        background: #d9e3ec;
        border: 2px dashed #718096;
        border-radius: 8px;
        height: 150px;
        display: flex;
        justify-content: center;
        align-items: center;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    .upload-box:hover {
        border-color: #4299e1;
        background: #cbd5e0;
    }
    .upload-box i {
        color: #718096;
        font-size: 2.5rem;
    }
    .submit-btn {
        background: #f6ad55;
        color: #1a202c;
        font-weight: bold;
        padding: 12px 36px;
        border: none;
        border-radius: 6px;
        transition: all 0.3s ease;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }
    .submit-btn:hover {
        background: #ed8936;
        transform: translateY(-2px);
        box-shadow: 0 6px 8px rgba(0, 0, 0, 0.15);
    }
    .form-control {
        border-radius: 6px;
        border: 1px solid #cbd5e0;
        padding: 10px 12px;
    }
    .form-control:focus {
        border-color: #4299e1;
        box-shadow: 0 0 0 3px rgba(66, 153, 225, 0.2);
    }
    .table th {
        background-color: #4299e1 !important;
        color: white;
        font-weight: 600;
    }
    .container-fluid {
        padding: 24px;
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <form action="#" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <!-- Kolom Kiri -->
            <div class="col-md-7">
                <!-- Periode -->
                <div class="form-section">
                    <label for="periode">Periode</label>
                    <input type="text" class="form-control" id="periode" name="periode" placeholder="Masukkan periode" required>
                </div>

                <!-- Departement -->
                <div class="form-section">
                    <label for="department">Departement</label>
                    <input type="text" class="form-control" id="department" name="department" placeholder="Masukkan departemen" required>
                </div>

                <!-- Section -->
                <div class="form-section">
                    <label for="section">Section</label>
                    <input type="text" class="form-control" id="section" name="section" placeholder="Masukkan section" required>
                </div>

                <!-- Tabel -->
                <div class="form-section">
                    <div class="table-responsive">
                        <table class="table table-bordered table-sm text-center align-middle">
                            <thead class="table-primary">
                                <tr>
                                    <th>NO</th>
                                    <th>Tanggal</th>
                                    <th>Nama</th>
                                    <th>Judul Ide</th>
                                    <th>Kondisi Before</th>
                                    <th>Kondisi After</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td colspan="7" class="text-muted py-4">Data belum tersedia</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Kolom Kanan -->
            <div class="col-md-5">
                <!-- Kondisi Before -->
                <div class="form-section">
                    <label for="beforeImage">Kondisi Before:</label>
                    <div class="upload-box" onclick="document.getElementById('beforeImage').click()">
                        <i class="fa fa-image fa-2x"></i>
                        <span class="ms-2">Klik untuk mengupload gambar</span>
                    </div>
                    <input type="file" id="beforeImage" name="beforeImage" accept="image/*" style="display: none;">
                </div>

                <!-- Kondisi After -->
                <div class="form-section">
                    <label for="afterImage">Kondisi After:</label>
                    <div class="upload-box" onclick="document.getElementById('afterImage').click()">
                        <i class="fa fa-image fa-2x"></i>
                        <span class="ms-2">Klik untuk mengupload gambar</span>
                    </div>
                    <input type="file" id="afterImage" name="afterImage" accept="image/*" style="display: none;">
                </div>

                <!-- Saving Cost -->
                <div class="form-section d-flex align-items-center">
                    <span class="highlight">Saving Cost</span>
                    <input type="number" class="form-control" name="saving_cost" placeholder="Input nilai saving cost" required>
                </div>

                <!-- Nilai Ide & Nilai Pengaruh -->
                <div class="form-section">
                    <div class="row">
                        <div class="col-md-6 mb-3 mb-md-0">
                            <label for="nilaiIde">Nilai Ide</label>
                            <input type="number" class="form-control" id="nilaiIde" name="nilai_ide" placeholder="Input nilai ide" required>
                        </div>
                        <div class="col-md-6">
                            <label for="nilaiPengaruh">Nilai Pengaruh</label>
                            <input type="number" class="form-control" id="nilaiPengaruh" name="nilai_pengaruh" placeholder="Input nilai pengaruh" required>
                        </div>
                    </div>
                </div>

                <!-- Submit -->
                <div class="text-end mt-4">
                    <button type="submit" class="submit-btn">SUBMIT ➜</button>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
    // JavaScript untuk menangani preview gambar (opsional)
    document.getElementById('beforeImage').addEventListener('change', function(e) {
        // Tambahkan kode untuk preview gambar sebelum upload
    });
    
    document.getElementById('afterImage').addEventListener('change', function(e) {
        // Tambahkan kode untuk preview gambar sebelum upload
    });
</script>
@endsection