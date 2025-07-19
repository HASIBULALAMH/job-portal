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

    public function index()
    {
        $jobs = JobPosting::where('employer_id', Auth::id())->latest()->get();
        return view('employer.jobs.index', compact('jobs'));
    }

    public function create()
    {
        return view('employer.jobs.create');
    }

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

    public function edit(JobPosting $jobPosting)
    {
        $this->authorizeJob($jobPosting);
        return view('employer.jobs.edit', compact('jobPosting'));
    }

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

    public function destroy(JobPosting $jobPosting)
    {
        $this->authorizeJob($jobPosting);
        $jobPosting->delete();
        return redirect()->route('employer.job-postings.index')->with('status', 'Job deleted successfully!');
    }

    public function showApplicants(JobPosting $jobPosting)
    {
        $this->authorizeJob($jobPosting);
        $applicants = $jobPosting->applications()->with('user')->get();
        return view('employer.jobs.applicants', compact('jobPosting', 'applicants'));
    }

    public function updateApplicantStatus(Request $request, JobPosting $jobPosting, $applicationId)
    {
        $this->authorizeJob($jobPosting);
        $request->validate([
            'status' => 'required|in:pending,reviewed,shortlisted,accepted,rejected',
        ]);
        $application = $jobPosting->applications()->where('id', $applicationId)->firstOrFail();
        $application->status = $request->status;
        $application->save();
        return redirect()->back()->with('status', 'Applicant status updated!');
    }

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

    protected function authorizeJob(JobPosting $jobPosting)
    {
        if ($jobPosting->employer_id !== Auth::id()) {
            abort(403);
        }
    }
} 