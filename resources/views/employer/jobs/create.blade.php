@extends('layouts.app')

@section('title', 'Post a Job - JobVerse')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10">
            
            @if(session('success'))
                <div class="alert alert-success border-0 shadow-sm mb-4 d-flex align-items-center" role="alert">
                    <i class="bi bi-check-circle-fill fs-4 me-2" style="color: #7B2FBE;"></i>
                    <div>{{ session('success') }}</div>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger border-0 shadow-sm mb-4" role="alert">
                    <div class="d-flex align-items-center mb-2">
                        <i class="bi bi-shield-slash-fill fs-4 text-danger me-2"></i>
                        <strong class="fs-5 text-dark">Automated Security Notice</strong>
                    </div>
                    <p class="mb-0 text-secondary small">{{ session('error') }}</p>
                </div>
            @endif

            <div class="card bg-white border rounded shadow-sm p-4 p-md-5" style="border-color: #7B2FBE;">
                <div class="border-bottom pb-3 mb-4" style="border-bottom-color: #f0e6ff;">
                    <h1 class="h3 fw-bold text-dark mb-1">Create a job posting</h1>
                    <p class="text-muted small mb-0">Provide precise parameters. Your submission passes through real-time structural risk analysis pipelines.</p>
                </div>

                <form action="{{ route('employer.jobs.store') }}" method="POST">
                    @csrf

                    <div class="mb-4">
                        <label for="title" class="form-label fw-bold text-dark small text-uppercase tracking-wide">Job Title</label>
                        <input type="text" class="form-control form-control-lg border @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title') }}" placeholder="e.g. Senior Full Stack Engineer (Laravel & React)" required>
                        @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label for="location" class="form-label fw-bold text-dark small text-uppercase tracking-wide">Location</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0 text-muted" style="color: #7B2FBE;"><i class="bi bi-geo-alt"></i></span>
                                <input type="text" class="form-control border-start-0 @error('location') is-invalid @enderror" id="location" name="location" value="{{ old('location') }}" placeholder="e.g. Kathmandu, Nepal" required>
                            </div>
                            @error('location') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="salary_range" class="form-label fw-bold text-dark small text-uppercase tracking-wide">Salary Estimate</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0 text-muted" style="color: #7B2FBE;"><i class="bi bi-cash-stack"></i></span>
                                <input type="text" class="form-control border-start-0 @error('salary_range') is-invalid @enderror" id="salary_range" name="salary_range" value="{{ old('salary_range') }}" placeholder="e.g. NPR 80,000 - 120,000" required>
                            </div>
                            @error('salary_range') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label for="work_setting" class="form-label fw-bold text-dark small text-uppercase tracking-wide">Work Setting</label>
                            <select class="form-select @error('work_setting') is-invalid @enderror" id="work_setting" name="work_setting" required>
                                <option value="Onsite" {{ old('work_setting') == 'Onsite' ? 'selected' : '' }}>Onsite (Office Base)</option>
                                <option value="Remote" {{ old('work_setting') == 'Remote' ? 'selected' : '' }}>Remote (Work From Home)</option>
                                <option value="Hybrid" {{ old('work_setting') == 'Hybrid' ? 'selected' : '' }}>Hybrid Setup</option>
                            </select>
                            @error('work_setting') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="has_questions" class="form-label fw-bold text-dark small text-uppercase tracking-wide">Applicant Screening</label>
                            <select class="form-select @error('has_questions') is-invalid @enderror" id="has_questions" name="has_questions" required>
                                <option value="0" {{ old('has_questions') == '0' ? 'selected' : '' }}>Standard direct apply</option>
                                <option value="1" {{ old('has_questions') == '1' ? 'selected' : '' }}>Require custom screener question responses</option>
                            </select>
                            @error('has_questions') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="description" class="form-label fw-bold text-dark small text-uppercase tracking-wide">Job Description</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="6" placeholder="Describe the day-to-day responsibilities, tech stack footprint, and team scope details..." required>{{ old('description') }}</textarea>
                        @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-4">
                        <label for="requirements" class="form-label fw-bold text-dark small text-uppercase tracking-wide">Requirements & Qualifications</label>
                        <textarea class="form-control @error('requirements') is-invalid @enderror" id="requirements" name="requirements" rows="4" placeholder="Detail required experience bars, primary software competencies, or needed academic credentials...">{{ old('requirements') }}</textarea>
                        @error('requirements') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="d-flex align-items-center justify-content-end gap-3 pt-3 border-top" style="border-top-color: #f0e6ff;">
                        <a href="/" class="btn btn-link text-decoration-none fw-semibold" style="color: #7B2FBE;" onmouseover="this.style.color='#5B1A8A';" onmouseout="this.style.color='#7B2FBE';">Cancel</a>
                        <button type="submit" class="btn px-4 py-2 fw-bold" 
                                style="background-color: #7B2FBE; border-color: #7B2FBE; color: #ffffff;"
                                onmouseover="this.style.backgroundColor='#5B1A8A'; this.style.borderColor='#5B1A8A';" 
                                onmouseout="this.style.backgroundColor='#7B2FBE'; this.style.borderColor='#7B2FBE';">Continue and Post</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
@endsection