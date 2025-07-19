@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-8">
            <div class="card mb-4">
                <div class="card-header">
                    <h3>{{ $jobPosting->title }}</h3>
                    <div class="text-muted">Employer: {{ $jobPosting->employer->name ?? '-' }}</div>
                </div>
                <div class="card-body">
                    <p><strong>Description:</strong> {{ $jobPosting->description }}</p>
                    <p><strong>Location:</strong> {{ $jobPosting->location }}</p>
                    <p><strong>Type:</strong> {{ ucfirst($jobPosting->job_type) }}</p>
                    <p><strong>Experience Level:</strong> {{ ucfirst($jobPosting->experience_level) }}</p>
                    <p><strong>Deadline:</strong> {{ $jobPosting->deadline ? $jobPosting->deadline->format('Y-m-d') : '-' }}</p>
                    @if ($jobPosting->requirements)
                        <p><strong>Requirements:</strong> {{ $jobPosting->requirements }}</p>
                    @endif
                    @if ($jobPosting->responsibilities)
                        <p><strong>Responsibilities:</strong> {{ $jobPosting->responsibilities }}</p>
                    @endif
                    @if ($jobPosting->benefits)
                        <p><strong>Benefits:</strong> {{ $jobPosting->benefits }}</p>
                    @endif
                </div>
            </div>
            <div class="card">
                <div class="card-header">Your Application Status</div>
                <div class="card-body">
                    @if ($application)
                        <p>Status: <span class="badge bg-{{ $application->status === 'accepted' ? 'success' : ($application->status === 'rejected' ? 'danger' : ($application->status === 'reviewed' ? 'info' : 'secondary')) }}">{{ ucfirst($application->status) }}</span></p>
                        @if ($application->cover_letter)
                            <p><strong>Cover Letter:</strong></p>
                            <div class="border p-2 mb-2">{{ $application->cover_letter }}</div>
                        @endif
                        @if ($application->resume)
                            <p><a href="{{ asset('storage/' . $application->resume) }}" target="_blank">Download Resume</a></p>
                        @endif
                    @else
                        <p>You have not applied to this job yet.</p>
                    @endif
                </div>
            </div>
            <div class="mt-3">
                <a href="{{ route('jobseeker.jobs.browse') }}" class="btn btn-secondary">Back to Job Listings</a>
            </div>
        </div>
    </div>
</div>
@endsection 