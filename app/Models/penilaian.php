<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class penilaian extends Model
{
    use HasFactory;
    protected $guarded = [
        'id'
    ];   
    
    public function genba_nilai()
    {
        return $this->hasOne(genba_detail::class);
    }
}
