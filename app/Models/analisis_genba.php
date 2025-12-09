<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class analisis_genba extends Model
{
    use HasFactory;
    protected $guarded = [
        'id'
    ];  

    public function analisis()
    {
        return $this->hasOne(genba::class);
    }
}
