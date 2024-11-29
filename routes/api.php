<?php

use App\Http\Controllers\Api;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function () {
    Route::post('/login', [Api\AuthController::class, 'login'])
        ->name('auth.login');

    Route::post('/logout', [Api\AuthController::class, 'logout'])
        ->name('auth.logout');

    Route::post('/refresh', [Api\AuthController::class, 'refresh'])
        ->name('auth.refresh');
});

Route::prefix('companies')->group(function () {
    Route::get('/', [Api\CompanyController::class, 'index'])
        ->name('company.index')
        ->can('viewAny', App\Models\Company::class);

    Route::post('/', [Api\CompanyController::class, 'store'])
        ->name('company.store')
        ->can('create', App\Models\Company::class);

    Route::delete('/{company}', [Api\CompanyController::class, 'destroy'])
        ->name('company.destroy')
        ->can('delete', 'company');
});

Route::prefix('employees')->group(function () {
    Route::get('/', [Api\EmployeeController::class, 'index'])
        ->name('employee.index')
        ->can('viewAny', App\Models\Employee::class);

    Route::post('/', [Api\EmployeeController::class, 'store'])
        ->name('employee.store')
        ->can('create', App\Models\Employee::class);

    Route::get('/{employee}', [Api\EmployeeController::class, 'show'])
        ->name('employee.show')
        ->can('view', 'employee');

    Route::put('/{employee}', [Api\EmployeeController::class, 'update'])
        ->name('employee.update')
        ->can('update', 'employee');

    Route::delete('/{employee}', [Api\EmployeeController::class, 'destroy'])
        ->name('employee.destroy')
        ->can('delete', 'employee');
});

Route::prefix('myprofile')->group(function () {
    Route::get('/', [Api\UserController::class, 'index'])
        ->name('profile.show');

    Route::put('/', [Api\UserController::class, 'update'])
        ->name('profile.update');
});
