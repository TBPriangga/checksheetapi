<?php
namespace App\Exports;


use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
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


class UsersExport implements
    WithColumnWidths,
    // FromCollection,
    ShouldAutoSize,
    WithEvents,
    WithCustomStartCell,
    WithHeadings,
    // WithDrawings,
    WithMapping,
    FromQuery


{
    use Exportable;
    private $index = 0;


    public function setParameter(array $parameter)
    {
        if (Arr::has($parameter, 'tipe_tabel')) {
            $this->tipeTable = $parameter['tipe_tabel'];
            if($this->tipeTable == "laporan_patrol") {
                $this->patrol_id = $parameter['patrol_id'];
            }
        } else {
            $this->tipeTable = null;
        }
        if (!Arr::has($parameter, 'patrol_id')) {
            $this->role = auth()->user()->getRoleNames()->first();
           
            $this->timeStart = Carbon::createFromFormat('d/m/Y', $parameter['timeStart'])->format('Y-m-d');
            $this->timeEnd =  Carbon::createFromFormat('d/m/Y', $parameter['timeEnd'])->format('Y-m-d');


            if (Arr::has($parameter, 'area')) {
                $this->area = $parameter['area'];
            } else {
                $this->area = null;
            }
            $this->kategori = $parameter['kategori'];
            $this->rank = $parameter['rank'];
            $this->status = $parameter['status'];
        }
       
        return $this;
    }
   
    /**
     * @return \Illuminate\Support\Collection
     */
    public function query()
    {
        if($this->tipeTable == "laporan_patrol") {
            if (auth()->user()->hasRole([ 'EHS'])) {
                $this->laporan = laporan::query()->where('patrol_id' , $this->patrol_id)
                ->where('genba_id', null);
            }else{
                $this->laporan = laporan::query()->where('patrol_id' , $this->patrol_id)
                                                 ->where('genba_id', null)->where('deleted_at', null);
            }
        } else {


            if($this->tipeTable == null){
                if ($this->role == 'EHS') {
                    $this->laporan = laporan::query()->where('auditor_id' , auth()->user()->id)
                    ->whereBetween('created_at', [$this->timeStart." 00:00:00", $this->timeEnd." 23:59:59"])->where('genba_id', null);
                    // ->whereBetween('created_at', [$this->timeStart." 00:00:00", $this->timeEnd." 23:59:59"])->where('genba_id', null)->where('deleted_at', null);
                } else if (auth()->user()->hasRole(['Departement Head PIC', 'PIC'])) {
                    $this->laporan = laporan::query()->select('laporan.*')->join('user_has_areas', 'user_has_areas.area_id', '=', 'laporan.area_id')
                          ->where('user_has_areas.user_id', auth()->user()->id)->whereBetween('laporan.created_at', [$this->timeStart." 00:00:00", $this->timeEnd." 23:59:59"])->where('deleted_at', null);
                }
            } else {
                $this->laporan = laporan::query()->whereBetween('created_at', [$this->timeStart." 00:00:00", $this->timeEnd." 23:59:59"])->where('genba_id', null);
                // $this->laporan = laporan::query()->whereBetween('created_at', [$this->timeStart." 00:00:00", $this->timeEnd." 23:59:59"])->where('genba_id', null)->where('deleted_at', null);
            }
   
            if ($this->kategori != 0) {
                $this->laporan->where('kategori', $this->kategori);
            }
           
            if($this->tipeTable == "semua") {
                if ($this->area != "" || $this->area !== null) {
                    $this->laporan->where('area_id', $this->area);
                }
            } else {
                if (auth()->user()->hasRole(['Departement Head PIC', 'PIC'])){
                    if ($this->area != "" || $this->area !== null) {
                        $this->laporan->where('user_has_areas.area_id', $this->area);
                    }
                } else {
                    if ($this->area != "" || $this->area !== null) {
                        $this->laporan->where('area_id', $this->area);
                    }
            }


            }
           
            // Filter berdasarkan rank jika ada
            if ($this->rank != 0) {
                $this->laporan->where('rank', $this->rank);
            }
           
            // Filter berdasarkan status jika ada
            if ($this->status != 0) {
                if ($this->status == 1) {
                    $this->laporan->where('progress','<=',10 )->whereNull('ACC_Dept_Head_PIC_At');
                } else if ($this->status == 2) {
                    $this->laporan->where('verify_submit_at', null)->where('progress','>=', 11);
                } else if ($this->status == 3) {
                    $this->laporan->whereNotNull('verify_submit_at')->where('ACC_Dept_Head_EHS_At', null )->where('progress','>=', 12);
                } else if ($this->status == 4) {
                    $this->laporan->whereNotNull('ACC_Dept_Head_EHS_At')->where('progress', '>=', 13);
                }
            }


        }
        // $lao = $this->laporan->get();
        // dd($lao[0]->PIC->name);
        return $this->laporan->orderBy('created_at', 'desc');
       
    }
   
    public function map($laporan): array {
        return [
            ++$this->index,
            Carbon::parse($laporan->created_at)->format('d-M-y'),
            $laporan->area->name,
            ucfirst($laporan->temuan),
            '',
            $laporan->kategori,
            $laporan->rank,
            ucfirst($laporan->penanggulangan),
            '',
            ucwords($laporan->PIC->name),
            $laporan->wo,
            Carbon::parse($laporan->deadline_date_awal)->format('d-M-y'),
            $laporan->deadline_date !== $laporan->deadline_date_awal
            ? Carbon::parse($laporan->deadline_date)->format('d-M-y')
            : '',
            '',
            '',
        ];
    }
    public function headings(): array
    {
        return [
            'NO',
            'TANGGAL',
            'AREA',
            'TEMUAN',
            'FOTO TEMUAN',
            'KATEGORI STOP-6',
            'RANK',
            'PENANGGULANGAN',
            'FOTO PENANGGULANGAN',
            'PIC',
            'NEED SUPPORT',
            'DUE DATE AWAL',
            'DUE DATE LANJUTAN',
            'VERIF.',
            'STATUS',
        ];
    }
   
    public function columnWidths(): array
    {
        return [
            'D' => 40,            
            'H' => 40,            
            'C' => 8,            
            'B' => 10,            
            'E' => 43,            
            'I' => 43,            
            'F' => 10,            
            'K' => 11,            
            'L' => 11,            
            'M' => 11,            
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


                 // Menentukan area cetak dari A1 sampai N terakhir
                $highestRow = $event->sheet->getHighestRow();
                $highestRow += 14;
                $event->sheet->getDelegate()->getPageSetup()->setPrintArea('A1:O' . $highestRow);
                $event->sheet->getDelegate()->getPageSetup()->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_A4);
               
                // Menentukan orientasi halaman menjadi landscape
                $event->sheet->getDelegate()->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
               
                // Mengatur ukuran cetak agar pas dalam satu halaman
                $event->sheet->getDelegate()->getPageSetup()
                ->setFitToWidth(1)
                ->setFitToHeight(0);


                // Set footer template
                // $footerTemplate = '&L&G&R&D Page &P of &N';


                // // Apply footer template
                // $event->sheet->getHeaderFooter()->setOddFooter(
                //     '&L KETERANGAN KATEGORI STOP-6: 5R, A, B, C, D, E, F, G, O' . "\n" .
                //     'Rank A: Kecelakaan berat' . "\n" .
                //     'Rank B: Kecelakaan sedang' . "\n" .
                //     'Rank C: Kecelakaan ringan');


                $event->sheet->getStyle('A5:O5')->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => 'FF000000'],
                        ],
                    ],
                ]);
               
               
                $event->sheet->getStyle('F5')->getAlignment()->setWrapText(true);
                $event->sheet->getStyle('M5')->getAlignment()->setWrapText(true);
                $event->sheet->getStyle('K5')->getAlignment()->setWrapText(true);
                $event->sheet->getStyle('L5')->getAlignment()->setWrapText(true);
                $laporans = $this->laporan->get();
                // Merge header baris 1-4
                $event->sheet->mergeCells('A1:B4');
                $event->sheet->mergeCells('C1:L4');
                $event->sheet->mergeCells('M1:O4');
                $event->sheet->getCell('C1')->setValue('EHS Patrol');
                $event->sheet->getStyle('C1')->getFont()->setSize(48);
                $event->sheet->getStyle('C1')->getFont()->setBold(true);
                $event->sheet->getStyle('C1')->getFont()->setName('Calibri');
                $event->sheet->getStyle('C1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $event->sheet->getStyle('C1')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
                $event->sheet->getStyle('A' . 5 . ':O' . 5)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $event->sheet->getStyle('A' . 5 . ':O' . 5)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);


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
        $pathCancel = public_path("cancel.png");
       
        $rowIndex = 6; // Start from the second row assuming the headers are in the first row
        function rotateImageIfLandscape($imagePath2, $outputPath) {
            // Load gambar
            $imageExtension = strtolower(pathinfo($imagePath2, PATHINFO_EXTENSION));


            // Load gambar berdasarkan format
            switch ($imageExtension) {
                case 'jpeg':
                case 'jpg':
                    $image = imagecreatefromjpeg($imagePath2);
                    break;
                case 'png':
                    $image = imagecreatefrompng($imagePath2);
                    break;
                case 'gif':
                    $image = imagecreatefromgif($imagePath2);
                    break;
                default:
                    throw new Exception("Unsupported image format: $imageExtension");
            } // Ganti dengan format gambar sesuai kebutuhan


            $width = imagesx($image);
            $height = imagesy($image);
       
            // Jika gambar lanskap, rotasi 90 derajat
            if ($width > $height) {
                $rotatedImage = imagerotate($image, -90, 0);
                imagejpeg($rotatedImage, $outputPath); // Simpan gambar yang diputar
                imagedestroy($rotatedImage);
            } else {
                // Jika tidak lanskap, salin gambar tanpa perubahan
                copy($imagePath2, $outputPath);
            }
       
            imagedestroy($image);
        }
            foreach ($laporans as $laporan) {


                // Function Rotate Gambar
                if ($laporan->verify_submit_at == null) {
                    $event->sheet->getCell('N'. $rowIndex)->setValue('-');                    
                } else {
                    $event->sheet->getCell('N'. $rowIndex)->setValue(Carbon::parse($laporan->verify_submit_at)->format('d-M-y'));
                }






                // Insert image for each entry
                if ($laporan->foto_temuan != null) {
                    $imagePath = public_path("gambar/foto_temuan/" . $laporan->foto_temuan);
                    $rotatedImagePath = public_path("gambar/foto_temuan/rotated_" . $laporan->foto_temuan);
                    $drawing3 = new Drawing();
                    rotateImageIfLandscape($imagePath, $rotatedImagePath);
                    $drawing3->setName('Foto Temuan');
                    $drawing3->setDescription('Foto Temuan');
                    $drawing3->setPath($rotatedImagePath);
                   
                    // Tentukan ukuran maksimum gambar
                    $maxHeight = 1600;
                    $maxWidth = intval(720 * (45 / 180));


                    // Dapatkan dimensi gambar asli
                    list($originalWidth, $originalHeight) = getimagesize($rotatedImagePath);


                    // Hitung skala dan ukuran baru
                    $widthScale = $maxWidth / $originalWidth;
                    $heightScale = $maxHeight / $originalHeight;
                    $scale = min($widthScale, $heightScale);


                    $newWidth = $originalWidth * $scale;
                    $newHeight = $originalHeight * $scale;


                    // Set ukuran gambar
                    if($originalWidth < $originalHeight){
                    $drawing3->setHeight($newHeight+100);
                    }else{
                    $drawing3->setWidth(240);
                    // $drawing3->setHeight($newHeight);
                    }
                    // Tentukan posisi sel untuk gambar
                    $drawing3->setCoordinates('E' . $rowIndex);
                   
                    // Dapatkan lebar kolom dan tinggi baris
                    $columnWidthE = $event->sheet->getColumnDimension('E')->getWidth() * 7.2; // Lebar kolom E dalam piksel
                    $rowHeight = $event->sheet->getRowDimension($rowIndex)->getRowHeight(); // Tinggi baris dalam piksel
                   
                    // Hitung posisi horizontal dan vertikal agar gambar berada di tengah
                    $offsetX = ($columnWidthE - $drawing3->getWidth()) / 2;
                    // $offsetY = ($rowHeight - $drawing3->getHeight()) / 2;
                   
                    // Set offset gambar
                    $drawing3->setOffsetX($offsetX - 4);
                    $drawing3->setOffsetY(4);
                   
                   
                    // Tambahkan gambar ke worksheet
                    $drawing3->setWorksheet($event->sheet->getDelegate());
                   
                    // Sesuaikan tinggi baris jika diperlukan untuk gambar
                    $event->sheet->getRowDimension($rowIndex)->setRowHeight($newHeight+20); // Sesuaikan tinggi baris dengan tinggi gambar
                    // $event->sheet->getRowDimension($rowIndex)->setRowHeight(max($rowHeight, $drawing3->getHeight())); // Sesuaikan tinggi baris dengan tinggi gambar
                }


               


                if ($laporan->foto_penanggulangan != null) {
                    $imagePath2 = public_path("gambar/foto_penanggulangan/" . $laporan->foto_penanggulangan);
                    $rotatedImagePath = public_path("gambar/foto_penanggulangan/rotated_" . $laporan->foto_penanggulangan);
                    // $imagePath2 = public_path("gambar/foto_penanggulangan/" . $laporan->foto_penanggulangan);
                    $drawing4 = new Drawing();
                   
                    rotateImageIfLandscape($imagePath2, $rotatedImagePath);


                    // Set path gambar
                    $drawing4->setPath($rotatedImagePath);
                    $drawing4->setName('Foto penanggulangan');
                    $drawing4->setDescription('Foto penanggulangan');


                    // Tentukan ukuran maksimum gambar
                    $maxHeight = 1600;
                    $maxWidth = intval(720 * (45 / 180));


                    // Dapatkan dimensi gambar asli
                    list($originalWidth, $originalHeight) = getimagesize($rotatedImagePath);


                    // Hitung skala dan ukuran baru
                    $widthScale = $maxWidth / $originalWidth;
                    $heightScale = $maxHeight / $originalHeight;
                    $scale = min($widthScale, $heightScale);


                    $newWidth = $originalWidth * $scale;
                    $newHeight = $originalHeight * $scale;


                    // Set ukuran gambar
                    if($originalWidth < $originalHeight){
                        $drawing4->setHeight($newHeight+100);
                    }else{
                        $drawing4->setWidth(240);
                        // $drawing4->setHeight($newHeight);
                    }


                    // Dapatkan lebar kolom I dalam satuan default (karena lebar kolom dalam satuan karakter)
                    $columnWidthI = $event->sheet->getColumnDimension('I')->getWidth() * 7.2; // 1 karakter kira-kira 7.2 piksel
                    // Dapatkan tinggi baris dalam piksel
                    // $rowHeightI = $event->sheet->getRowDimension($rowIndex)->getRowHeight();
               
                    // Hitung posisi horizontal (X) untuk menengahkan gambar
                    $offsetX = ($columnWidthI - $drawing4->getWidth()) / 2;
                    // Hitung posisi vertikal (Y) untuk menengahkan gambar
                    // $offsetY = ($rowHeightI - $drawing4->getHeight()) / 2;
               
                    // Set posisi gambar di tengah kolom I
                    $drawing4->setOffsetX($offsetX);
                    $drawing4->setOffsetY(4);


                   
               
                    // Tentukan koordinat sel untuk menempatkan gambar
                    $drawing4->setCoordinates('I' . $rowIndex);
               
                    // Masukkan gambar ke worksheet
                    $drawing4->setWorksheet($event->sheet->getDelegate());
               
                    // Sesuaikan tinggi baris agar sesuai dengan gambar
                    $event->sheet->getRowDimension($rowIndex)->setRowHeight($newHeight+20); // Sesuaikan tinggi baris dengan gambar
                }
               
               
               
                if($laporan->progress >= 13 && $laporan->ACC_Dept_Head_EHS_At != null) {
                    $imagePath3 = $pathClosed; // Assuming foto_temuan contains the image path
                } else if ($laporan->progress >= 7.5 && $laporan->ACC_Dept_Head_EHS_At == null ) {
                    $imagePath3 = $path75;
                } else if ($laporan->progress < 7.5 && $laporan->progress >= 5 ) {
                    $imagePath3 = $path50;
                } else if ($laporan->progress < 5 && $laporan->progress >= 2.5 ) {
                    $imagePath3 = $path25;
                } else if ($laporan->progress < 2.5 && $laporan->deleted_at == null) {
                    $imagePath3 = $pathOpen;
                }else if ($laporan->deleted_at !== null) {
                    $imagePath3 = $pathCancel;
                }


                $drawing5 = new Drawing();
                $drawing5->setName('Foto penanggulangan');
                $drawing5->setDescription('Foto penanggulangan');
                $drawing5->setPath($imagePath3);
                $drawing5->setHeight(40); // adjust as needed
                $drawing5->setWidth(40); // adjust as needed
                // Dapatkan lebar kolom M
                $columnWidthM = $event->sheet->getColumnDimension('O')->getWidth();
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
                $drawing5->setCoordinates('O' . $rowIndex);
                $drawing5->setOffsetX($imageStartPosition); // Sesuaikan posisi gambar dengan posisi awal
                $drawing5->setOffsetY($imageVerticalStartPosition);
                $drawing5->setWorksheet($event->sheet->getDelegate());
                // $event->sheet->getRowDimension($rowIndex)->setRowHeight($newHeight);


                $event->sheet->getStyle('A' . $rowIndex . ':O' . $rowIndex)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $event->sheet->getStyle('A' . $rowIndex . ':O' . $rowIndex)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
                $event->sheet->getStyle('B'. $rowIndex)->getAlignment()->setTextRotation(90);
                $event->sheet->getStyle('C'. $rowIndex)->getAlignment()->setTextRotation(90);
                $event->sheet->getStyle('J'. $rowIndex)->getAlignment()->setTextRotation(90);
                $event->sheet->getStyle('L'. $rowIndex)->getAlignment()->setTextRotation(90);
                $event->sheet->getStyle('M'. $rowIndex)->getAlignment()->setTextRotation(90);
                $event->sheet->getStyle('N'. $rowIndex)->getAlignment()->setTextRotation(90);
                $event->sheet->getStyle('D' . $rowIndex)->getAlignment()->setWrapText(true);
                $event->sheet->getStyle('H' . $rowIndex)->getAlignment()->setWrapText(true);
                $event->sheet->getStyle('O' . $rowIndex)->getAlignment()->setWrapText(true);


                //  Add Border on Data
                $event->sheet->getStyle('A' . $rowIndex . ':O' . $rowIndex)->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => 'FF000000'],
                        ],
                    ],
                ]);


                // header tetap tiap page print
                $event->sheet->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(1, 5);


                // Move to the next row
                $rowIndex++;
               
            }


            // footer
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
        $drawing7->setPath($pathClosed);
        $drawing7->setHeight(50);
        $drawing7->setCoordinates('J'. ($rowIndex + 8));
        $drawing7->setOffsetX(-10);
        $drawing7->setWorksheet($event->sheet->getDelegate());
        $event->sheet->getCell('K'. ($rowIndex + 8))->setValue('CLOSE');
       
        $drawing8 = new Drawing();
        $drawing8->setName('Other image');
        $drawing8->setDescription('This is a second image');
        $drawing8->setPath($path25);
        $drawing8->setHeight(50);
        $drawing8->setCoordinates('G'. ($rowIndex + 11));
        $drawing8->setWorksheet($event->sheet->getDelegate());
        $event->sheet->getCell('H'. ($rowIndex + 11))->setValue('PROGRES 25%');




        $drawing9 = new Drawing();
        $drawing9->setName('Other image');
        $drawing9->setDescription('This is a second image');
        $drawing9->setPath($path50);
        $drawing9->setHeight(50);
        $drawing9->setCoordinates('H'. ($rowIndex + 8));
        $drawing9->setOffsetX(220);
        $drawing9->setWorksheet($event->sheet->getDelegate());
        $event->sheet->getCell('I'. ($rowIndex + 8))->setValue('PROGRES 50%');




        $drawing9 = new Drawing();
        $drawing9->setName('Other image');
        $drawing9->setDescription('This is a second image');
        $drawing9->setPath($path75);
        $drawing9->setHeight(50);
        $drawing9->setCoordinates('H'. ($rowIndex + 11));
        $drawing9->setOffsetX(220);
        $drawing9->setWorksheet($event->sheet->getDelegate());
        $event->sheet->getCell('I'. ($rowIndex + 11))->setValue('PROGRES 75%');
       
            },
        ];
    }


    public function startCell(): string {
        return 'A5';
    }
}


