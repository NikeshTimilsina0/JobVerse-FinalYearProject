<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\UserJobController;
use App\Http\Controllers\Admin\AppealController;
use App\Http\Controllers\Employer\JobController;

use App\Http\Controllers\Employer\EmployerDashboardController;
use App\Http\Controllers\Employer\EmployerJobController;
use App\Http\Controllers\Employer\EmployerApplicationController;
use App\Http\Controllers\Employer\EmployerAppealController;
use App\Http\Controllers\Candidate\JobFeedController;
use App\Http\Controllers\Candidate\JobApplicationController;
use App\Http\Controllers\Candidate\ProfileController;
use App\Http\Controllers\Employer\EmployerProfileController;
/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/



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


Route::middleware(['auth', 'role:Employer'])
    ->prefix('employer')
    ->name('employer.')
    ->group(function () {

        // Command Center Terminal
        Route::get('/dashboard', [EmployerDashboardController::class, 'index'])->name('dashboard');

        // Job Vacancy Management Pipeline
        Route::get('/jobs', [EmployerJobController::class, 'index'])->name('jobs.index');
        Route::get('/jobs/create', [EmployerJobController::class, 'create'])->name('jobs.create');
        Route::post('/jobs', [EmployerJobController::class, 'store'])->name('jobs.store');

        // Applicant Lifecycle Pipeline
        Route::get('/applications', [EmployerApplicationController::class, 'index'])->name('applications.index');
        Route::get('/applications/{application}', [EmployerApplicationController::class, 'show'])->name('applications.show');
        Route::post('/applications/{application}/status', [EmployerApplicationController::class, 'updateStatus'])->name('applications.status');

        // ML False Positive Appeals Engine
        Route::get('/jobs/{job}/appeal', [EmployerAppealController::class, 'create'])->name('appeals.create');
        Route::post('/jobs/{job}/appeal', [EmployerAppealController::class, 'store'])->name('appeals.store');

        // CLEANED UP PROFILE ROUTES (Removed redundant structural prefixes)
        Route::get('/profile', [EmployerProfileController::class, 'edit'])->name('profile.edit');
        Route::post('/profile', [EmployerProfileController::class, 'update'])->name('profile.update');
    });




Route::get('/', [JobFeedController::class, 'home'])->name('home');
Route::get('/jobs', [JobFeedController::class, 'index'])->name('jobs.index');
Route::get('/jobs/{job}', [JobFeedController::class, 'show'])->name('jobs.show');
Route::view('/about-us', 'public.about')->name('about');
Route::view('/contact-us', 'public.contact')->name('contact');
// Protected Candidate Actions (Requires login, role check optional or standard auth)
Route::middleware(['auth'])->group(function () {
    Route::post('/jobs/{job}/apply', [JobApplicationController::class, 'store'])->name('jobs.apply');
    Route::get('/my-applications', [JobApplicationController::class, 'index'])->name('candidate.applications');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
});
