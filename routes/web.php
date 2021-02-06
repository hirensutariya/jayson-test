<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;

use App\Http\Controllers\CountriesController;
use App\Http\Controllers\StateController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\DepartmentsController;
use App\Http\Controllers\EmployeesController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect()->route('backend.user.login');
});

Route::get('/login',[AuthController::class,'loginPage'])->name('backend.user.login');
Route::post('/login',[AuthController::class,'loginProccess'])->name('backend.user.login.process');

Route::group(['middleware' => ['auth','prevent-back-history']],function() {

     Route::get('/dashboard',[DashboardController::class,'index'])->name('backend.dashboard');

         /* System Managements */

         /* Countries Route */
         Route::resource('/countries',CountriesController::class);
         Route::post('/countries/getCountries',[CountriesController::class,'getCountries']);

         /* States Route */
         Route::resource('/states',StateController::class);
         Route::post('/states/getStates',[StateController::class,'getCountries']);
         Route::post('/states/getAllState',[StateController::class,'getCountryWiseStates']);

         /* Cities Route */
         Route::resource('/cities',CityController::class);
         Route::post('/cities/getCities',[CityController::class,'getCities']);
         /* Department Route */
         Route::resource('/departments',DepartmentsController::class);
         Route::post('/departments/getDepartments',[DepartmentsController::class,'getDepartments']);



         /* User Management */
         Route::resource('/user',UserController::class);
         Route::post('/user/getUsers',[UserController::class,'getUsers']);

         Route::get('/change_password',[UserController::class,'changePasswordPage'])->name('backend.user.change.password');
         Route::post('/change_password',[UserController::class,'changePasswordProcess'])->name('backend.user.change.password.process');

         Route::resource('/permission',PermissionController::class);
         Route::post('/permission/getPermissions',[PermissionController::class,'getPermissions']);

         Route::resource('/role',RoleController::class);
         Route::post('/role/getRoles',[RoleController::class,'getRoles']);

         Route::get('/employee/{any?}/{id?}',[EmployeesController::class,'index'])->name('backend.employee.index');


        Route::get('/logout',[AuthController::class,'logout'])->name('backend.user.logout');
});


Route::get('/superadmin', [UserController::class,'Permission']);
