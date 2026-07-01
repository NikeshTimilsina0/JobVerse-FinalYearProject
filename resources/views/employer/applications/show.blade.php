@extends('layouts.app')

@section('content')
<div class="container py-5">
    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm mb-4">{{ session('success') }}</div>
    @endif

    <div class="mb-4">
        <a href="{{ route('employer.applications.index') }}" class="text-decoration-none text-muted small fw-bold">&larr; Back to Pipelines</a>
    </div>

    <div class="row g-4">
        <!-- Main Applicant Profile Card -->
        <div class="col-lg-8">
            <div class="card bg-white border rounded shadow-sm p-4 p-md-5 mb-4">
                <div class="border-bottom pb-3 mb-4">
                    <span class="badge bg-primary-subtle text-primary border border-primary-subtle mb-2">Application Record</span>
                    <h1 class="h2 fw-bold text-dark mb-1">{{ $application->user->name }}</h1>
                    <p class="text-secondary mb-0">Applying for position: <strong class="text-dark">{{ $application->job->title }}</strong></p>
                </div>

                <div class="mb-4">
                    <h3 class="h6 fw-bold text-dark text-uppercase tracking-wide mb-2">Contact Context Information</h3>
                    <p class="text-muted mb-1"><i class="bi bi-envelope me-2"></i> {{ $application->user->email }}</p>
                </div>

                @if($application->cover_letter)
                    <div class="mb-4">
                        <h3 class="h6 fw-bold text-dark text-uppercase tracking-wide mb-2">Cover Letter Statement</h3>
                        <div class="bg-light p-3 rounded text-secondary border small" style="white-space: pre-line;">
                            {{ $application->cover_letter }}
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Sticky Management Action Right Sidebar -->
        <div class="col-lg-4">
            <div class="card bg-white border rounded shadow-sm p-4">
                <h2 class="h5 fw-bold text-dark border-bottom pb-2 mb-3">Application Status</h2>
                
                <div class="mb-4">
                    <span class="d-block text-muted small mb-1">Current Metric Phase:</span>
                    <span class="badge fs-6 px-3 py-2 border @if($application->status === 'Pending') bg-warning-subtle text-warning border-warning-subtle @elif($application->status === 'Shortlisted') bg-success-subtle text-success border-success-subtle @else bg-danger-subtle text-danger border-danger-subtle @endif">
                        {{ $application->status }}
                    </span>
                </div>

                <form action="{{ route('employer.applications.status', $application->id) }}" method="POST">
                    @csrf
                    <div class="d-grid gap-2">
                        <button type="submit" name="status" value="Shortlisted" class="btn btn-success fw-bold p-2 shadow-sm" {{ $application->status === 'Shortlisted' ? 'disabled' : '' }}>
                            <i class="bi bi-check-lg me-1"></i> Shortlist Candidate
                        </button>
                        <button type="submit" name="status" value="Rejected" class="btn btn-outline-danger fw-semibold p-2" {{ $application->status === 'Rejected' ? 'disabled' : '' }}>
                            <i class="bi bi-x-lg me-1"></i> Reject Application
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection