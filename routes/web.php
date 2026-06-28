<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\UserJobController;
use App\Http\Controllers\Admin\AppealController;
use App\Http\Controllers\Employer\JobController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {

    // Admin Home
    Route::get('/home', [HomeController::class, 'index'])
        ->name('home');

    /*
    |--------------------------------------------------------------------------
    | Role Management
    |--------------------------------------------------------------------------
    */
    Route::get('/roles', [RoleController::class, 'index'])->name('roles.index');
    Route::get('/roles/create', [RoleController::class, 'create'])->name('roles.create');
    Route::post('/roles', [RoleController::class, 'store'])->name('roles.store');
    Route::get('/roles/{role}', [RoleController::class, 'show'])->name('roles.show');
    Route::get('/roles/{role}/edit', [RoleController::class, 'edit'])->name('roles.edit');
    Route::put('/roles/{role}', [RoleController::class, 'update'])->name('roles.update');
    Route::delete('/roles/{role}', [RoleController::class, 'destroy'])->name('roles.destroy');

    /*
    |--------------------------------------------------------------------------
    | User Management
    |--------------------------------------------------------------------------
    */
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');

    Route::get('/jobs', [UserJobController::class, 'index'])->name('jobs.index');
    Route::get('/jobs/{job}', [UserJobController::class, 'show'])->name('jobs.show');
    Route::delete('/jobs/{job}', [UserJobController::class, 'destroy'])->name('jobs.destroy');

    Route::get('/appeals', [AppealController::class, 'index'])->name('appeals.index');
    Route::get('/appeals/{appeal}', [AppealController::class, 'show'])->name('appeals.show');
    Route::put('/appeals/{appeal}', [AppealController::class, 'update'])->name('appeals.update');
});

// Protect the routes using standard authentication middleware
Route::middleware(['auth'])->prefix('employer')->name('employer.')->group(function () {
    
    // Form to create a new job vacancy listing
    Route::get('/jobs/create', [JobController::class, 'create'])->name('jobs.create');
    
    // Endpoint processing the form submission & communicating with the Flask ML microservice
    Route::post('/jobs', [JobController::class, 'store'])->name('jobs.store');
    
});