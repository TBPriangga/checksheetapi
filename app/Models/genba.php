<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class genba extends Model
{
    use HasFactory;
    protected $guarded = [
        'id'
    ];   

    public function genba_area() {
        return $this->belongsTo(area::class, 'area_id');
    } 

    public function team() {
        return $this->belongsTo(team::class, 'team_id');
    } 

    public function PIC_auditor() {
        return $this->belongsTo(user::class, 'pic_auditor_id');
    } 
    
    public function detail() {
        return $this->hasMany(genba_detail::class, 'genba_id');
    }

    public function laporan_genba() {
        return $this->hasMany(laporan::class, 'genba_id');
    }
}
