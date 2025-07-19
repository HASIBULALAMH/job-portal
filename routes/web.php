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
    // Job Posting CRUD
    Route::resource('job-postings', \App\Http\Controllers\Employer\JobPostingController::class);
    // View applicants for a job
    Route::get('job-postings/{jobPosting}/applicants', [\App\Http\Controllers\Employer\JobPostingController::class, 'showApplicants'])->name('job-postings.applicants');
    // Update job status
    Route::patch('job-postings/{jobPosting}/status', [\App\Http\Controllers\Employer\JobPostingController::class, 'updateStatus'])->name('job-postings.updateStatus');
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
