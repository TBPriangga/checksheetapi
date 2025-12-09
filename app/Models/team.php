<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class team extends Model
{
    use HasFactory;
    protected $guarded = [
        'id'
    ];    

    public function user() {
        return $this->hasMany(team_member::class, 'team_id');
    }

    public function genba_member() {
        return $this->hasMany(genba::class, 'team_id');
    }
}
