@extends('layouts.app')

@section('content')
<header class="py-5 bg-white border-bottom text-center">
    <div class="container py-4">
        <span class="badge px-3 py-2 rounded-pill fw-bold text-uppercase small mb-3" 
              style="background-color: #f0e6ff; color: #5B1A8A; border: 1px solid #D4B8FF;">
            Verified Employment Hub
        </span>
        <h1 class="display-5 fw-bold text-dark mb-3">Find your next technical opportunity.</h1>
        <p class="fs-5 text-secondary mb-5 mx-lg-5">JobVerse matches candidates directly with verified organizations running live, unflagged business infrastructures.</p>

        <form action="{{ route('jobs.index') }}" method="GET" class="row g-2 justify-content-center mx-auto bg-light p-3 border rounded shadow-sm" style="max-width: 768px;">
            <div class="col-md-5">
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0 text-muted"><i class="bi bi-search"></i></span>
                    <input type="text" name="search" class="form-control border-start-0" placeholder="Job titles, keywords, skills...">
                </div>
            </div>
            <div class="col-md-4">
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0 text-muted"><i class="bi bi-geo-alt"></i></span>
                    <input type="text" name="location" class="form-control border-start-0" placeholder="City or region...">
                </div>
            </div>
            <div class="col-md-3 d-grid">
                <button type="submit" class="btn fw-bold" style="background-color: #7B2FBE; border-color: #7B2FBE; color: #ffffff;" 
                        onmouseover="this.style.backgroundColor='#5B1A8A'; this.style.borderColor='#5B1A8A';" 
                        onmouseout="this.style.backgroundColor='#7B2FBE'; this.style.borderColor='#7B2FBE';">Find Jobs</button>
            </div>
        </form>
    </div>
</header>

<section class="container py-5">
    <h2 class="h4 fw-bold text-dark text-center text-md-start mb-4">Latest Verified Openings</h2>
    <div class="row g-3">
        @forelse($featuredJobs as $job)
            <div class="col-md-4">
                <div class="card bg-white border h-100 p-4 shadow-sm d-flex flex-column justify-content-between">
                    <div>
                        <span class="badge bg-light text-secondary border mb-2">{{ $job->work_setting }}</span>
                        <h3 class="h5 fw-bold text-dark mb-1">{{ $job->title }}</h3>
                        <p class="text-muted small mb-3"><i class="bi bi-geo-alt"></i> {{ $job->location ?? 'Remote' }}</p>
                        <p class="text-secondary small mb-0" style="display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden;">{{ Str::limit($job->description, 140) }}</p>
                    </div>
                    <div class="pt-3 border-top mt-3 d-flex justify-content-between align-items-center">
                        <span class="fw-bold small" style="color: #5B1A8A;">{{ $job->salary_range ?? 'Negotiable' }}</span>
                        <a href="{{ route('jobs.show', $job->id) }}" class="btn btn-sm fw-semibold" 
                           style="color: #7B2FBE; border-color: #7B2FBE; background: transparent;"
                           onmouseover="this.style.backgroundColor='#7B2FBE'; this.style.color='#ffffff';" 
                           onmouseout="this.style.backgroundColor='transparent'; this.style.color='#7B2FBE';">View Details</a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-4 text-muted">No vacancies are currently active on the main indexing channels.</div>
        @endforelse
    </div>
</section>
@endsection