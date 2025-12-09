<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class detail_departement extends Model
{
    use HasFactory;

    public function detail() {
        return $this->HasMany(department::class, 'departement_id');
    }

    public function user() {
        return $this->HasMany(user::class, 'detail_dept_id');
    }
}
