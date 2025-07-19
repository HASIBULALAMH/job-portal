<?php

namespace App\Http\Controllers\Employer;

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
        $this->middleware(['auth', 'employer']);
    }

    /**
     * Show the employer dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('employer.dashboard');
    }
}
