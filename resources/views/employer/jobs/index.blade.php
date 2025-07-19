@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h2>My Job Postings</h2>
                <a href="{{ route('employer.job-postings.create') }}" class="btn btn-primary">Post New Job</a>
            </div>
            @if (session('status'))
                <div class="alert alert-success">{{ session('status') }}</div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            @if (session('info'))
                <div class="alert alert-info">{{ session('info') }}</div>
            @endif
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Title</th>
                            <th>Status</th>
                            <th>Type</th>
                            <th>Location</th>
                            <th>Deadline</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($jobs as $job)
                        <tr>
                            <td>{{ $job->title }}</td>
                            <td>
                                <span class="badge bg-{{ $job->status === 'published' ? 'success' : ($job->status === 'closed' ? 'secondary' : 'warning') }}">
                                    {{ ucfirst($job->status) }}
                                </span>
                            </td>
                            <td>{{ ucfirst($job->job_type) }}</td>
                            <td>{{ $job->location }}</td>
                            <td>{{ $job->deadline ? $job->deadline->format('Y-m-d') : '-' }}</td>
                            <td>
                                <a href="{{ route('employer.job-postings.edit', $job) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                                <a href="{{ route('employer.job-postings.applicants', $job) }}" class="btn btn-sm btn-outline-info">Applicants</a>
                                <button class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#statusModal{{ $job->id }}">Status</button>
                                <form action="{{ route('employer.job-postings.destroy', $job) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this job posting?')">Delete</button>
                                </form>
                                <!-- Status Modal -->
                                <div class="modal fade" id="statusModal{{ $job->id }}" tabindex="-1" aria-labelledby="statusModalLabel{{ $job->id }}" aria-hidden="true">
                                  <div class="modal-dialog">
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <h5 class="modal-title" id="statusModalLabel{{ $job->id }}">Update Status</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                      </div>
                                      <form action="{{ route('employer.job-postings.updateStatus', $job) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <div class="modal-body">
                                          <select name="status" class="form-select">
                                            <option value="published" {{ $job->status === 'published' ? 'selected' : '' }}>Open</option>
                                            <option value="closed" {{ $job->status === 'closed' ? 'selected' : '' }}>Closed</option>
                                          </select>
                                        </div>
                                        <div class="modal-footer">
                                          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                          <button type="submit" class="btn btn-primary">Update</button>
                                        </div>
                                      </form>
                                    </div>
                                  </div>
                                </div>
                                <!-- End Status Modal -->
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center">No job postings found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection 