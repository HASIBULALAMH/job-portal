@extends('layouts.app')

@section('content')
<style>
    .job-card {
        transition: all 0.3s ease;
        cursor: pointer;
    }
    .job-card:hover {
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        transform: scale(1.01);
    }
    .job-title {
        font-size: 1.2rem;
        font-weight: 600;
    }
    .job-meta {
        font-size: 0.9rem;
        color: #6c757d;
    }
</style>
<div class="container py-5">
    <!-- Search Filter -->
    <div class="row justify-content-center mb-4">
        <div class="col-lg-10">
            <form method="GET" action="{{ route('public.jobs') }}" class="row g-3 align-items-end bg-white p-4 rounded shadow-sm">
                <div class="col-md-4">
                    <label for="keyword" class="form-label">Keyword</label>
                    <input type="text" class="form-control" id="keyword" name="keyword" value="{{ request('keyword') }}" placeholder="Job title or description">
                </div>
                <div class="col-md-4">
                    <label for="category" class="form-label">Category</label>
                    <select class="form-select" id="category" name="category">
                        <option value="">All Categories</option>
                        @foreach ($categories as $key => $label)
                            <option value="{{ $key }}" {{ request('category') == $key ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="location" class="form-label">Location</label>
                    <input type="text" class="form-control" id="location" name="location" value="{{ request('location') }}" placeholder="City or area">
                </div>
                <div class="col-md-1 d-grid">
                    <button type="submit" class="btn btn-primary">Search</button>
                </div>
            </form>
        </div>
    </div>
    <!-- Job List -->
    <div class="row justify-content-center">
        <div class="col-lg-10">
            @forelse ($jobs as $job)
                <div class="card mb-3 shadow-sm job-card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center flex-wrap">
                            <div>
                                <div class="job-title">{{ $job->title }}</div>
                                <div class="job-meta">
                                    {{ $categories[$job->job_type] ?? ucfirst($job->job_type) }} | 
                                    {{ $job->location }} | 
                                    Deadline: {{ $job->deadline ? $job->deadline->format('Y-m-d') : 'N/A' }}
                                </div>
                            </div>
                            <div class="d-flex gap-2 align-items-center mt-2 mt-md-0">
                                <a href="{{ route('public.jobs.show', $job->id) }}" class="btn btn-outline-info btn-sm">View Details</a>
                                <form method="POST" action="{{ route('public.jobs.apply', $job->id) }}" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-success btn-sm">Apply</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-4">
                    <h5 class="text-muted">No jobs found based on your search.</h5>
                </div>
            @endforelse
            <!-- Pagination -->
            <div class="mt-4 d-flex justify-content-center">
                {{ $jobs->withQueryString()->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
