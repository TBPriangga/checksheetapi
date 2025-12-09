<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ChecksheetType;
use App\Models\ChecksheetItem;

class ChecksheetSeeder extends Seeder
{
    public function run()
    {
        // ==========================================
        // CHECKSHEET HARIAN (DAILY)
        // ==========================================
        $dailyType = ChecksheetType::create([
            'code' => 'daily',
            'name' => 'Checksheet Harian',
            'description' => 'Checksheet pemeriksaan harian untuk Hydrant System',
            'is_active' => true,
        ]);

        $dailyItems = [
            [
                'item_number' => 1,
                'item_name' => 'Pressure Tank',
                'check_method' => 'Catat pressure tank dengan melihat pada pressure gauge yang ada',
                'standard' => '6 - 8 Bar',
                'tool' => 'Pressure Gauge',
            ],
            [
                'item_number' => 2,
                'item_name' => 'Motor Pump - Bearing',
                'check_method' => 'Bearing masih dalam kondisi baik',
                'standard' => 'Baik',
                'tool' => 'Visual',
            ],
            [
                'item_number' => 2,
                'item_name' => 'Motor Pump - Bahan Bakar',
                'check_method' => 'Periksa Bahan Bakar, pastikan masih ada',
                'standard' => 'middle - up',
                'tool' => 'Visual',
            ],
            [
                'item_number' => 2,
                'item_name' => 'Motor Pump - Tegangan Accu',
                'check_method' => 'Periksa tegangan Accu Stater',
                'standard' => 'minimal 24 VDC',
                'tool' => 'Multimeter',
            ],
            [
                'item_number' => 3,
                'item_name' => 'Diesel Pump - Air Accu',
                'check_method' => 'Periksa level air Accu Stater',
                'standard' => 'middle - up',
                'tool' => 'Visual',
            ],
            [
                'item_number' => 3,
                'item_name' => 'Diesel Pump - Oli Mesin',
                'check_method' => 'Periksa Oli mesin diesel',
                'standard' => 'middle - up',
                'tool' => 'Visual',
            ],
            [
                'item_number' => 3,
                'item_name' => 'Diesel Pump - Kondisi Air Radiator',
                'check_method' => 'Periksa kondisi air radiator',
                'standard' => 'full',
                'tool' => 'Visual',
            ],
        ];

        foreach ($dailyItems as $index => $item) {
            ChecksheetItem::create([
                'checksheet_type_id' => $dailyType->id,
                'item_number' => $item['item_number'],
                'item_name' => $item['item_name'],
                'check_method' => $item['check_method'],
                'standard' => $item['standard'],
                'tool' => $item['tool'],
                'is_active' => true,
                'sort_order' => $index + 1,
            ]);
        }

        // ==========================================
        // CHECKSHEET 6 BULANAN (6M)
        // ==========================================
        $sixMonthType = ChecksheetType::create([
            'code' => '6m',
            'name' => 'Maintenance 6 Bulanan',
            'description' => 'Maintenance periode 6 bulanan untuk Hydrant Diesel',
            'is_active' => true,
        ]);

        $sixMonthItems = [
            [
                'item_number' => 1,
                'item_name' => 'V-Belt Radiator',
                'check_method' => 'Cek kekencangan dan kondisi v-belt',
                'standard' => 'Tidak retak & Toleransi 8 – 12 mm',
                'tool' => null,
            ],
            [
                'item_number' => 2,
                'item_name' => 'V-Belt Alternator',
                'check_method' => 'Cek kekencangan dan kondisi v-belt',
                'standard' => 'Tidak retak & Toleransi 8 – 12 mm',
                'tool' => null,
            ],
            [
                'item_number' => 3,
                'item_name' => 'Setelan Gas',
                'check_method' => 'Visual cek',
                'standard' => 'Normal / tidak kendur',
                'tool' => null,
            ],
            [
                'item_number' => 4,
                'item_name' => 'Level Oli',
                'check_method' => 'Visual cek',
                'standard' => 'Antara Upper-lower',
                'tool' => null,
            ],
            [
                'item_number' => 5,
                'item_name' => 'Tekanan Oli',
                'check_method' => 'Visual',
                'standard' => '3 – 4 kg/cm2 di rpm 1400',
                'tool' => null,
            ],
            [
                'item_number' => 6,
                'item_name' => 'Filter Udara',
                'check_method' => 'Buka dan bersihkan',
                'standard' => 'Bersih',
                'tool' => null,
            ],
            [
                'item_number' => 7,
                'item_name' => 'Drain tangki solar',
                'check_method' => 'Pengamatan',
                'standard' => 'Tidak tercampur air',
                'tool' => null,
            ],
            [
                'item_number' => 8,
                'item_name' => 'Klem selang solar all',
                'check_method' => 'Dekencangkan',
                'standard' => 'Kencang',
                'tool' => null,
            ],
            [
                'item_number' => 9,
                'item_name' => 'Strainer solar',
                'check_method' => 'Buka & bersihkan',
                'standard' => 'Bersih & air terbuang',
                'tool' => null,
            ],
            [
                'item_number' => 10,
                'item_name' => 'Copling',
                'check_method' => 'Visual cek',
                'standard' => 'Normal / tidak rusak / longgar',
                'tool' => null,
            ],
            [
                'item_number' => 11,
                'item_name' => 'Pompa Impeler - Glain Pakking',
                'check_method' => 'Visual cek',
                'standard' => 'Tidak bocor',
                'tool' => null,
            ],
            [
                'item_number' => 12,
                'item_name' => 'Pompa Impeler - Suara',
                'check_method' => 'Visual cek',
                'standard' => 'Normal / tidak kasar',
                'tool' => null,
            ],
            [
                'item_number' => 13,
                'item_name' => 'Pompa Impeler - Pressure',
                'check_method' => 'Visual cek',
                'standard' => 'Sesuai settingan',
                'tool' => null,
            ],
            [
                'item_number' => 14,
                'item_name' => 'Jam kerja',
                'check_method' => 'Pengecekan',
                'standard' => 'Dicatat',
                'tool' => null,
            ],
            [
                'item_number' => 15,
                'item_name' => 'Body mesin',
                'check_method' => 'Dibersihkan',
                'standard' => 'Bersih',
                'tool' => null,
            ],
            [
                'item_number' => 16,
                'item_name' => 'Kebersihan area',
                'check_method' => 'Pel & sapu',
                'standard' => 'Bersih',
                'tool' => null,
            ],
        ];

        foreach ($sixMonthItems as $index => $item) {
            ChecksheetItem::create([
                'checksheet_type_id' => $sixMonthType->id,
                'item_number' => $item['item_number'],
                'item_name' => $item['item_name'],
                'check_method' => $item['check_method'],
                'standard' => $item['standard'],
                'tool' => $item['tool'],
                'is_active' => true,
                'sort_order' => $index + 1,
            ]);
        }

        // ==========================================
        // CHECKSHEET 12 BULANAN (12M)
        // ==========================================
        $twelveMonthType = ChecksheetType::create([
            'code' => '12m',
            'name' => 'Maintenance 12 Bulanan',
            'description' => 'Maintenance periode 12 bulanan untuk Hydrant Diesel',
            'is_active' => true,
        ]);

        $twelveMonthItems = [
            [
                'item_number' => 1,
                'item_name' => 'Oli mesin',
                'check_method' => 'Kuras & ganti baru',
                'standard' => 'Oli baru (10 liter Meditran 40)',
                'tool' => null,
            ],
            [
                'item_number' => 2,
                'item_name' => 'Filter Oli',
                'check_method' => 'Lepas & ganti',
                'standard' => 'Filter baru 2 Pcs',
                'tool' => null,
            ],
            [
                'item_number' => 3,
                'item_name' => 'Bearing',
                'check_method' => 'Greasing',
                'standard' => 'Basah grease',
                'tool' => null,
            ],
            [
                'item_number' => 4,
                'item_name' => 'Fiter air radiator',
                'check_method' => 'Bersihkan',
                'standard' => 'Bersih',
                'tool' => null,
            ],
            [
                'item_number' => 5,
                'item_name' => 'Radiator',
                'check_method' => 'Bersihkan',
                'standard' => 'Bersih',
                'tool' => null,
            ],
            [
                'item_number' => 6,
                'item_name' => 'Baut fan radiator',
                'check_method' => 'Cek',
                'standard' => 'Baut kencang',
                'tool' => null,
            ],
            [
                'item_number' => 7,
                'item_name' => 'Fan radiator',
                'check_method' => 'Bersihkan',
                'standard' => 'Bersih',
                'tool' => null,
            ],
            [
                'item_number' => 8,
                'item_name' => 'Air radiator',
                'check_method' => 'Kuras & ganti baru',
                'standard' => 'Air bersih/baru & campur chemical anti karat (50 ltr)',
                'tool' => null,
            ],
            [
                'item_number' => 9,
                'item_name' => 'Filter solar',
                'check_method' => 'Lepas & ganti baru',
                'standard' => 'Baru (1pcs)',
                'tool' => null,
            ],
            [
                'item_number' => 10,
                'item_name' => 'Strainer solar',
                'check_method' => 'Buka & bersihkan',
                'standard' => 'Bersih & air terbuang',
                'tool' => null,
            ],
            [
                'item_number' => 11,
                'item_name' => 'Regulator solar',
                'check_method' => 'Visual check',
                'standard' => 'Normal',
                'tool' => null,
            ],
            [
                'item_number' => 12,
                'item_name' => 'Jam kerja',
                'check_method' => 'Pengamatan',
                'standard' => 'Dicatat',
                'tool' => null,
            ],
            [
                'item_number' => 13,
                'item_name' => 'Body mesin',
                'check_method' => 'Bersihkan',
                'standard' => 'Bersih',
                'tool' => null,
            ],
            [
                'item_number' => 14,
                'item_name' => 'Kebersihan area',
                'check_method' => 'Pel & sapu',
                'standard' => 'Bersih',
                'tool' => null,
            ],
        ];

        foreach ($twelveMonthItems as $index => $item) {
            ChecksheetItem::create([
                'checksheet_type_id' => $twelveMonthType->id,
                'item_number' => $item['item_number'],
                'item_name' => $item['item_name'],
                'check_method' => $item['check_method'],
                'standard' => $item['standard'],
                'tool' => $item['tool'],
                'is_active' => true,
                'sort_order' => $index + 1,
            ]);
        }

        $this->command->info('Checksheet data seeded successfully!');
    }
}