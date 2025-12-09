<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class LaporanImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        Log::info('Raw rows dari LaporanImport: ' . json_encode($rows->toArray()));
        Log::info('Indeks baris dari LaporanImport: ' . json_encode($rows->keys()->toArray()));
        return $rows->values(); // Reset indeks untuk memastikan urutan
    }

    public function headingRow(): int
    {
        return 1; // Pastikan header di row 1
    }
}