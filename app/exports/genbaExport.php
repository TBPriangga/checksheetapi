<?php

namespace App\Exports;
use PhpOffice\PhpSpreadsheet\Style\Border;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithDrawings;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMapping;
use Carbon\Carbon;
use App\Models\laporan;
use Illuminate\Support\Arr;
use Maatwebsite\Excel\Concerns\WithColumnWidths;

class genbaExport implements 
WithColumnWidths,
ShouldAutoSize,
WithEvents, 
WithCustomStartCell, 
WithHeadings,
WithMapping,
FromQuery
{
    use Exportable;
    private $index = 0;

    public function setParameter(array $parameter)
    {
        if (Arr::has($parameter, 'tipe_tabel')) {
            $this->tipeTable = $parameter['tipe_tabel'];
            $this->timeStart = date("Y-m-d", strtotime($parameter['timeStart']));
            $this->timeEnd = date("Y-m-d", strtotime($parameter['timeEnd']));
            $this->role = auth()->user()->getRoleNames()->first();
            $this->kategori = $parameter['kategori'];
            $this->rank = $parameter['rank'];
            $this->status = $parameter['status'];

        } else {
            $this->genba_id = $parameter['genba_id'];
            $this->tipeTable = null;
        }

        if (Arr::has($parameter, 'area')) {
            $this->area = $parameter['area'];
        } else {
            $this->area = null;
        }
        return $this;
    }

    public function query()
    {
        if($this->tipeTable == null){
            $this->laporan = laporan::query()->where('genba_id', $this->genba_id);
        } else {
            if($this->tipeTable == 'semua') {
                $this->laporan = laporan::query()->where('genba_id','!=', null );
            } else {
                $this->laporan = laporan::query()->where('genba_id','!=', null );
                $this->laporan->where('area_id', $this->tipeTable );
            }
            if ($this->kategori != 0) {
                $this->laporan->where('kategori', $this->kategori);
            }
            
            if ($this->area != "" || $this->area !== null) {
                $this->laporan->where('area_id', $this->area);
            }
            
            // Filter berdasarkan rank jika ada
            if ($this->rank != 0) {
                $this->laporan->where('rank', $this->rank);
            }
            
            // Filter berdasarkan status jika ada
            if ($this->status != 0) {
                if ($this->status == 1) {
                    $this->laporan->where('progress', 0 );
                } else if ($this->status == 2) {
                    $this->laporan->where('progress', '>', 0)->where('progress', '<', 10);
                } else if ($this->status == 3) {
                    $this->laporan->where('verify_submit_at', null)->where('progress', 10);
                } else if ($this->status == 4) {
                    $this->laporan->whereNotNull('verify_submit_at')->where('progress', 10);
                }
            }
        }
        return $this->laporan->orderBy('created_at', 'desc');

        
    }

    public function map($laporan): array {
        return [
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '', 
        ];
    }

    public function headings(): array
    {
        return [
            ['No', 'Problem Found','', 'Analysis','','', 'Kategori Stop-6', 'RANK', 'Counter meassurance','','','','', 'PIC', 'Due Date', 'Status'],
            ['', '','', '', '','','','', 'Temporary','', 'Fix (Permanent)','','','','','',''],
        ];
    }

    public function columnWidths(): array
    {
        return [            
            'B' => 11,            
            'C' => 30,            
            'D' => 20,            
            'E' => 3,            
            'F' => 30,            
            'G' => 10,            
            'H' => 8,            
            'I' => 20,            
            'F' => 30,            
            'N' => 15,            
        ];
    }

    public function registerEvents(): array
    {
        return [
            BeforeSheet::class => function(BeforeSheet $event) {
    
                // Mengatur properti sebelum sheet diekspor
                
                $event->sheet->getColumnDimension('D')->setWidth(50);
            },
            
            AfterSheet::class => function(AfterSheet $event) {
                
                $event->sheet->getStyle('F5')->getAlignment()->setWrapText(true);
                $event->sheet->getStyle('G5')->getAlignment()->setWrapText(true);
                
                $laporans = $this->laporan->get();
                // Merge header baris 1-4
                $event->sheet->mergeCells('A1:B4');
                $event->sheet->mergeCells('C1:N3');
                $event->sheet->mergeCells('C4:D4');
                $event->sheet->mergeCells('E4:K4');
                $event->sheet->mergeCells('L4:N4');
                $event->sheet->mergeCells('O1:P4');
                $event->sheet->getCell('C1')->setValue("PROBLEM IDENTIFICATION AND CORRECTIVE ACTION". "\n" . "5R & SAFETY MANAGEMENT");
                $event->sheet->getStyle('C1')->getFont()->setSize(21);
                $event->sheet->getStyle('C1')->getFont()->setBold(true);
                $event->sheet->getStyle('C1')->getFont()->setName('Calibri');
                $event->sheet->getStyle('C1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $event->sheet->getStyle('C1')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
                $event->sheet->getStyle('A' . 5 . ':P' . 6)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $event->sheet->getStyle('A' . 5 . ':P' . 6)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
                
                // $event->sheet->getRowDimension(4)->setRowHeight(50);
                $drawing = new Drawing();
                $drawing->setName('Logo');
                $drawing->setDescription('This is my logo');
                $drawing->setPath(public_path('ajilogo.png'));
                $drawing->setHeight(70); 
                $drawing->setCoordinates('A1');
                $drawing->setWorksheet($event->sheet->getDelegate());
                
                $drawing2 = new Drawing();
                $drawing2->setName('Other image');
                $drawing2->setDescription('This is a second image');
                $drawing2->setPath(public_path('ehslogo.png'));
                $drawing2->setHeight(60);
                $drawing2->setCoordinates('O1');
                $drawing2->setWorksheet($event->sheet->getDelegate());
                
                $pathOpen = public_path("zero.png");
                $path25 = public_path("progress_25.png");
                $path50 = public_path("progress_50.png");
                $path75 = public_path("progress_75.png");
                $pathClosed = public_path("closed.png");
                
                $event->sheet->mergeCells('A5:A6');
                $event->sheet->mergeCells('B5:C6');
                $event->sheet->mergeCells('D5:F6');
                $event->sheet->mergeCells('G5:G6');
                $event->sheet->mergeCells('H5:H6');
                $event->sheet->mergeCells('I5:M5');
                $event->sheet->mergeCells('I6:J6');
                $event->sheet->mergeCells('K6:M6');
                $event->sheet->mergeCells('N5:N6');
                $event->sheet->mergeCells('O5:O6');
                $event->sheet->mergeCells('P5:P6');
                $event->sheet->getStyle('C1')->getAlignment()->setWrapText(true);
                
                Carbon::setLocale('id');
                $event->sheet->getCell('C4')->setValue("Periode : " . str_replace('-', ' ', Carbon::parse($laporans[0]->laporan_genba->tanggal_patrol)->isoFormat('DD MMMM YYYY')));
                $event->sheet->getCell('L4')->setValue("Group Auditor : ". $laporans[0]->laporan_genba->team->name);
                $event->sheet->getStyle('l4')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
                $rowIndex = 7; // Start from the second row assuming the headers are in the first row
                $count = 1;
                foreach ($laporans as $laporan) {
                    $event->sheet->getStyle('A' . $rowIndex)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                    $event->sheet->getStyle('A' . $rowIndex)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
                    $event->sheet->getCell('a'. $rowIndex)->setValue($count);
                    
                    $event->sheet->getStyle('D'.$rowIndex.":D".$rowIndex+9)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP);
                    $event->sheet->getStyle('E'.$rowIndex.":E".$rowIndex+9)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP);
                    $event->sheet->getStyle('F'.$rowIndex.":F".$rowIndex+9)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP);

                    $event->sheet->mergeCells('A'.$rowIndex.':A'.($rowIndex + 9));
                    $event->sheet->mergeCells('B'.$rowIndex.':C'.($rowIndex + 9));
                    $event->sheet->mergeCells('G'.$rowIndex.':G'.($rowIndex + 9));
                    $event->sheet->mergeCells('H'.$rowIndex.':H'.($rowIndex + 9));
                    $event->sheet->mergeCells('I'.$rowIndex.':J'.($rowIndex + 9));
                    $event->sheet->mergeCells('K'.$rowIndex.':M'.($rowIndex + 7));
                    $event->sheet->mergeCells('K'.($rowIndex + 8).':M'.($rowIndex + 9));
                    $event->sheet->mergeCells('N'.$rowIndex.':N'.($rowIndex + 9));
                    $event->sheet->mergeCells('O'.$rowIndex.':O'.($rowIndex + 9));
                    $event->sheet->mergeCells('P'.$rowIndex.':P'.($rowIndex + 9));
                    $event->sheet->getCell('D'. $rowIndex)->setValue('1. Man');
                    $event->sheet->getCell('D'. $rowIndex+1)->setValue('2. Material');
                    $event->sheet->getCell('D'. $rowIndex+2)->setValue('3. Machine');
                    $event->sheet->getCell('D'. $rowIndex+3)->setValue('4. Methode');
                    $event->sheet->getCell('D'. $rowIndex+4)->setValue('1. What');
                    $event->sheet->getCell('D'. $rowIndex+5)->setValue('2. Where');
                    $event->sheet->getCell('D'. $rowIndex+6)->setValue('3. When');
                    $event->sheet->getCell('D'. $rowIndex+7)->setValue('4. WHY');
                    $event->sheet->getCell('D'. $rowIndex+8)->setValue('5. Who');
                    $event->sheet->getCell('D'. $rowIndex+9)->setValue('6. How');
                    $event->sheet->getCell('E'. $rowIndex)->setValue(':');
                    $event->sheet->getCell('E'. $rowIndex+1)->setValue(':');
                    $event->sheet->getCell('E'. $rowIndex+2)->setValue(':');
                    $event->sheet->getCell('E'. $rowIndex+3)->setValue(':');
                    $event->sheet->getCell('E'. $rowIndex+4)->setValue(':');
                    $event->sheet->getCell('E'. $rowIndex+5)->setValue(':');
                    $event->sheet->getCell('E'. $rowIndex+6)->setValue(':');
                    $event->sheet->getCell('E'. $rowIndex+7)->setValue(':');
                    $event->sheet->getCell('E'. $rowIndex+8)->setValue(':');
                    $event->sheet->getCell('E'. $rowIndex+9)->setValue(':');
                    $event->sheet->getCell('F'. $rowIndex)->setValue($laporan->analisis->man . "samcksamcsamkcmsakmcskamcksmakcmsakmcskamkcsamksma");
                    $event->sheet->getStyle('F'.$rowIndex)->getAlignment()->setWrapText(true);
                    $event->sheet->getCell('F'. $rowIndex+1)->setValue($laporan->analisis->material);
                    $event->sheet->getStyle('F'.$rowIndex+1)->getAlignment()->setWrapText(true);
                    $event->sheet->getCell('F'. $rowIndex+2)->setValue($laporan->analisis->machine);
                    $event->sheet->getStyle('F'.$rowIndex+2)->getAlignment()->setWrapText(true);
                    $event->sheet->getCell('F'. $rowIndex+3)->setValue($laporan->analisis->methode);
                    $event->sheet->getStyle('F'.$rowIndex+3)->getAlignment()->setWrapText(true);
                    $event->sheet->getCell('F'. $rowIndex+4)->setValue($laporan->analisis->what);
                    $event->sheet->getStyle('F'.$rowIndex+4)->getAlignment()->setWrapText(true);
                    $event->sheet->getCell('F'. $rowIndex+5)->setValue($laporan->analisis->where);
                    $event->sheet->getStyle('F'.$rowIndex+5)->getAlignment()->setWrapText(true);
                    $event->sheet->getCell('F'. $rowIndex+6)->setValue($laporan->analisis->when);
                    $event->sheet->getStyle('F'.$rowIndex+6)->getAlignment()->setWrapText(true);
                    $event->sheet->getCell('F'. $rowIndex+7)->setValue($laporan->analisis->why);
                    $event->sheet->getStyle('F'.$rowIndex+7)->getAlignment()->setWrapText(true);
                    $event->sheet->getCell('F'. $rowIndex+8)->setValue($laporan->analisis->who);
                    $event->sheet->getStyle('F'.$rowIndex+8)->getAlignment()->setWrapText(true);
                    $event->sheet->getCell('F'. $rowIndex+9)->setValue($laporan->analisis->how);
                    $event->sheet->getStyle('F'.$rowIndex+9)->getAlignment()->setWrapText(true);
                    
                    $event->sheet->getCell('G'. $rowIndex)->setValue($laporan->kategori);
                    $event->sheet->getStyle('G' . $rowIndex)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                    $event->sheet->getStyle('G' . $rowIndex)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
                    $event->sheet->getCell('H'. $rowIndex)->setValue($laporan->rank);
                    $event->sheet->getStyle('H' . $rowIndex)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                    $event->sheet->getStyle('H' . $rowIndex)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
                    
                    $event->sheet->getCell('I'. $rowIndex)->setValue($laporan->temporary_solution);
                    $event->sheet->getStyle('I' . $rowIndex)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                    $event->sheet->getStyle('I' . $rowIndex)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
                    
                    $event->sheet->getCell('K'. ($rowIndex+8))->setValue($laporan->penanggulangan);
                    $event->sheet->getStyle('K' . ($rowIndex+8))->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                    $event->sheet->getStyle('K' . ($rowIndex+8))->getAlignment()->setVertical(Alignment::VERTICAL_TOP);
                    
                    $event->sheet->getCell('N'. $rowIndex)->setValue($laporan->PIC->name);
                    $event->sheet->getStyle('N' . $rowIndex)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                    $event->sheet->getStyle('N' . $rowIndex)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
                    
                    $event->sheet->getCell('O'. $rowIndex)->setValue(Carbon::parse($laporan->deadline_date)->format('d-M-y'));
                    $event->sheet->getStyle('O' . $rowIndex)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                    $event->sheet->getStyle('O' . $rowIndex)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
                    
                    // Insert image for each entry

                    $imagePath = public_path("gambar/foto_temuan/".$laporan->foto_temuan); // Assuming foto_temuan contains the image path
                    $drawing3 = new Drawing();
                    $drawing3->setName('Foto Temuan');
                    $drawing3->setDescription('Foto Temuan');
                $drawing3->setPath($imagePath);
                $drawing3->setHeight(265); // adjust as needed
                $drawing3->setCoordinates('B' . $rowIndex);
                $drawing3->setWorksheet($event->sheet->getDelegate());
                $event->sheet->getRowDimension($rowIndex)->setRowHeight(75);

                $imagePath2 = public_path("gambar/foto_penanggulangan/".$laporan->foto_penanggulangan); // Assuming foto_temuan contains the image path
                $drawing4 = new Drawing();
                $drawing4->setName('Foto penanggulangan');
                $drawing4->setDescription('Foto penanggulangan');
                $drawing4->setPath($imagePath2);
                $drawing4->setHeight(190); // adjust as needed
                $drawing4->setCoordinates('K' . $rowIndex);
                $drawing4->setWorksheet($event->sheet->getDelegate());
                $event->sheet->getRowDimension($rowIndex)->setRowHeight(75);

                if($laporan->progress == 10 && $laporan->verify_submit_at != null) {
                    $imagePath3 = $pathClosed; // Assuming foto_temuan contains the image path
                } else if ($laporan->progress <= 10 && $laporan->progress >= 7.5 ) {
                    $imagePath3 = $path75;
                } else if ($laporan->progress < 7.5 && $laporan->progress >= 5 ) {
                    $imagePath3 = $path50;
                } else if ($laporan->progress < 5 && $laporan->progress >= 2.5 ) {
                    $imagePath3 = $path25;
                } else if ($laporan->progress < 2.5) {
                    $imagePath3 = $pathOpen;
                }
                
                $drawing5 = new Drawing();
                $drawing5->setName('Foto penanggulangan');
                $drawing5->setDescription('Foto penanggulangan');
                $drawing5->setPath($imagePath3);
                $drawing5->setHeight(40); // adjust as needed
                // Dapatkan lebar kolom M
                $columnWidthM = $event->sheet->getColumnDimension('M')->getWidth();
                $rowHeight = $event->sheet->getRowDimension($rowIndex)->getRowHeight();

                // Hitung lebar gambar
                $imageWidth = $drawing5->getWidth();
                // Hitung tinggi gambar
                $imageHeight = $drawing5->getHeight();

                // Hitung posisi awal gambar berdasarkan lebar kolom M dan lebar gambar
                $imageStartPosition = ($imageWidth - $columnWidthM) / 2;
                // Hitung posisi vertikal awal gambar berdasarkan tinggi baris dan tinggi gambar
                $imageVerticalStartPosition = ( $rowHeight - $imageHeight) / 2;


                // Set koordinat gambar dengan menggunakan posisi awal
                $drawing5->setCoordinates('P' . ($rowIndex +1));
                $drawing5->setOffsetX($imageStartPosition); // Sesuaikan posisi gambar dengan posisi awal
                $drawing5->setOffsetY($imageVerticalStartPosition); 
                $drawing5->setWorksheet($event->sheet->getDelegate());
                $event->sheet->getRowDimension($rowIndex)->setRowHeight(75);

                // $event->sheet->getStyle('A' . $rowIndex . ':M' . $rowIndex)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                // $event->sheet->getStyle('A' . $rowIndex . ':M' . $rowIndex)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
                // $event->sheet->getStyle('B'. $rowIndex)->getAlignment()->setTextRotation(90);
                // $event->sheet->getStyle('C'. $rowIndex)->getAlignment()->setTextRotation(90);
                // $event->sheet->getStyle('J'. $rowIndex)->getAlignment()->setTextRotation(90);
                // $event->sheet->getStyle('K'. $rowIndex)->getAlignment()->setTextRotation(90);
                // $event->sheet->getStyle('L'. $rowIndex)->getAlignment()->setTextRotation(90);
                // $event->sheet->getStyle('D' . $rowIndex)->getAlignment()->setWrapText(true);
                // $event->sheet->getStyle('H' . $rowIndex)->getAlignment()->setWrapText(true);
                // Move to the next row
                $rowIndex += 10;
                $count++;
            }
            $event->sheet->getStyle('A7:P'.($rowIndex - 1))->applyFromArray([
                'borders' => [
                    'outline' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['argb' => '000000'],
                    ],
                ],
            ]);
            $event->sheet->mergeCells('B' . ($rowIndex + 2) . ':D' . ($rowIndex + 2));
            $event->sheet->getCell('B'. ($rowIndex + 2))->setValue('KETERANGAN KATEGORI STOP-6:');
            $event->sheet->getCell('B'. ($rowIndex + 3))->setValue('5R');
            $event->sheet->getCell('B'. ($rowIndex + 4))->setValue('A');
            $event->sheet->getCell('B'. ($rowIndex + 5))->setValue('B');
            $event->sheet->getCell('B'. ($rowIndex + 6))->setValue('C');
            $event->sheet->getCell('B'. ($rowIndex + 7))->setValue('D');
            $event->sheet->getCell('B'. ($rowIndex + 8))->setValue('E');
            $event->sheet->getCell('B'. ($rowIndex + 9))->setValue('F');
            $event->sheet->getCell('B'. ($rowIndex + 10))->setValue('G');
            $event->sheet->getCell('B'. ($rowIndex + 11))->setValue('O');
            $event->sheet->getCell('C'. ($rowIndex + 3))->setValue(': Ringkas, Rapi, Resik, Rawat & Rajin');
            $event->sheet->getCell('C'. ($rowIndex + 4))->setValue(': Apparatus (Terjepit, terdampak Mesin)');
            $event->sheet->getCell('C'. ($rowIndex + 5))->setValue(': Big Heavy (Tertimpa, terbentur benda berat)');
            $event->sheet->getCell('C'. ($rowIndex + 6))->setValue(': Car (Tertabrak kendaraan bermotor)');
            $event->sheet->getCell('C'. ($rowIndex + 7))->setValue(': Drop (Jatuh dari ketinggian)');
            $event->sheet->getCell('C'. ($rowIndex + 8))->setValue(': Electricity (Terkena sengatan listrik)');
            $event->sheet->getCell('C'. ($rowIndex + 9))->setValue(': Fire (Kebakaran atau terkait panas)');
            $event->sheet->getCell('C'. ($rowIndex + 10))->setValue(': Green Hazzard (Pencemaran)');
            $event->sheet->getCell('C'. ($rowIndex + 11))->setValue(': Other (Selain kategori A, B, C, D, E, F, G)');
                $event->sheet->getStyle('B' . ($rowIndex + 2))->getFont()->setBold(true);
                $event->sheet->getStyle('B' . ($rowIndex + 2))->getFont()->setName('Calibri');

            $event->sheet->mergeCells('G' . ($rowIndex + 2) . ':H' . ($rowIndex + 2));
            $event->sheet->getCell('G'. ($rowIndex + 2))->setValue('KETERANGAN RANK:');
            $event->sheet->getCell('G'. ($rowIndex + 3))->setValue('Rank A');
            $event->sheet->getCell('G'. ($rowIndex + 4))->setValue('Rank B');
            $event->sheet->getCell('G'. ($rowIndex + 5))->setValue('Rank C');
            $event->sheet->getCell('H'. ($rowIndex + 3))->setValue(': Kecelakaan berat yang menyebabkan cacat tetap atau meninggal dunia');
            $event->sheet->getCell('H'. ($rowIndex + 4))->setValue(': Kecelakaan sedang yang menyebabkan kehilangan hari kerja / cacat sementara');
            $event->sheet->getCell('H'. ($rowIndex + 5))->setValue(': Kecelakaan ringan/ penanganan P3K dan tidak menyebabkan kehilangan hari kerja');
                $event->sheet->getStyle('G' . ($rowIndex + 2))->getFont()->setBold(true);
                $event->sheet->getStyle('G' . ($rowIndex + 2))->getFont()->setName('Calibri');


        $drawing6 = new Drawing();
        $drawing6->setName('Other image');
        $drawing6->setDescription('This is a second image');
        $drawing6->setPath($pathOpen);
        $drawing6->setHeight(50);
        $drawing6->setCoordinates('G'. ($rowIndex + 8));
        $drawing6->setWorksheet($event->sheet->getDelegate());
        $event->sheet->getCell('H'. ($rowIndex + 8))->setValue('OPEN');

        $drawing7 = new Drawing();
        $drawing7->setName('Other image');
        $drawing7->setDescription('This is a second image');
        $drawing7->setPath($path75);
        $drawing7->setHeight(50);
        $drawing7->setCoordinates('G'. ($rowIndex + 11));
        $drawing7->setWorksheet($event->sheet->getDelegate());
        $event->sheet->getCell('H'. ($rowIndex + 11))->setValue('PROGRESS');

        $drawing8 = new Drawing();
        $drawing8->setName('Other image');
        $drawing8->setDescription('This is a second image');
        $drawing8->setPath($pathClosed);
        $drawing8->setHeight(50);
        $drawing8->setCoordinates('I'. ($rowIndex + 8));
        $drawing8->setOffsetX(220); 
        $drawing8->setWorksheet($event->sheet->getDelegate());
        $event->sheet->getCell('K'. ($rowIndex + 8))->setValue('CLOSED');
       
            },
        ];
    }

    public function startCell(): string {
        return 'A5';
    }
}
