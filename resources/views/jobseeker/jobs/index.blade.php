@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12">
            <h2 class="mb-4">Browse Jobs</h2>
            @if (session('status'))
                <div class="alert alert-success">{{ session('status') }}</div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Title</th>
                            <th>Employer</th>
                            <th>Location</th>
                            <th>Type</th>
                            <th>Deadline</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($jobs as $job)
                        <tr>
                            <td>{{ $job->title }}</td>
                            <td>{{ $job->employer->name ?? '-' }}</td>
                            <td>{{ $job->location }}</td>
                            <td>{{ ucfirst($job->job_type) }}</td>
                            <td>{{ $job->deadline ? $job->deadline->format('Y-m-d') : '-' }}</td>
                            <td class="d-flex gap-2">
                                <a href="{{ route('jobseeker.jobs.show', $job->id) }}" class="btn btn-sm btn-outline-info">View Details</a>
                                @php
                                    $alreadyApplied = $job->applications()->where('user_id', Auth::id())->exists();
                                @endphp
                                @if ($alreadyApplied)
                                    <span class="badge bg-success align-self-center">Applied</span>
                                @else
                                    <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#applyModal{{ $job->id }}">Apply</button>
                                    <div class="modal fade" id="applyModal{{ $job->id }}" tabindex="-1" aria-labelledby="applyModalLabel{{ $job->id }}" aria-hidden="true">
                                      <div class="modal-dialog">
                                        <div class="modal-content">
                                          <div class="modal-header">
                                            <h5 class="modal-title" id="applyModalLabel{{ $job->id }}">Apply to {{ $job->title }}</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                          </div>
                                          <form method="POST" action="{{ route('jobseeker.jobs.apply', $job) }}" enctype="multipart/form-data">
                                            @csrf
                                            <div class="modal-body">
                                              <div class="mb-3">
                                                <label for="cover_letter_{{ $job->id }}" class="form-label">Cover Letter (optional)</label>
                                                <textarea class="form-control" id="cover_letter_{{ $job->id }}" name="cover_letter" rows="3"></textarea>
                                              </div>
                                              <div class="mb-3">
                                                <label for="resume_{{ $job->id }}" class="form-label">Resume (PDF/DOC, max 2MB, optional)</label>
                                                <input type="file" class="form-control" id="resume_{{ $job->id }}" name="resume" accept=".pdf,.doc,.docx">
                                                <small class="text-muted">If not provided, your profile resume will be used.</small>
                                              </div>
                                            </div>
                                            <div class="modal-footer">
                                              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                              <button type="submit" class="btn btn-primary">Submit Application</button>
                                            </div>
                                          </form>
                                        </div>
                                      </div>
                                    </div>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center">No jobs found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-3">
                {{ $jobs->links() }}
            </div>
        </div>
    </div>
</div>
@endsection 