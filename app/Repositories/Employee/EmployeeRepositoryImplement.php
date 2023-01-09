<?php

namespace App\Repositories\Employee;

use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeRepositoryImplement implements EmployeeRepository
{
    private Employee $model;

    public function __construct(Employee $model)
    {
        $this->model = $model;
    }

    public function store(Request $request): object
    {
        return arrayToObject(
            'Data Employee berhasil dibuat',
            201,
            $this->model->create([
                'name' => $request->name,
                'salary' => $request->salary,
            ])
        );
    }
}
