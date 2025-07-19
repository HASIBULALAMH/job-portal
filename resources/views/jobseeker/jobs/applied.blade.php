@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12">
            <h2 class="mb-4">My Applications</h2>
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Job Title</th>
                            <th>Employer</th>
                            <th>Status</th>
                            <th>Cover Letter</th>
                            <th>Resume</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($applications as $application)
                        <tr>
                            <td>{{ $application->jobPosting->title ?? '-' }}</td>
                            <td>{{ $application->jobPosting->employer->name ?? '-' }}</td>
                            <td>
                                <span class="badge bg-{{ $application->status === 'accepted' ? 'success' : ($application->status === 'rejected' ? 'danger' : ($application->status === 'reviewed' ? 'info' : 'secondary')) }}">
                                    {{ ucfirst($application->status) }}
                                </span>
                            </td>
                            <td>
                                @if ($application->cover_letter)
                                    <button class="btn btn-sm btn-outline-info" data-bs-toggle="modal" data-bs-target="#coverLetterModal{{ $application->id }}">View</button>
                                    <div class="modal fade" id="coverLetterModal{{ $application->id }}" tabindex="-1" aria-labelledby="coverLetterModalLabel{{ $application->id }}" aria-hidden="true">
                                      <div class="modal-dialog">
                                        <div class="modal-content">
                                          <div class="modal-header">
                                            <h5 class="modal-title" id="coverLetterModalLabel{{ $application->id }}">Cover Letter</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                          </div>
                                          <div class="modal-body">
                                            {{ $application->cover_letter }}
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                @else
                                    -
                                @endif
                            </td>
                            <td>
                                @if ($application->resume)
                                    <a href="{{ asset('storage/' . $application->resume) }}" target="_blank">Download</a>
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center">You have not applied to any jobs yet.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection 