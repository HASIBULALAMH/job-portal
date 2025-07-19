<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Employer\DashboardController as EmployerDashboardController;
use App\Http\Controllers\JobSeeker\DashboardController as JobSeekerDashboardController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

// Employer Routes - Protected by auth and employer middleware
Route::middleware(['auth', 'employer'])->prefix('employer')->name('employer.')->group(function () {
    Route::get('/dashboard', [EmployerDashboardController::class, 'index'])->name('dashboard');
    // Add more employer routes here
});

// Job Seeker Routes - Protected by auth and jobseeker middleware
Route::middleware(['auth', 'jobseeker'])->prefix('job-seeker')->name('job-seeker.')->group(function () {
    Route::get('/dashboard', [JobSeekerDashboardController::class, 'index'])->name('dashboard');
    // Add more job seeker routes here
});

// Default home route - redirect based on user role
Route::get('/home', function () {
    if (Auth::check()) {
        $user = Auth::user();
        if ($user->isEmployer()) {
            return redirect()->route('employer.dashboard');
        }
        return redirect()->route('job-seeker.dashboard');
    }
    return redirect()->route('login');
})->name('home');
