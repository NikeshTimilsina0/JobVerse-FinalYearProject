@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="border-bottom pb-4 mb-4">
        <h1 class="fw-bold text-dark mb-1">Incoming Applications</h1>
        <p class="text-secondary mb-0">Evaluate candidates running through your active screener queues.</p>
    </div>

    <div class="card bg-white border rounded shadow-sm p-4">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Candidate</th>
                        <th>Target Position</th>
                        <th>Applied On</th>
                        <th>Status</th>
                        <th class="text-end">Evaluation Link</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($applications as $app)
                        <tr>
                            <td>
                                <div class="fw-bold text-dark">{{ $app->user->name }}</div>
                                <span class="text-muted small">{{ $app->user->email }}</span>
                            </td>
                            <td><span class="fw-semibold text-secondary">{{ $app->job->title }}</span></td>
                            <td class="small text-muted">{{ $app->created_at->format('M d, Y') }}</td>
                            <td>
                                <span class="badge border @if($app->status === 'Pending') bg-warning-subtle text-warning border-warning-subtle @elif($app->status === 'Shortlisted') bg-success-subtle text-success border-success-subtle @else bg-danger-subtle text-danger border-danger-subtle @endif">
                                    {{ $app->status }}
                                </span>
                            </td>
                            <td class="text-end">
                                <a href="{{ route('employer.applications.show', $app->id) }}" class="btn btn-sm btn-outline-primary fw-bold">Review Profile</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted small">No application files have been submitted into your matching channels yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection