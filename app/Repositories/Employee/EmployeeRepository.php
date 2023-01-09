<?php

namespace App\Repositories\Employee;

use Illuminate\Http\Request;

interface EmployeeRepository
{
    public function store(Request $request);
}
