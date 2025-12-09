<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ChecksheetDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'checksheet_record_id',
        'checksheet_item_id',
        'check_status',
        'check_value',
        'remarks',
        'image_path',
    ];

    // Relationships
    public function record()
    {
        return $this->belongsTo(ChecksheetRecord::class, 'checksheet_record_id');
    }

    public function item()
    {
        return $this->belongsTo(ChecksheetItem::class, 'checksheet_item_id');
    }

    // Accessor untuk image URL
    public function getImageUrlAttribute()
    {
        if ($this->image_path) {
            return url('storage/' . $this->image_path);
        }
        return null;
    }

    // Scopes
    public function scopeByStatus($query, $status)
    {
        return $query->where('check_status', $status);
    }

    public function scopeAbnormal($query)
    {
        return $query->where('check_status', 'abnormal');
    }
}