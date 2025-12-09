<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class genba_detail extends Model
{
    use HasFactory;
    protected $guarded = [
        'id'
    ];

    public function genba_member() {
        return $this->belongsTo(user::class, 'user_id');
    } 

    public function detail() {
        return $this->belongsTo(genba::class, 'genba_id');
    } 

    public function genba_nilai()
    {
        
        return $this->belongsTo(penilaian::class, 'penilaian_id');
        
    }

}
