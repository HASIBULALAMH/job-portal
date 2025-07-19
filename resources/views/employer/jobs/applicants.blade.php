@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-3 gap-3">
                <h2 class="mb-0">Applicants for: {{ $jobPosting->title }}</h2>
                <a href="{{ route('employer.job-postings.index') }}" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Back to Job Postings</a>
            </div>
            @if (session('status'))
                <div class="alert alert-success">{{ session('status') }}</div>
            @endif
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle bg-white shadow-sm">
                    <thead class="table-primary">
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Status</th>
                            <th>Cover Letter</th>
                            <th>Resume</th>
                            <th>Update Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($applicants as $application)
                        <tr>
                            <td>{{ $application->user->name }}</td>
                            <td>{{ $application->user->email }}</td>
                            <td>
                                @php
                                    $badgeClass = match($application->status) {
                                        'accepted' => 'success',
                                        'rejected' => 'danger',
                                        'shortlisted' => 'info',
                                        'reviewed' => 'primary',
                                        default => 'secondary'
                                    };
                                @endphp
                                <span class="badge bg-{{ $badgeClass }}">
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
                            <td>
                                <form method="POST" action="{{ route('employer.job-postings.applicants.updateStatus', [$jobPosting->id, $application->id]) }}" class="d-flex gap-2 align-items-center">
                                    @csrf
                                    <select name="status" class="form-select form-select-sm w-auto">
                                        <option value="pending" {{ $application->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="reviewed" {{ $application->status === 'reviewed' ? 'selected' : '' }}>Reviewed</option>
                                        <option value="shortlisted" {{ $application->status === 'shortlisted' ? 'selected' : '' }}>Shortlisted</option>
                                        <option value="accepted" {{ $application->status === 'accepted' ? 'selected' : '' }}>Accepted</option>
                                        <option value="rejected" {{ $application->status === 'rejected' ? 'selected' : '' }}>Rejected</option>
                                    </select>
                                    <button type="submit" class="btn btn-sm btn-outline-primary">Update</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center">No applicants found for this job.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection 