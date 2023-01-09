<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $table    = 'employees';
    protected $guarded  = ['id'];

    public function overtimes()
    {
        return $this->hasMany(Overtime::class, 'employee_id', 'id');
    }

    public function getDateAttribute()
    {
        return Carbon::parse($this->date);
    }

    public function getAmountAttribute()
    {
        $expression = Setting::with('reference')->get()[0]->reference->expression;

        if($expression == '(salary / 173) * overtime_duration_total'){
            $preg = preg_replace('/salary/i', $this->salary, $expression);
            $preg = preg_replace('/overtime_duration_total/i', $this->overtimes->sum('overtime_duration'), $preg);
        } else {
            $preg = preg_replace('/overtime_duration_total/i', $this->overtimes->sum('overtime_duration'), $expression);
        }
        $reg = preg_replace("%[^-+*/0-9 ]+%", '', $preg);

        return round(eval("return $reg;")) ?? 0;
    }
}
