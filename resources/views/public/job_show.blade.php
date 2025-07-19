@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <h2 class="fw-bold mb-2">{{ $job->title }}</h2>
                    <div class="mb-2 text-muted">Category: {{ $categories[$job->job_type] ?? ucfirst($job->job_type) }}</div>
                    <div class="mb-2 text-muted">Location: {{ $job->location }}</div>
                    <div class="mb-2 text-muted">Deadline: {{ $job->deadline ? $job->deadline->format('Y-m-d') : 'N/A' }}</div>
                    <div class="mb-3">
                        <span class="badge bg-success">Open</span>
                    </div>
                    <h5 class="mt-4">Description</h5>
                    <p>{{ $job->description }}</p>
                    @if ($job->requirements)
                        <h6 class="mt-3">Requirements</h6>
                        <p>{{ $job->requirements }}</p>
                    @endif
                    @if ($job->responsibilities)
                        <h6 class="mt-3">Responsibilities</h6>
                        <p>{{ $job->responsibilities }}</p>
                    @endif
                    @if ($job->benefits)
                        <h6 class="mt-3">Benefits</h6>
                        <p>{{ $job->benefits }}</p>
                    @endif
                    <div class="mt-4">
                        <form method="POST" action="{{ route('public.jobs.apply', $job->id) }}">
                            @csrf
                            <button type="submit" class="btn btn-primary btn-lg">Apply for this Job</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="text-center">
                <a href="{{ route('public.jobs') }}" class="btn btn-outline-secondary">Back to Job Listings</a>
            </div>
        </div>
    </div>
</div>
@endsection 