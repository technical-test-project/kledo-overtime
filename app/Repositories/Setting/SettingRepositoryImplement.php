<?php

namespace App\Repositories\Setting;
use Illuminate\Http\Request;
use App\Models\Setting;

class SettingRepositoryImplement implements SettingRepository
{
    private Setting $model;

    public function __construct(Setting $model)
    {
        $this->model = $model;
    }

    public function updateSetting(Request $request): object
    {
        $setting = $this->model->first();
        $setting->update([
            'key' => $request->key ?? $setting->key,
            'value' => $request->value ?? $setting->value,
        ]);

        return arrayToObject(
            'Data setting berhasil diupdate',
            200,
            $setting
        );
    }
}
