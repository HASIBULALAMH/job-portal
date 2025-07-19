<?php

namespace App\Http\Controllers;

use App\Models\JobPosting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PublicJobController extends Controller
{
    public function index(Request $request)
    {
        $query = JobPosting::where('status', 'published');
        if ($request->filled('keyword')) {
            $query->where(function($q) use ($request) {
                $q->where('title', 'like', '%'.$request->keyword.'%')
                  ->orWhere('description', 'like', '%'.$request->keyword.'%');
            });
        }
        if ($request->filled('category')) {
            $query->where('job_type', $request->category);
        }
        if ($request->filled('location')) {
            $query->where('location', 'like', '%'.$request->location.'%');
        }
        $jobs = $query->orderByDesc('created_at')->paginate(10);
        $categories = [
            'full-time' => 'Full-time',
            'part-time' => 'Part-time',
            'contract' => 'Contract',
            'temporary' => 'Temporary',
            'internship' => 'Internship',
            'volunteer' => 'Volunteer',
        ];
        return view('public.jobs', compact('jobs', 'categories'));
    }

    public function show($id)
    {
        $job = JobPosting::where('status', 'published')->findOrFail($id);
        $categories = [
            'full-time' => 'Full-time',
            'part-time' => 'Part-time',
            'contract' => 'Contract',
            'temporary' => 'Temporary',
            'internship' => 'Internship',
            'volunteer' => 'Volunteer',
        ];
        return view('public.job_show', compact('job', 'categories'));
    }

    public function apply($id)
    {
        if (!Auth::check()) {
            return redirect()->route('register');
        }
        // Optionally, redirect to jobseeker apply page or show a message
        return redirect()->route('jobseeker.jobs.show', $id);
    }
} 