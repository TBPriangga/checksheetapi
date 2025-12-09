<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class department extends Model
{
    use HasFactory;

    public function detail() {
        return $this->belongsTo(detail_departement::class, 'departement_id');
    }

    public function user() {
        return $this->HasMany(user::class, 'dept_id');
    }
}
