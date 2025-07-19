<?php

namespace App\Http\Controllers\JobSeeker;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'jobseeker']);
    }

    /**
     * Show the job seeker dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('jobseeker.dashboard');
    }
}
