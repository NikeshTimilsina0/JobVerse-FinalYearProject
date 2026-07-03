@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="border-bottom pb-4 mb-4">
        <h1 class="fw-bold text-dark mb-1">My Application Portfolios</h1>
        <p class="text-secondary mb-0">Review real-time status updates for positions you have applied to.</p>
    </div>

    <div class="card bg-white border rounded shadow-sm p-4">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Target Position</th>
                        <th>Compensation Estimate</th>
                        <th>Dispatched Date</th>
                        <th>Workflow Tracker Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($applications as $app)
                        <tr>
                            <td>
                                <a href="{{ route('jobs.show', $app->userJob->id) }}" class="fw-bold text-dark text-decoration-none d-block mb-1">{{ $app->userJob->title }}</a>
                                <span class="text-muted small"><i class="bi bi-geo-alt me-1"></i> {{ $app->userJob->location ?? 'Remote Base' }}</span>
                            </td>
                            <td class="small fw-semibold text-secondary">{{ $app->userJob->salary_range ?? 'Undisclosed' }}</td>
                            <td class="small text-muted">{{ $app->created_at->format('M d, Y') }}</td>
                            <td>
                                <span class="badge border @if($app->status === 'Pending') bg-warning-subtle text-warning border-warning-subtle @elif($app->status === 'Shortlisted') bg-success-subtle text-success border-success-subtle @else bg-danger-subtle text-danger border-danger-subtle @endif">
                                    {{ $app->status }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-5 text-muted small">You have not submitted any application packages into the tracking pipeline indexes yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection