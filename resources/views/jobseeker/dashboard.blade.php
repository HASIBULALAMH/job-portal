@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Job Seeker Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="alert alert-success" role="alert">
                        Welcome, {{ Auth::user()->name }}! You are logged in as a Job Seeker.
                    </div>

                    <div class="mt-4">
                        <h4>Quick Actions</h4>
                        <div class="list-group">
                            <a href="{{ route('jobseeker.jobs.browse') }}" class="list-group-item list-group-item-action">Browse Jobs</a>
                            <a href="{{ route('jobseeker.jobs.applied') }}" class="list-group-item list-group-item-action">My Applications</a>
                            <a href="{{ route('jobseeker.profile.edit') }}" class="list-group-item list-group-item-action">My Profile</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
