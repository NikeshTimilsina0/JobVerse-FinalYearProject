@extends('admin.layouts.master')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Job Details Analysis</h1>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h3 class="card-title">{{ $job->title }}</h3>
                    </div>
                    <div class="card-body">
                        <h5><strong>Description:</strong></h5>
                        <p class="bg-light p-3 border rounded">{{ $job->description }}</p>

                        <h5><strong>Requirements:</strong></h5>
                        <p class="bg-light p-3 border rounded">{{ $job->requirements ?? 'N/A' }}</p>

                        <div class="row mt-4">
                            <div class="col-sm-4">
                                <strong>Salary Range:</strong> <p>{{ $job->salary_range ?? 'Not Mentioned' }}</p>
                            </div>
                            <div class="col-sm-4">
                                <strong>Location:</strong> <p>{{ $job->location ?? 'N/A' }}</p>
                            </div>
                            <div class="col-sm-4">
                                <strong>Posted By:</strong> <p>{{ $job->employer->name }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card card-danger">
                    <div class="card-header">
                        <h3 class="card-title">ML Fraud Diagnostic</h3>
                    </div>
                    <div class="card-body text-center">
                        <div class="p-3">
                            <h4 class="mb-1">Fraud Probability</h4>
                            <h2 class="text-danger font-weight-bold">{{ number_format($job->fraud_score * 100, 2) }}%</h2>
                        </div>
                        <hr>
                        <ul class="list-group list-group-unbordered mb-3 text-left">
                            <li class="list-group-item">
                                <b>Is Fraud Flagged</b> <span class="float-right text-danger font-weight-bold">{{ $job->is_fraud ? 'YES' : 'NO' }}</span>
                            </li>
                            <li class="list-group-item">
                                <b>Public Visibility</b> <span class="float-right text-secondary font-weight-bold">{{ $job->is_visible ? 'VISIBLE' : 'HIDDEN' }}</span>
                            </li>
                            <li class="list-group-item">
                                <b>Admin Override Action</b> <span class="float-right text-primary font-weight-bold">{{ $job->admin_override ? 'YES' : 'NO' }}</span>
                            </li>
                        </ul>
                        <form action="{{ route('admin.jobs.destroy', $job->id) }}" method="POST" onsubmit="return confirm('Permanently remove this job entry?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-block"><b><i class="fas fa-trash"></i> Delete Fraudulent Post</b></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection