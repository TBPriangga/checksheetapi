<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class PemeriksaanApar extends Model
{
    use HasFactory;

    protected $table = 'pemeriksaan_apars';

    protected $fillable = [
        'apar_id','jenis','checker','segitiga_dua_arah','segitiga_apar','nomor_apar',
        'pin_pengaman','segel','selang','nozzle','badan_tabung','handle','label_apar',
        'expired_date','berat_gross','berat_saat_cek','selisih_berat','preassure',
        'akses_apar','layout','dikocok','manufacturing_date','catatan_lainnya',
        'tanggal_pemeriksaan','created_at',
    ];

    protected $casts = [
        'expired_date'        => 'date',
        'manufacturing_date'  => 'date',
        'tanggal_pemeriksaan'=> 'date',
        'berat_gross'         => 'decimal:2',
        'berat_saat_cek'      => 'decimal:2',
        'selisih_berat'       => 'decimal:2',
        'created_at'          => 'datetime',
    ];

    public $timestamps = false;

    public function apar()
    {
        return $this->belongsTo(Apar::class, 'apar_id');
    }

    public function getStatusAttribute(): string
    {
        $ngFields = [
            'segitiga_dua_arah','segitiga_apar','nomor_apar','pin_pengaman',
            'segel','selang','nozzle','badan_tabung','handle','label_apar',
            'akses_apar','layout'
        ];

        foreach ($ngFields as $field) {
            if ($this->$field === 'NG') {
                return 'need_attention';
            }
        }

        if ($this->jenis !== 'CO2') {
            if ($this->preassure === 'NG' || $this->dikocok === 'NG') {
                return 'need_attention';
            }
        }

        return 'inspected'; // Hanya OK atau NG, expired dipisah
    }

    public function getIsNearExpiredAttribute(): bool
    {
        if (!$this->expired_date) {
            return false;
        }

        $expired     = Carbon::parse($this->expired_date)->startOfDay();
        $warningDate = $expired->copy()->subMonths(2)->startOfDay();

        return now()->startOfDay()->gte($warningDate);
    }

    public function getMainStatusLabelAttribute(): string
    {
        return $this->status === 'inspected' ? 'OK' : 'NG';
    }

    public function getMainStatusColorAttribute(): string
    {
        return $this->status === 'inspected' ? 'success' : 'warning';
    }

}