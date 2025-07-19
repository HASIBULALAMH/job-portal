@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="row g-4 mb-4">
                <div class="col-12 col-md-6">
                    <div class="card text-center shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">Total Users</h5>
                            <p class="display-4 fw-bold text-primary mb-0">{{ $totalUsers }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="card text-center shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">Total Jobs</h5>
                            <p class="display-4 fw-bold text-success mb-0">{{ $totalJobs }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 