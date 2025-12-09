<?php

namespace App\Exports;

use App\Models\PemeriksaanApar;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Carbon\Carbon;

class MonitoringAparExport implements FromCollection, WithHeadings, WithMapping
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function collection()
    {
        return $this->data; // Langsung pakai data dari controller
    }

    public function headings(): array
    {
        return [
            'Kode APAR',
            'Jenis',
            'Lokasi',
            'Checker',
            'Tanggal Pemeriksaan',
            'Segitiga 2 Arah',
            'Segitiga APAR',
            'Nomor APAR',
            'Pin Pengaman',
            'Segel',
            'Selang',
            'Nozzle',
            'Badan Tabung',
            'Handle',
            'Label APAR',
            'Expired Date',
            'Akses APAR',
            'Layout',
            'Dikocok',
            'Preassure',
            'Berat Gross (kg)',
            'Berat Saat Cek (kg)',
            'Selisih Berat (kg)',
            'Manufacturing Date',
            'Catatan Lainnya',
        ];
    }

    public function map($row): array
    {
        $check = $row;
        $apar = $row->apar;

        return [
            $apar->kode_apar,
            $apar->jenis,
            $apar->lokasi_apar,
            $check->checker,
            $check->tanggal_pemeriksaan?->format('d/m/Y') ?? '-',
            $check->segitiga_dua_arah,
            $check->segitiga_apar,
            $check->nomor_apar,
            $check->pin_pengaman,
            $check->segel,
            $check->selang,
            $check->nozzle,
            $check->badan_tabung,
            $check->handle,
            $check->label_apar,
            $check->expired_date?->format('d/m/Y') ?? '-',
            $check->akses_apar,
            $check->layout,
            $check->dikocok ?? '-',           // Powder only
            $check->preassure ?? '-',         // Powder only
            $check->berat_gross ?? '-',       // CO2 only
            $check->berat_saat_cek ?? '-',    // CO2 only
            $check->selisih_berat ?? '-',     // CO2 only
            $check->manufacturing_date?->format('d/m/Y') ?? '-',
            $check->catatan_lainnya ?? '-',
        ];
    }
}