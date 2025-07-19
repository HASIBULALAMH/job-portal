<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Employer\DashboardController as EmployerDashboardController;
use App\Http\Controllers\Employer\JobPostingController;
use App\Http\Controllers\JobSeeker\DashboardController as JobSeekerDashboardController;
use App\Http\Controllers\JobSeeker\ProfileController;
use App\Http\Controllers\JobSeeker\JobController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::middleware(['auth', 'employer'])->prefix('employer')->name('employer.')->group(function () {
    Route::get('/dashboard', [EmployerDashboardController::class, 'index'])->name('dashboard');
    Route::resource('job-postings', JobPostingController::class);
    Route::get('job-postings/{jobPosting}/applicants', [JobPostingController::class, 'showApplicants'])->name('job-postings.applicants');
    Route::patch('job-postings/{jobPosting}/status', [JobPostingController::class, 'updateStatus'])->name('job-postings.updateStatus');
    Route::post('job-postings/{jobPosting}/applicants/{applicationId}/status', [JobPostingController::class, 'updateApplicantStatus'])->name('job-postings.applicants.updateStatus');
});

Route::middleware(['auth', 'jobseeker'])->prefix('job-seeker')->name('jobseeker.')->group(function () {
    Route::get('/dashboard', [JobSeekerDashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/jobs', [JobController::class, 'index'])->name('jobs.browse');
    Route::get('/jobs/{jobPosting}', [JobController::class, 'show'])->name('jobs.show');
    Route::post('/jobs/{jobPosting}/apply', [JobController::class, 'apply'])->name('jobs.apply');
    Route::get('/applied', [JobController::class, 'applied'])->name('jobs.applied');
});

Route::get('/home', function () {
    if (Auth::check()) {
        $user = Auth::user();
        if ($user->isEmployer()) {
            return redirect()->route('employer.dashboard');
        }
        return redirect()->route('jobseeker.dashboard');
    }
    return redirect()->route('login');
});
