@extends('admin.layouts.master')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1><i class="fas fa-gavel"></i> Employer Fraud Appeals Queue</h1>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="container-fluid">
        <div class="card card-warning card-outline">
            <div class="card-body p-0">
                <table class="table table-striped table-valign-middle">
                    <thead>
                        <tr>
                            <th>Appeal ID</th>
                            <th>Job Title</th>
                            <th>Employer</th>
                            <th>Status</th>
                            <th>Submitted At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($appeals as $appeal)
                        <tr>
                            <td>{{ $appeal->id }}</td>
                            <td>{{ $appeal->userJob->title }}</td>
                            <td>{{ $appeal->employer->name }}</td>
                            <td>
                                @if($appeal->status === 'pending')
                                    <span class="badge badge-warning">Pending Review</span>
                                @elseif($appeal->status === 'approved')
                                    <span class="badge badge-success">Approved / Restored</span>
                                @else
                                    <span class="badge badge-danger">Rejected / Banned</span>
                                @endif
                            </td>
                            <td>{{ $appeal->created_at->format('M d, Y') }}</td>
                            <td>
                                <a href="{{ route('admin.appeals.show', $appeal->id) }}" class="btn btn-sm btn-primary">
                                    <i class="fas fa-gavel"></i> Process Appeal
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-4">No validation appeals logged from employers.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection