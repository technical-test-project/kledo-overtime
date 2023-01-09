<?php

namespace App\Providers;

use App\Repositories\Employee\EmployeeRepository;
use App\Repositories\Employee\EmployeeRepositoryImplement;
use App\Repositories\Overtime\OvertimeRepository;
use App\Repositories\Overtime\OvertimeRepositoryImplement;
use App\Repositories\Setting\SettingRepository;
use App\Repositories\Setting\SettingRepositoryImplement;
use Illuminate\Support\ServiceProvider;
use L5Swagger\L5SwaggerServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(L5SwaggerServiceProvider::class);
        $this->app->bind(SettingRepository::class, SettingRepositoryImplement::class);
        $this->app->bind(EmployeeRepository::class, EmployeeRepositoryImplement::class);
        $this->app->bind(OvertimeRepository::class, OvertimeRepositoryImplement::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
