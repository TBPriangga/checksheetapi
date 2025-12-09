<?php

namespace App\Exports;

use App\Models\area;
use Maatwebsite\Excel\Concerns\FromCollection;
use Carbon\Carbon;

class TemplateLaporanExport implements FromCollection
{
    protected $area_id;

    public function __construct($area_id = null)
    {
        $this->area_id = $area_id;
    }

    public function collection()
    {
        $area = $this->area_id ? area::find($this->area_id) : null;
        $area_name = $area ? $area->name : 'Isi Nama Area';

        return collect([
            ['tanggal', 'area', 'nama_penemu', 'npk', 'temuan', 'potensi_bahaya', 'kategori', 'rank', 'saran_perbaikan','URL_Foto_Temuan'],
            [Carbon::now()->format('d-m-Y'), $area_name, 'John Doe', '0026', 'Kabel Tidak Rapih', 'Bahaya Listrik', 'D', 'B', 'Pasang pelindung kabel', 'https://drive.google.com/uc?id=1A2B3C4D5E6F7G8H9I0J&export=download'],
        ]);
    }
}