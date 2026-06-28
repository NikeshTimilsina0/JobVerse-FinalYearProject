@extends('admin.layouts.master')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Review Context Case #{{ $appeal->id }}</h1>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <div class="card card-outline card-danger">
                    <div class="card-header">
                        <h3 class="card-title">Original Job Posting Metadata</h3>
                    </div>
                    <div class="card-body">
                        <h4>{{ $appeal->userJob->title }}</h4>
                        <p class="text-muted">Employer: {{ $appeal->employer->name }} | ML Flag Score: <strong>{{ number_format($appeal->userJob->fraud_score * 100, 2) }}%</strong></p>
                        <hr>
                        <h5><strong>Description:</strong></h5>
                        <p class="bg-light p-2 border rounded">{{ $appeal->userJob->description }}</p>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card card-outline card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Employer Appeal Argument</h3>
                    </div>
                    <div class="card-body">
                        <blockquote class="quote-primary m-0 mb-3">
                            <p>{{ $appeal->appeal_reason }}</p>
                            <small>Submitted on {{ $appeal->created_at->toDayDateTimeString() }}</small>
                        </blockquote>

                        <hr>

                        <form action="{{ route('admin.appeals.update', $appeal->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="form-group">
                                <label for="status">Verdict Action</label>
                                <select name="status" id="status" class="form-control" {{ $appeal->status !== 'pending' ? 'disabled' : '' }}>
                                    <option value="approved" {{ $appeal->status === 'approved' ? 'selected' : '' }}>Approve Appeal (Mark as Legit & Restore Listing)</option>
                                    <option value="rejected" {{ $appeal->status === 'rejected' ? 'selected' : '' }}>Reject Appeal (Confirm Fraud & Keep Banned)</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="admin_notes">Administrative Decision Logs</label>
                                <textarea name="admin_notes" id="admin_notes" class="form-control" rows="4" placeholder="Log reasoning detail details here..." {{ $appeal->status !== 'pending' ? 'readonly' : '' }}>{{ $appeal->admin_notes }}</textarea>
                            </div>

                            @if($appeal->status === 'pending')
                                <button type="submit" class="btn btn-success btn-block">Commit Verdict Status</button>
                            @else
                                <div class="alert alert-neutral bg-gray disabled text-center font-weight-bold">Verdict finalized. Historical logs locked.</div>
                            @endif
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection