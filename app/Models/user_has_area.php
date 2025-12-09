<?php

namespace App\Models;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class user_has_area extends Model
{
    use HasFactory;
    protected $guarded = [
        'id'
    ];  

    public function area() {
        return $this->belongsTo(area::class, 'area_id');
    }
    public function User() {
        return $this->belongsTo(User::class, 'user_id');
    }
    
}
