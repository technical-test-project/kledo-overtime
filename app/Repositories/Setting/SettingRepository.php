<?php

namespace App\Repositories\Setting;

use Illuminate\Http\Request;

interface SettingRepository
{
    public function updateSetting(Request $request);
}
