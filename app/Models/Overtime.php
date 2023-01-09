<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Overtime extends Model
{
    use HasFactory;

    protected $table    = 'overtimes';
    protected $guarded  = ['id'];

    public function employee(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Employee::class, 'employee_id', 'id');
    }

    public function getOvertimeDurationAttribute(): float
    {
        return round((Carbon::parse($this->time_ended)->unix() - Carbon::parse($this->time_started)->unix() ) / 3600);
    }
}
