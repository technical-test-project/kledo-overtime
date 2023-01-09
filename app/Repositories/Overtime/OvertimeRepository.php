<?php

namespace App\Repositories\Overtime;

use Illuminate\Http\Request;

interface OvertimeRepository
{
    public function store(Request $request);

    public function calculate(Request $request);
}
