<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class activity_log extends Model
{
    use HasFactory;
    protected $guarded = [
        'id'
    ];  

    public function area_log() {
        return $this->belongsTo(area::class, 'area_id');
    }

    public function auditor_log() {
        return $this->belongsTo(user::class, 'auditor_id');
    }

    public function user_log() {
        return $this->belongsTo(user::class, 'user_id');
    }
    
    public function laporan_log() {
        return $this->belongsTo(laporan::class, 'laporan_id');
    }
}
