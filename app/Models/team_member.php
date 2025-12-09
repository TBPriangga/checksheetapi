<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class team_member extends Model
{
    use HasFactory;
    protected $guarded = [
        'id'
    ]; 
    
    public function user() {
        return $this->belongsTo(user::class, 'user_id');
    }
    public function team() {
        return $this->belongsTo(team::class, 'team_id');
    }
}
