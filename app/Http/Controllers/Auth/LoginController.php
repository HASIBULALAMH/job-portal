<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = '/dashboard';
    
    public function redirectTo()
    {
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->isEmployer()) {
                return route('employer.dashboard');
            }
            return route('job-seeker.dashboard');
        }
        return route('login');
    }

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }
}
