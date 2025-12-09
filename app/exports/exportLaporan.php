<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use App\Models\laporan;
use Illuminate\Support\Collection;

class ExportLaporan implements FromView, ShouldAutoSize, WithEvents, WithCustomStartCell
{
    protected $data;

    /**
     * Constructor untuk menerima data dari controller
     * 
     * @param Collection|null $data
     */
    public function __construct($data = null)
    {
        $this->data = $data;
    }

    /**
     * View untuk diekspor
     *
     * @return View
     */
    public function view(): View
    {
        // Jika data tidak diberikan, ambil default (untuk backward compatibility)
        $laporan = $this->data ?? laporan::limit(100)->get();

        return view('excel.excelLaporan', [
            'laporan' => $laporan
        ]);
    }

    /**
     * Memanipulasi sheet setelah diekspor
     *
     * @return array
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                // Style header
                $event->sheet->getStyle('A5:M5')->applyFromArray([
                    'font' => [
                        'bold' => true,
                    ]
                ]);

                // Merge header baris 1-4
                $event->sheet->mergeCells('A1:B4');
                $event->sheet->mergeCells('C1:K4');
                $event->sheet->mergeCells('L1:M4');

                // Set logo pada kolom A-B baris 1-3
                $logoPath = public_path('ajilogo.png');
                if (file_exists($logoPath)) {
                    $drawing = new Drawing();
                    $drawing->setName('Logo');
                    $drawing->setDescription('Logo');
                    $drawing->setPath($logoPath);
                    $drawing->setCoordinates('A1');
                    $drawing->setWorksheet($event->sheet->getDelegate());
                }

                // Set logo pada kolom L-M baris 1-3
                $logoEHSPath = public_path('ehslogo.png');
                if (file_exists($logoEHSPath)) {
                    $drawing = new Drawing();
                    $drawing->setName('Logoehs');
                    $drawing->setDescription('Logoehs');
                    $drawing->setPath($logoEHSPath);
                    $drawing->setCoordinates('L1');
                    $drawing->setWorksheet($event->sheet->getDelegate());
                }
            },
        ];
    }

    /**
     * Heading untuk Excel
     * 
     * @return array
     */
    public function headings(): array
    {
        return [
            'No',
            'Tanggal',
            'Area',
            'Temuan',
            'Foto Temuan 1',
            'Kategori Stop-6',
            'Rank',
            'Penanggulangan',
            'Foto Temuan 2',
            'PIC',
            'Due Date',
            'Verif',
            'Status',
        ];
    }

    /**
     * Start cell untuk data
     * 
     * @return string
     */
    public function startCell(): string 
    {
        return 'A5';
    }
}