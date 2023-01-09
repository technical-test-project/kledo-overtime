<?php

use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\OvertimeController;
use App\Http\Controllers\SettingController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::patch('settings', [SettingController::class, 'update']);
Route::post('employees', [EmployeeController::class, 'store']);
Route::post('overtimes', [OvertimeController::class, 'store']);
Route::get('overtime-pays/calculate', [OvertimeController::class, 'calculate']);
