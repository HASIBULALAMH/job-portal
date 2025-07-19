@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Post a New Job</div>
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form method="POST" action="{{ route('employer.job-postings.store') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="4" required>{{ old('description') }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label for="location" class="form-label">Location</label>
                            <input type="text" class="form-control" id="location" name="location" value="{{ old('location') }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="salary" class="form-label">Salary</label>
                            <input type="number" step="0.01" class="form-control" id="salary" name="salary" value="{{ old('salary') }}">
                        </div>
                        <div class="mb-3">
                            <label for="job_type" class="form-label">Job Type</label>
                            <select class="form-select" id="job_type" name="job_type" required>
                                <option value="">Select Type</option>
                                <option value="full-time" {{ old('job_type') == 'full-time' ? 'selected' : '' }}>Full-time</option>
                                <option value="part-time" {{ old('job_type') == 'part-time' ? 'selected' : '' }}>Part-time</option>
                                <option value="contract" {{ old('job_type') == 'contract' ? 'selected' : '' }}>Contract</option>
                                <option value="temporary" {{ old('job_type') == 'temporary' ? 'selected' : '' }}>Temporary</option>
                                <option value="internship" {{ old('job_type') == 'internship' ? 'selected' : '' }}>Internship</option>
                                <option value="volunteer" {{ old('job_type') == 'volunteer' ? 'selected' : '' }}>Volunteer</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="experience_level" class="form-label">Experience Level</label>
                            <select class="form-select" id="experience_level" name="experience_level" required>
                                <option value="">Select Level</option>
                                <option value="entry" {{ old('experience_level') == 'entry' ? 'selected' : '' }}>Entry</option>
                                <option value="associate" {{ old('experience_level') == 'associate' ? 'selected' : '' }}>Associate</option>
                                <option value="mid-senior" {{ old('experience_level') == 'mid-senior' ? 'selected' : '' }}>Mid-Senior</option>
                                <option value="director" {{ old('experience_level') == 'director' ? 'selected' : '' }}>Director</option>
                                <option value="executive" {{ old('experience_level') == 'executive' ? 'selected' : '' }}>Executive</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="deadline" class="form-label">Deadline</label>
                            <input type="date" class="form-control" id="deadline" name="deadline" value="{{ old('deadline') }}">
                        </div>
                        <div class="mb-3">
                            <label for="requirements" class="form-label">Requirements</label>
                            <textarea class="form-control" id="requirements" name="requirements" rows="2">{{ old('requirements') }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label for="responsibilities" class="form-label">Responsibilities</label>
                            <textarea class="form-control" id="responsibilities" name="responsibilities" rows="2">{{ old('responsibilities') }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label for="benefits" class="form-label">Benefits</label>
                            <textarea class="form-control" id="benefits" name="benefits" rows="2">{{ old('benefits') }}</textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Post Job</button>
                        <a href="{{ route('employer.job-postings.index') }}" class="btn btn-secondary ms-2">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 