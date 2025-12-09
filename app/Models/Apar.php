<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Apar extends Model
{
    use HasFactory;

    protected $table = 'apars';

    protected $fillable = [
        'kode_apar',
        'lokasi_apar',
        'jenis',
        'berat_kg',
        'expired_date',
    ];

    protected $casts = [
        'expired_date' => 'date',
        'berat_kg' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function pemeriksaanApars()
    {
        return $this->hasMany(PemeriksaanApar::class, 'apar_id', 'id');
    }

    public function latestCheck()
    {
        return $this->hasOne(PemeriksaanApar::class, 'apar_id')
                    ->latest('tanggal_pemeriksaan');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    // ACCESSOR: status
    public function getStatusAttribute(): string
    {
        $check = $this->latestCheck;

        if (!$check) {
            return 'unknown';
        }

        if ($check->expired_date) {
                $batasExpired = $check->expired_date->copy()->subMonths(2)->startOfDay();
                if (Carbon::today()->gte($batasExpired)) {
                    return 'expired'; // ← Mulai dianggap expired 2 bulan sebelumnya
                }
            }

        $ngFields = [
            'segitiga_dua_arah','segitiga_apar','pin_pengaman','segel',
            'selang','nozzle','badan_tabung','handle','label_apar',
            'akses_apar','layout','nomor_apar'
        ];

        foreach ($ngFields as $field) {
            if ($check->$field === 'NG') {
                return 'ng';
            }
        }

        return 'ok';
    }
}