<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class AparResource extends JsonResource
{
    public function toArray($request)
    {
        $latestCheck = $this->latestCheck;
        
        return [
            'id' => $this->id,
            'kode_apar' => $this->kode_apar,
            'lokasi_apar' => $this->lokasi_apar,
            'jenis' => $this->jenis,
            'berat_kg' => $this->berat_kg,
           'expired_date' => $this->expired_date 
                ? $this->expired_date->format('Y-m-d')
                : ($latestCheck && $latestCheck->expired_date 
                    ? $latestCheck->expired_date->format('Y-m-d') 
                    : null),
            'nomor' => $this->nomor ?? null,
            'area_id' => $this->area_id ?? null,
            
            // Status computation
            'status' => $this->status,
            'is_checked' => $this->is_checked ?? false,
            'last_checked' => $this->last_checked ? Carbon::parse($this->last_checked)->format('Y-m-d H:i:s') : null,
            
            // Latest check info
            'latest_check' => $latestCheck ? [
                'id' => $latestCheck->id,
                'checker' => $latestCheck->checker,
                'tanggal_pemeriksaan' => $latestCheck->tanggal_pemeriksaan->format('Y-m-d'),
                
                'expired_date' => $latestCheck->expired_date 
                    ? $latestCheck->expired_date->format('Y-m-d') 
                    : null,
                
                'manufacturing_date' => $latestCheck->manufacturing_date 
                    ? $latestCheck->manufacturing_date->format('Y-m-d') 
                    : null,
                
                'status' => $latestCheck->status,
                'is_near_expired' => $latestCheck->is_near_expired,
                'catatan_lainnya' => $latestCheck->catatan_lainnya,
            ] : null,
            
            'created_at' => $this->created_at ? $this->created_at->format('Y-m-d H:i:s') : null,
            'updated_at' => $this->updated_at ? $this->updated_at->format('Y-m-d H:i:s') : null,
        ];
    }
}