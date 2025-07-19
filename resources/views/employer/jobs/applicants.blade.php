@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h2>Applicants for: {{ $jobPosting->title }}</h2>
                <a href="{{ route('employer.job-postings.index') }}" class="btn btn-secondary">Back to Job Postings</a>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Status</th>
                            <th>Cover Letter</th>
                            <th>Resume</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($applicants as $application)
                        <tr>
                            <td>{{ $application->user->name }}</td>
                            <td>{{ $application->user->email }}</td>
                            <td>
                                <span class="badge bg-{{ $application->status === 'accepted' ? 'success' : ($application->status === 'rejected' ? 'danger' : ($application->status === 'reviewed' ? 'info' : 'secondary')) }}">
                                    {{ ucfirst($application->status) }}
                                </span>
                            </td>
                            <td>{{ $application->cover_letter ? Str::limit($application->cover_letter, 50) : '-' }}</td>
                            <td>
                                @if ($application->resume)
                                    <a href="{{ asset('storage/' . $application->resume) }}" target="_blank">View Resume</a>
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center">No applicants found for this job.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection 