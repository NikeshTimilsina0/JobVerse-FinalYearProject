@extends('layouts.app')

@section('content')
<div class="container py-5">

    @if(session('success'))
    <div class="alert alert-success border-0 shadow-sm mb-4">{{ session('success') }}</div>
    @endif
    @if(session('error'))
    <div class="alert alert-warning border-0 shadow-sm mb-4">{{ session('error') }}</div>
    @endif

    <div class="d-flex justify-content-between align-items-center border-bottom pb-4 mb-4" style="border-bottom-color: #7B2FBE; border-bottom-width: 3px;">
        <div>
            <h1 class="fw-bold text-dark mb-1">Manage Your Postings</h1>
            <p class="text-secondary mb-0">Track all published job items and real-time security telemetry data.</p>
        </div>
        <a href="{{ route('employer.jobs.create') }}" class="btn fw-bold"
            style="background-color: #7B2FBE; border-color: #7B2FBE; color: #ffffff;"
            onmouseover="this.style.backgroundColor='#5B1A8A'; this.style.borderColor='#5B1A8A';"
            onmouseout="this.style.backgroundColor='#7B2FBE'; this.style.borderColor='#7B2FBE';">
            <i class="bi bi-plus-lg me-1"></i> Add New Posting
        </a>
    </div>

    <div class="card bg-white border rounded shadow-sm p-4" style="border-color: #7B2FBE;">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Job Specifications</th>
                        <th>Work Context</th>
                        <th>Compensation</th>
                        <th>Risk Metric</th>
                        <th>Visibility</th>
                        <th class="text-end">Options</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($jobs as $job)
                    <tr>
                        <td>
                            <div class="fw-bold text-dark mb-1">{{ $job->title }}</div>
                            <span class="text-muted small"><i class="bi bi-calendar3 me-1"></i>{{ $job->created_at->format('M d, Y') }}</span>
                        </td>
                        <td>
                            <span class="badge bg-light text-dark border mb-1 d-inline-block">{{ $job->work_setting }}</span>
                            <div class="small text-muted"><i class="bi bi-geo-alt"></i> {{ $job->location ?? 'Global / Remote' }}</div>
                        </td>
                        <td class="text-dark small fw-semibold">{{ $job->salary_range ?? 'Undisclosed' }}</td>
                        <td>
                            <span class="fw-bold {{ $job->is_fraud ? 'text-danger' : 'text-success' }} small">
                                {{ number_format($job->fraud_score * 100, 2) }}%
                            </span>
                        </td>
                        <td>
                            @if($job->is_visible)
                            <span class="badge bg-success-subtle text-success border border-success-subtle">Public</span>
                            @else
                            <span class="badge bg-danger-subtle text-danger border border-danger-subtle">Hidden</span>
                            @endif
                        </td>
                        <td class="text-end">
                            @if($job->is_fraud)
                            <a href="{{ route('employer.appeals.create', $job->id) }}" class="btn btn-sm btn-danger fw-bold shadow-sm">File Appeal</a>
                            @else
                            <span class="text-muted small">No action needed</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted small">No job records registered under this employer account index.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection