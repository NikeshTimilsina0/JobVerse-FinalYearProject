@extends('layouts.app')

@section('content')
<div class="container py-5">
    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm mb-4">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger border-0 shadow-sm mb-4">{{ session('error') }}</div>
    @endif

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card bg-white border rounded shadow-sm p-4 p-md-5">
                <div class="border-bottom pb-3 mb-4">
                    <h1 class="h2 fw-bold text-dark mb-1">{{ $job->title }}</h1>
                    <p class="fs-5 text-secondary mb-0">
                        <i class="bi bi-geo-alt me-1"></i> {{ $job->location ?? 'Global Field' }} &bull; 
                        <span class="badge bg-light text-dark border ms-1">{{ $job->work_setting }}</span>
                    </p>
                </div>

                <div class="row g-3 bg-light p-3 rounded border mb-4">
                    <div class="col-sm-6">
                        <span class="text-muted small d-block">Compensation Vector:</span>
                        <strong class="text-dark"><i class="bi bi-cash-stack me-1"></i> {{ $job->salary_range ?? 'Negotiable' }}</strong>
                    </div>
                    <div class="col-sm-6">
                        <span class="text-muted small d-block">Published Cycle:</span>
                        <strong class="text-dark"><i class="bi bi-calendar3 me-1"></i> {{ $job->created_at->format('M d, Y') }}</strong>
                    </div>
                </div>

                <div class="mb-4">
                    <h3 class="h5 fw-bold text-dark mb-2">Job Specifications</h3>
                    <p class="text-secondary" style="white-space: pre-line; line-height: 1.6;">{{ $job->description }}</p>
                </div>

                @if($job->requirements)
                    <div class="mb-0">
                        <h3 class="h5 fw-bold text-dark mb-2">Qualifications Expected</h3>
                        <p class="text-secondary" style="white-space: pre-line; line-height: 1.6;">{{ $job->requirements }}</p>
                    </div>
                @endif
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card bg-white border rounded shadow-sm p-4 sticky-top" style="top: 90px;">
                <h2 class="h5 fw-bold text-dark border-bottom pb-2 mb-3">Application Hub</h2>

                @guest
                    <p class="text-muted small mb-3">Authentication check required to link your developer profile arrays and dispatch application structures.</p>
                    <a href="#" class="btn btn-primary d-grid fw-bold py-2 shadow-sm">Sign In to Apply</a>
                @else
                    @if($hasApplied)
                        <div class="bg-light p-3 border rounded text-center">
                            <span class="text-muted d-block small mb-1">Ecosystem Status Tracker:</span>
                            <span class="badge fs-6 px-3 py-2 border @if($applicationStatus === 'Pending') bg-warning-subtle text-warning border-warning-subtle @elif($applicationStatus === 'Shortlisted') bg-success-subtle text-success border-success-subtle @else bg-danger-subtle text-danger border-danger-subtle @endif">
                                {{ $applicationStatus }}
                            </span>
                        </div>
                    @else
                        @php
                            $profile = Auth::user()->seekerProfile; // Assumes seekerProfile relation on User
                            $hasCv = $profile && $profile->cv_path;
                        @endphp

                        @if(!$hasCv)
                            <div class="alert alert-warning border-warning small mb-3">
                                <i class="bi bi-exclamation-triangle-fill me-1"></i> 
                                <strong>CV Missing!</strong> You must upload a document packet inside your candidate profile parameters before submitting applications.
                            </div>
                            <a href="#" class="btn btn-outline-secondary d-grid fw-bold small">Complete Profile Index &rarr;</a>
                        @else
                            <div class="bg-light p-2 rounded border border-light-subtle mb-3 fs-7 text-secondary">
                                <div class="d-flex justify-content-between mb-1">
                                    <span><i class="bi bi-file-earmark-pdf"></i> Resume Linked:</span>
                                    <span class="text-success fw-bold">Ready</span>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <span><i class="bi bi-github"></i> Developer Sync:</span>
                                    <span>{{ $profile->github_url ? 'Connected' : 'None' }}</span>
                                </div>
                            </div>

                            <form action="{{ route('jobs.apply', $job->id) }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label for="cover_letter" class="form-label fw-bold text-dark small text-uppercase tracking-wide">Cover Letter Pitch</label>
                                    <textarea name="cover_letter" id="cover_letter" class="form-control @error('cover_letter') is-invalid @enderror" rows="5" placeholder="Briefly articulate your core competencies..." required>{{ old('cover_letter') }}</textarea>
                                    @error('cover_letter') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <button type="submit" class="btn btn-primary d-grid w-100 fw-bold py-2 shadow-sm">Submit Application Package</button>
                            </form>
                        @endif
                    @endif
                @endguest
            </div>
        </div>
    </div>
</div>
@endsection