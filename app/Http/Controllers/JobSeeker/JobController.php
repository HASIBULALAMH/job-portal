<?php

namespace App\Http\Controllers\JobSeeker;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\JobPosting;
use App\Models\JobApplication;

class JobController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'jobseeker']);
    }

    public function index(Request $request)
    {
        $jobs = JobPosting::where('status', 'published')->orderByDesc('created_at')->paginate(10);
        return view('jobseeker.jobs.index', compact('jobs'));
    }

    public function show(JobPosting $jobPosting)
    {
        $jobPosting->load('employer');
        $application = JobApplication::where('job_posting_id', $jobPosting->id)
            ->where('user_id', Auth::id())
            ->first();
        return view('jobseeker.jobs.show', compact('jobPosting', 'application'));
    }

    public function apply(Request $request, JobPosting $jobPosting)
    {
        $user = Auth::user();
        if (JobApplication::where('job_posting_id', $jobPosting->id)->where('user_id', $user->id)->exists()) {
            return redirect()->back()->with('error', 'You have already applied to this job.');
        }
        $data = $request->validate([
            'cover_letter' => 'nullable|string|max:2000',
            'resume' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
        ]);
        $resumePath = $user->resume;
        if ($request->hasFile('resume')) {
            $resumePath = $request->file('resume')->store('resumes', 'public');
        }
        JobApplication::create([
            'job_posting_id' => $jobPosting->id,
            'user_id' => $user->id,
            'cover_letter' => $data['cover_letter'] ?? null,
            'resume' => $resumePath,
            'status' => 'pending',
        ]);
        return redirect()->route('jobseeker.jobs.browse')->with('status', 'Application submitted successfully!');
    }

    public function applied()
    {
        $applications = JobApplication::with(['jobPosting.employer'])
            ->where('user_id', Auth::id())
            ->latest()
            ->get();
        return view('jobseeker.jobs.applied', compact('applications'));
    }
} 