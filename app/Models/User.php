<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;


class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'npk', 'username', 'dept_id', 'position_id', 'detail_dept_id', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function auditor() {
        return $this->hasMany(laporan::class, 'auditor_id');
    }

    public function PIC() {
        return $this->hasMany(laporan::class, 'PIC_id');
    }

    public function dept_PIC() {
        return $this->hasMany(laporan::class, 'dept_pic_id');
    }

    public function dept_EHS() {
        return $this->hasMany(laporan::class, 'dept_ehs_id');
    }

    public function area() {
        return $this->hasMany(user_has_area::class, 'user_id');
    }

    public function team() {
        return $this->hasMany(team_member::class, 'user_id');
    }

    public function department() {
        return $this->belongsTo(department::class, 'dept_id');
    }

    public function detail() {
        return $this->belongsTo(detail_departement::class, 'detail_dept_id');
    }

    public function position() {
        return $this->belongsTo(position::class, 'position_id');
    }

    public function genba_member() {
        return $this->hasMany(genba_detail::class, 'user_id');
    }

    public function PIC_auditor() {
        return $this->hasMany(genba::class, 'pic_auditor_id');
    }

    public function auditor_log() {
        return $this->hasMany(activity_log::class, 'auditor_id');
    }

    public function user_log() {
        return $this->hasMany(activity_log::class, 'auditor_id');
    }
}
