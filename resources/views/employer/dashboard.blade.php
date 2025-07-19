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

                    <div class="mt-4 text-center">
                        <a href="{{ route('employer.job-postings.index') }}" class="btn btn-lg btn-primary">Manage My Job Postings</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
