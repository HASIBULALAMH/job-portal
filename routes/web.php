<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Employer\DashboardController as EmployerDashboardController;
use App\Http\Controllers\Employer\JobPostingController;
use App\Http\Controllers\JobSeeker\DashboardController as JobSeekerDashboardController;
use App\Http\Controllers\JobSeeker\ProfileController;
use App\Http\Controllers\JobSeeker\JobController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PublicJobController;

Route::get('/', [HomeController::class, 'index'])->name('public.home');
Route::get('/jobs', [PublicJobController::class, 'index'])->name('public.jobs');
Route::get('/jobs/{id}', [PublicJobController::class, 'show'])->name('public.jobs.show');
Route::post('/jobs/{id}/apply', [PublicJobController::class, 'apply'])->name('public.jobs.apply');

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

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('login', [AdminController::class, 'showLoginForm'])->name('login');
    Route::post('login', [AdminController::class, 'login'])->name('login.submit');
    Route::post('logout', [AdminController::class, 'logout'])->name('logout');
    Route::get('dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('users', [AdminController::class, 'users'])->name('users');
    Route::get('jobs', [AdminController::class, 'jobs'])->name('jobs');
    Route::delete('users/{id}', [AdminController::class, 'destroyUser'])->name('users.destroy');
    Route::delete('jobs/{id}', [AdminController::class, 'destroyJob'])->name('jobs.destroy');
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
