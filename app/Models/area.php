<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class area extends Model
{
    use HasFactory;
    protected $guarded = [
        'id'
    ];  

    public function laporan() {
        return $this->hasMany(laporan::class, 'area_id');
    }

    public function area() {
        return $this->hasMany(user_has_area::class, 'area_id');
    }

    public function genba_area() {
        return $this->hasMany(genba::class, 'area_id');
    }
    public function area_patrol() {
        return $this->hasMany(genba::class, 'area_id');
    }
    public function area_log() {
        return $this->hasMany(area::class, 'area_id');
    }
}
