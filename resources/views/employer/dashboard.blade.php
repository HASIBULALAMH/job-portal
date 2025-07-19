@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white fw-bold">Employer Dashboard</div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div class="alert alert-success mb-4" role="alert">
                        Welcome, {{ Auth::user()->name }}! You are logged in as an Employer.
                    </div>
                    <div class="row g-3">
                        <div class="col-12">
                            <h4 class="mb-3">Quick Actions</h4>
                        </div>
                        <div class="col-12 col-md-4">
                            <a href="{{ route('employer.job-postings.create') }}" class="btn btn-outline-primary w-100 py-3 d-flex flex-column align-items-center">
                                <i class="bi bi-plus-circle fs-2 mb-2"></i>
                                <span>Post a New Job</span>
                            </a>
                        </div>
                        <div class="col-12 col-md-4">
                            <a href="{{ route('employer.job-postings.index') }}" class="btn btn-outline-success w-100 py-3 d-flex flex-column align-items-center">
                                <i class="bi bi-briefcase fs-2 mb-2"></i>
                                <span>View My Job Postings</span>
                            </a>
                        </div>
                        <div class="col-12 col-md-4">
                            <a href="{{ route('employer.job-postings.index') }}#applicants" class="btn btn-outline-info w-100 py-3 d-flex flex-column align-items-center">
                                <i class="bi bi-people fs-2 mb-2"></i>
                                <span>View Applicants</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
