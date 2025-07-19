<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JobPosting;
use Illuminate\Support\Facades\Auth;

class JobPostingController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'employer']);
    }

    // List all job postings for the authenticated employer
    public function index()
    {
        $jobs = JobPosting::where('employer_id', Auth::id())->latest()->get();
        return view('employer.jobs.index', compact('jobs'));
    }

    // Show form to create a new job posting
    public function create()
    {
        return view('employer.jobs.create');
    }

    // Store a new job posting
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'required|string|max:255',
            'salary' => 'nullable|numeric',
            'job_type' => 'required|string',
            'experience_level' => 'required|string',
            'deadline' => 'nullable|date',
            'requirements' => 'nullable|string',
            'responsibilities' => 'nullable|string',
            'benefits' => 'nullable|string',
        ]);
        $data['employer_id'] = Auth::id();
        $data['status'] = 'published';
        JobPosting::create($data);
        return redirect()->route('employer.job-postings.index')->with('status', 'Job posted successfully!');
    }

    // Show form to edit a job posting
    public function edit(JobPosting $jobPosting)
    {
        $this->authorizeJob($jobPosting);
        return view('employer.jobs.edit', compact('jobPosting'));
    }

    // Update a job posting
    public function update(Request $request, JobPosting $jobPosting)
    {
        $this->authorizeJob($jobPosting);
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'required|string|max:255',
            'salary' => 'nullable|numeric',
            'job_type' => 'required|string',
            'experience_level' => 'required|string',
            'deadline' => 'nullable|date',
            'requirements' => 'nullable|string',
            'responsibilities' => 'nullable|string',
            'benefits' => 'nullable|string',
        ]);
        $jobPosting->update($data);
        return redirect()->route('employer.job-postings.index')->with('status', 'Job updated successfully!');
    }

    // Delete a job posting
    public function destroy(JobPosting $jobPosting)
    {
        $this->authorizeJob($jobPosting);
        $jobPosting->delete();
        return redirect()->route('employer.job-postings.index')->with('status', 'Job deleted successfully!');
    }

    // Show applicants for a job posting (stub, to be implemented)
    public function showApplicants(JobPosting $jobPosting)
    {
        $this->authorizeJob($jobPosting);
        $applicants = $jobPosting->applications()->with('user')->get();
        return view('employer.jobs.applicants', compact('jobPosting', 'applicants'));
    }

    // Update job status (Open/Closed)
    public function updateStatus(Request $request, JobPosting $jobPosting)
    {
        $this->authorizeJob($jobPosting);
        $request->validate([
            'status' => 'required|in:published,closed',
        ]);
        $jobPosting->status = $request->status;
        $jobPosting->save();
        return redirect()->route('employer.job-postings.index')->with('status', 'Job status updated!');
    }

    // Helper to ensure only the owner can manage their job postings
    protected function authorizeJob(JobPosting $jobPosting)
    {
        if ($jobPosting->employer_id !== Auth::id()) {
            abort(403);
        }
    }
} 