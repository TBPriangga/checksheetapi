<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PemeriksaanAparResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'apar_id' => $this->apar_id,
            'jenis' => $this->jenis,
            'checker' => $this->checker,
            
            // Check points
            'segitiga_dua_arah' => $this->segitiga_dua_arah,
            'segitiga_apar' => $this->segitiga_apar,
            'nomor_apar' => $this->nomor_apar,
            'pin_pengaman' => $this->pin_pengaman,
            'segel' => $this->segel,
            'selang' => $this->selang,
            'nozzle' => $this->nozzle,
            'badan_tabung' => $this->badan_tabung,
            'handle' => $this->handle,
            'label_apar' => $this->label_apar,
            'akses_apar' => $this->akses_apar,
            'layout' => $this->layout,
            
            // Dates
            'expired_date' => $this->expired_date ? $this->expired_date->format('Y-m-d') : null,
            'manufacturing_date' => $this->manufacturing_date ? $this->manufacturing_date->format('Y-m-d') : null,
            'tanggal_pemeriksaan' => $this->tanggal_pemeriksaan ? $this->tanggal_pemeriksaan->format('Y-m-d') : null,
            
            // CO2 specific
            'berat_gross' => $this->jenis === 'CO2' ? (float) $this->berat_gross : null,
            'berat_saat_cek' => $this->jenis === 'CO2' ? (float) $this->berat_saat_cek : null,
            'selisih_berat' => $this->jenis === 'CO2' ? (float) $this->selisih_berat : null,
            
            // Non-CO2 specific
            'preassure' => $this->jenis !== 'CO2' ? $this->preassure : null,
            'dikocok' => $this->jenis !== 'CO2' ? $this->dikocok : null,
            
            'catatan_lainnya' => $this->catatan_lainnya,
            
            // Status
            'status' => $this->status,
            'is_near_expired' => $this->is_near_expired,
            'main_status_label' => $this->main_status_label,
            'main_status_color' => $this->main_status_color,
            
            // APAR info (jika loaded)
            'apar' => $this->whenLoaded('apar', function() {
                return [
                    'id' => $this->apar->id,
                    'kode_apar' => $this->apar->kode_apar,
                    'lokasi_apar' => $this->apar->lokasi_apar,
                    'jenis' => $this->apar->jenis,
                ];
            }),
            
            'created_at' => $this->created_at ? $this->created_at->format('Y-m-d H:i:s') : null,
        ];
    }
}