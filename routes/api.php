<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\EmployeesController;
use App\Http\Controllers\DepartmentsController;
use App\Http\Controllers\CountriesController;
use App\Http\Controllers\StateController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\API\AuthController;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::resource('employee', EmployeesController::class);
Route::get('getallemployee',[EmployeesController::class,'getAllEmployee']);

Route::get('departments', [DepartmentsController::class,'apiGetDepartments']);
Route::get('countries', [CountriesController::class,'apiGetCountries']);
Route::get('states/{country_id}', [StateController::class,'apiGetStates']);
Route::get('cities/{state_id}', [CityController::class,'apiGetCities']);

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

