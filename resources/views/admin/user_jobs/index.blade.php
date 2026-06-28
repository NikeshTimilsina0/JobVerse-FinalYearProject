@extends('admin.layouts.master')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-danger"><i class="fas fa-shield-alt"></i> Flagged Fraudulent Jobs</h1>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="container-fluid">
        <div class="card card-danger card-outline">
            <div class="card-body p-0">
                <table class="table table-striped table-valign-middle">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Job Title</th>
                            <th>Employer</th>
                            <th>Fraud Score</th>
                            <th>Override Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($jobs as $job)
                        <tr>
                            <td>{{ $job->id }}</td>
                            <td>{{ $job->title }}</td>
                            <td>{{ $job->employer->name }}</td>
                            <td>
                                <span class="badge badge-danger" style="font-size: 14px;">
                                    {{ number_format($job->fraud_score * 100, 2) }}%
                                </span>
                            </td>
                            <td>
                                @if($job->admin_override)
                                    <span class="badge badge-success">Overridden</span>
                                @else
                                    <span class="badge badge-secondary">Automated Active Flag</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.jobs.show', $job->id) }}" class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i> Inspect
                                </a>
                                <form action="{{ route('admin.jobs.destroy', $job->id) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Permanently delete this fraudulent entry?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i> Delete</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-4">No fraudulent job listings currently flagged by the system.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection