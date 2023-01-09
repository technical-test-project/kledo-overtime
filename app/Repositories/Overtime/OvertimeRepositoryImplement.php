<?php

namespace App\Repositories\Overtime;

use App\Models\Employee;
use App\Models\Overtime;
use Carbon\Carbon;
use Illuminate\Http\Request;

class OvertimeRepositoryImplement implements OvertimeRepository
{
    private Overtime $model;

    public function __construct(Overtime $model)
    {
        $this->model = $model;
    }

    /**
     * @param Request $request
     * @return object
     */
    public function store(Request $request): object
    {
        $overtime = $this->model->create([
            'employee_id'   => $request->employee_id,
            'date'          => $request->date,
            'time_started'  => $request->time_started,
            'time_ended'    => $request->time_ended,
        ]);

        return arrayToObject(
            'Data Overtime berhasil dibuat',
            201,
            $overtime
        );
    }

    /**
     * @param Request $request
     * @return object
     */
    public function calculate(Request $request): object
    {
        $query = $request->query('month');

        $employees = Employee::with(['overtimes'])
            ->when($query != null, function ($q) use($query){
                $q ->whereHas('overtimes', function ($q) use($query){
                    $q->whereYear('date', Carbon::parse($query)->year)
                        ->whereMonth('date', Carbon::parse($query)->month);
                });
            })
            ->get()
            ->map(function ($employee){
                return [
                    'id'        => $employee->id,
                    'name'      => $employee->name,
                    'salary'    => $employee->salary,
                    'overtimes' => $employee->overtimes->map(function ($overtime){
                        return [
                          'id'          => $overtime->id,
                          'date'        => $overtime->date,
                          'time_started' => $overtime->time_started,
                          'time_ended'  => $overtime->time_ended,
                          'overtime_duration' => "$overtime->overtime_duration Jam"
                        ];
                    }),
                    'overtime_duration_total' => $employee->overtimes->sum('overtime_duration'),
                    'amount' => $employee->amount,
            ];
        });


        return arrayToObject(
            'OK',
            200,
            $employees
        );
    }
}
