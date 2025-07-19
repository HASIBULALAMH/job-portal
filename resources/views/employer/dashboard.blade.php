@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Employer Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="alert alert-success" role="alert">
                        Welcome, {{ Auth::user()->name }}! You are logged in as an Employer.
                    </div>

                    <div class="mt-4">
                        <h4>Quick Actions</h4>
                        <div class="list-group">
                            <a href="#" class="list-group-item list-group-item-action">Post a New Job</a>
                            <a href="#" class="list-group-item list-group-item-action">View My Job Postings</a>
                            <a href="#" class="list-group-item list-group-item-action">View Applicants</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
