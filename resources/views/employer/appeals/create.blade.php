@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-7 col-md-9">
            
            <div class="card bg-white border rounded shadow-sm p-4 p-md-5">
                <div class="border-bottom pb-3 mb-4">
                    <span class="badge bg-danger-subtle text-danger border border-danger-subtle mb-2">False Positive Escalation</span>
                    <h1 class="h3 fw-bold text-dark mb-1">File System Administrative Appeal</h1>
                    <p class="text-muted small mb-0">Dispute automated classification results for posting: <strong>{{ $job->title }}</strong></p>
                </div>

                <div class="alert alert-info border-0 small mb-4 shadow-sm">
                    <i class="bi bi-info-circle-fill me-2"></i> Our background machine learning scoring pipeline flagged this item. Submit context clarifying operational validity to initialize human `admin_override` processing.
                </div>

                <form action="{{ route('employer.appeals.store', $job->id) }}" method="POST">
                    @csrf

                    <div class="mb-4">
                        <label for="reason" class="form-label fw-bold text-dark small text-uppercase tracking-wide">Appeal Justification Statement</label>
                        <textarea class="form-control @error('reason') is-invalid @enderror" id="reason" name="reason" rows="6" placeholder="Provide verifying corporate metrics, company registration details, or context proving this vacancy is fully authentic..." required>{{ old('reason') }}</textarea>
                        @error('reason') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        <div class="form-text text-muted small mt-1">Provide an explanatory statement containing at least 20 character tokens.</div>
                    </div>

                    <div class="d-flex align-items-center justify-content-end gap-3 pt-3 border-top">
                        <a href="{{ route('employer.jobs.index') }}" class="btn btn-link text-decoration-none text-secondary fw-semibold">Cancel</a>
                        <button type="submit" class="btn btn-dark px-4 py-2 fw-bold shadow-sm">Transmit Appeal Package</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
@endsection