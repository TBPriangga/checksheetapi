<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ehs_patrol extends Model
{
    use HasFactory;
    protected $guarded = [
        'id'
    ];   
        
    public function laporan_patrol()
    {
        return $this->hasMany(laporan::class, 'patrol_id');
    }

    public function area_patrol() {
        return $this->belongsTo(area::class, 'area_id');
    } 

    public function temuan() {
        return $this->hasMany(laporan::class, 'patrol_id');
    }
    public function area()
    {
        return $this->belongsTo(area::class, 'area_id');
    }

    
}
