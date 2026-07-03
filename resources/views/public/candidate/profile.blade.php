@extends('layouts.app')

@section('title', 'Manage My Profile - JobVerse')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-9">
            
            @if(session('success'))
                <div class="alert alert-success border-0 shadow-sm mb-4">{{ session('success') }}</div>
            @endif

            <div class="card bg-white border rounded shadow-sm p-4 p-md-5">
                <div class="border-bottom pb-3 mb-4">
                    <h1 class="h3 fw-bold text-dark mb-1">Developer Profile Index</h1>
                    <p class="text-secondary mb-0">Ensure your workspace parameters are filled to satisfy requirements for incoming applications.</p>
                </div>

                <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold text-secondary">Current Professional Title</label>
                            <input type="text" name="current_title" class="form-control" value="{{ old('current_title', $profile->current_title) }}" placeholder="e.g. Full Stack Engineer / BCA Student">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold text-secondary">Contact Phone Number</label>
                            <input type="text" name="phone" class="form-control" value="{{ old('phone', $profile->phone) }}" placeholder="e.g. +977 98XXXXXXXX">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold text-secondary">Employment Availability</label>
                            <select name="availability" class="form-select">
                                <option value="Immediate" {{ old('availability', $profile->availability) == 'Immediate' ? 'selected' : '' }}>Immediate Start</option>
                                <option value="1 Week" {{ old('availability', $profile->availability) == '1 Week' ? 'selected' : '' }}>1 Week Notice</option>
                                <option value="1 Month" {{ old('availability', $profile->availability) == '1 Month' ? 'selected' : '' }}>1 Month Notice</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold text-secondary">Upload Document CV (PDF/Word)</label>
                            <input type="file" name="cv_file" class="form-control">
                            @if($profile->cv_path)
                                <div class="form-text text-success small"><i class="bi bi-check-circle-fill"></i> Document saved in system index.</div>
                            @endif
                        </div>
                    </div>

                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold text-secondary">GitHub URL Repository Track</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light text-muted"><i class="bi bi-github"></i></span>
                                <input type="url" name="github_url" class="form-control" value="{{ old('github_url', $profile->github_url) }}" placeholder="https://github.com/yourusername">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold text-secondary">LinkedIn Profile URL</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light text-muted"><i class="bi bi-linkedin"></i></span>
                                <input type="url" name="linkedin_url" class="form-control" value="{{ old('linkedin_url', $profile->linkedin_url) }}" placeholder="https://linkedin.com/in/yourusername">
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label small fw-semibold text-secondary">Core Competencies / Technical Skills (Comma Separated)</label>
                        <input type="text" name="skills" class="form-control" value="{{ old('skills', $profile->skills ? implode(', ', $profile->skills) : '') }}" placeholder="PHP, Laravel, MySQL, Python, React">
                        <div class="form-text text-muted small">Input items divided cleanly by commas to parse into database array metrics.</div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label small fw-semibold text-secondary">Professional Summary</label>
                        <textarea name="summary" class="form-control" rows="4" placeholder="Brief statement detailing structural system development experiences or educational objectives...">{{ old('summary', $profile->summary) }}</textarea>
                    </div>

                    <div class="d-grid border-top pt-4">
                        <button type="submit" class="btn btn-primary fw-bold py-2 shadow-sm">Save Profile Configuration</button>
                    </div>

                </form>
            </div>

        </div>
    </div>
</div>
@endsection