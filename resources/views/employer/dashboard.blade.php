@extends('layouts.app')

@section('content')
<div class="container py-5">
    <!-- Top Greeting Header -->
    <div class="d-flex justify-content-between align-items-center border-bottom pb-4 mb-4" style="border-bottom-color: #7B2FBE; border-bottom-width: 3px;">
        <div>
            <h1 class="fw-bold text-dark mb-1">Employer Dashboard</h1>
            <p class="text-secondary mb-0">Monitor telemetry performance, screening workflows, and model evaluations.</p>
        </div>
        <a href="{{ route('employer.jobs.create') }}" class="btn fw-bold px-4 py-2 shadow-sm" 
           style="background-color: #7B2FBE; border-color: #7B2FBE; color: #ffffff;"
           onmouseover="this.style.backgroundColor='#5B1A8A'; this.style.borderColor='#5B1A8A';" 
           onmouseout="this.style.backgroundColor='#7B2FBE'; this.style.borderColor='#7B2FBE';">
           <i class="bi bi-plus-lg me-1"></i> Post a New Job
        </a>
    </div>

    <!-- Analytics Cards Row -->
    <div class="row g-3 mb-5">
        <div class="col-md-4">
            <div class="card bg-white border rounded shadow-sm p-4" style="border-color: #7B2FBE !important;">
                <div class="fs-3 mb-2" style="color: #7B2FBE;"><i class="bi bi-briefcase-fill"></i></div>
                <h3 class="text-muted h6 fw-bold text-uppercase mb-1">Total Job Postings</h3>
                <p class="display-6 fw-bold text-dark mb-0">{{ $stats['total_jobs'] }}</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-white border rounded shadow-sm p-4" style="border-color: #7B2FBE !important;">
                <div class="fs-3 mb-2" style="color: #7B2FBE;"><i class="bi bi-people-fill"></i></div>
                <h3 class="text-muted h6 fw-bold text-uppercase mb-1">Pending Review Apps</h3>
                <p class="display-6 fw-bold text-dark mb-0">{{ $stats['active_apps'] }}</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-white border rounded shadow-sm p-4" style="border-color: #7B2FBE !important;">
                <div class="fs-3 mb-2" style="color: #7B2FBE;"><i class="bi bi-shield-exclamation"></i></div>
                <h3 class="text-muted h6 fw-bold text-uppercase mb-1">Flagged Suspicious</h3>
                <p class="display-6 fw-bold text-dark mb-0">{{ $stats['flagged_jobs'] }}</p>
            </div>
        </div>
    </div>

    <!-- Overview Split Section Layout -->
    <div class="row g-4">
        <div class="col-lg-12">
            <div class="card bg-white border rounded shadow-sm p-4" style="border-color: #7B2FBE !important;">
                <div class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-3" style="border-bottom-color: #f0e6ff !important;">
                    <h2 class="h5 fw-bold mb-0 text-dark">Recent Vacancy Metrics</h2>
                    <a href="{{ route('employer.jobs.index') }}" class="small text-decoration-none fw-semibold" style="color: #7B2FBE;" onmouseover="this.style.color='#5B1A8A';" onmouseout="this.style.color='#7B2FBE';">View All Jobs &rarr;</a>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light text-uppercase fs-7 tracking-wider">
                            <tr>
                                <th>Job Title</th>
                                <th>Setting</th>
                                <th>Fraud Score</th>
                                <th>Status</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                                                <tbody>
                            @forelse($recentJobs as $job)
                                <tr>
                                    <td>
                                        <div class="fw-bold text-dark">{{ $job->title }}</div>
                                        <span class="text-muted small"><i class="bi bi-geo-alt me-1"></i>{{ $job->location ?? 'Not Specified' }}</span>
                                    </td>
                                    <td><span class="badge bg-light text-dark border">{{ $job->work_setting }}</span></td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="progress flex-grow-1" style="height: 6px; width: 60px;">
                                                <div class="progress-bar {{ $job->fraud_score > 0.5 ? 'bg-danger' : 'bg-success' }}" style="width: {{ $job->fraud_score * 100 }}%"></div>
                                            </div>
                                            <span class="small fw-semibold">{{ number_format($job->fraud_score * 100, 1) }}%</span>
                                        </div>
                                    </td>
                                    <td>
                                        @if($job->is_fraud)
                                            <span class="badge bg-danger-subtle text-danger border border-danger-subtle">Flagged</span>
                                        @else
                                            <span class="badge bg-success-subtle text-success border border-success-subtle">Active / Live</span>
                                        @endif
                                    </td>
                                    <td class="text-end">
                                        @if($job->is_fraud)
                                            <a href="{{ route('employer.appeals.create', $job->id) }}" class="btn btn-sm btn-outline-danger fw-bold">Dispute</a>
                                        @else
<a href="{{ route('employer.applications.index') }}" class="btn btn-sm fw-semibold" 
                                               style="color: #7B2FBE; border-color: #7B2FBE; background: transparent;"
                                               onmouseover="this.style.backgroundColor='#7B2FBE'; this.style.color='#ffffff';" 
                                               onmouseout="this.style.backgroundColor='transparent'; this.style.color='#7B2FBE';">Applicants</a>                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4 text-muted small">No vacancy entries documented yet. Click 'Post a New Job' to start.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection