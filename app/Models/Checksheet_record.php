<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ChecksheetRecord extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'machine_id',
        'checksheet_type_id',
        'user_id',
        'leader_id',
        'foreman_id',
        'supervisor_id',
        'check_date',
        'check_day',
        'check_month',
        'check_year',
        'work_hours',
        'status',
        'notes',
        'technician_notes',
        'submitted_at',
        'approved_at',
    ];

    protected $casts = [
        'check_date' => 'date',
        'check_day' => 'integer',
        'check_month' => 'integer',
        'check_year' => 'integer',
        'work_hours' => 'decimal:2',
        'submitted_at' => 'datetime',
        'approved_at' => 'datetime',
    ];

    // Relationships
    public function machine()
    {
        return $this->belongsTo(Machine::class);
    }

    public function checksheetType()
    {
        return $this->belongsTo(ChecksheetType::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function leader()
    {
        return $this->belongsTo(User::class, 'leader_id');
    }

    public function foreman()
    {
        return $this->belongsTo(User::class, 'foreman_id');
    }

    public function supervisor()
    {
        return $this->belongsTo(User::class, 'supervisor_id');
    }

    public function details()
    {
        return $this->hasMany(ChecksheetDetail::class);
    }

    // Scopes
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function scopeByMachine($query, $machineId)
    {
        return $query->where('machine_id', $machineId);
    }

    public function scopeByType($query, $typeId)
    {
        return $query->where('checksheet_type_id', $typeId);
    }

    public function scopeByPeriod($query, $year, $month = null)
    {
        $query->where('check_year', $year);
        if ($month) {
            $query->where('check_month', $month);
        }
        return $query;
    }

    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }
}