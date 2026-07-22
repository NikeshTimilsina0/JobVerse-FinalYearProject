@extends('layouts.app')

@section('content')
<div class="bg-white border-bottom py-3">
    <div class="container">
        <form action="{{ route('jobs.index') }}" method="GET" class="row g-2">
            <div class="col-md-4">
                <div class="input-group">
                    <span class="input-group-text bg-white text-muted border-end-0"><i class="bi bi-search"></i></span>
                    <input type="text" name="search" class="form-control border-start-0" value="{{ request('search') }}" placeholder="Job title, keywords, or skills">
                </div>
            </div>
            <div class="col-md-3">
                <div class="input-group">
                    <span class="input-group-text bg-white text-muted border-end-0"><i class="bi bi-geo-alt"></i></span>
                    <input type="text" name="location" class="form-control border-start-0" value="{{ request('location') }}" placeholder="City, district, or region">
                </div>
            </div>
            <div class="col-md-3">
                <select name="work_setting" class="form-select">
                    <option value="">All Work Settings</option>
                    <option value="Onsite" {{ request('work_setting') == 'Onsite' ? 'selected' : '' }}>Onsite</option>
                    <option value="Remote" {{ request('work_setting') == 'Remote' ? 'selected' : '' }}>Remote</option>
                    <option value="Hybrid" {{ request('work_setting') == 'Hybrid' ? 'selected' : '' }}>Hybrid</option>
                </select>
            </div>
            <div class="col-md-2 d-grid">
                <button type="submit" class="btn fw-bold" 
                        style="background-color: #7B2FBE; border-color: #7B2FBE; color: #ffffff;"
                        onmouseover="this.style.backgroundColor='#5B1A8A'; this.style.borderColor='#5B1A8A';" 
                        onmouseout="this.style.backgroundColor='#7B2FBE'; this.style.borderColor='#7B2FBE';">Search</button>
            </div>
        </form>
    </div>
</div>

<div class="container py-4">
    <div class="row g-4">
        <!-- Feed Column -->
        <div class="col-md-5">
            <div class="d-flex flex-column gap-3" id="job-feed-container">
                @forelse($jobs as $index => $feedJob)
                    <div class="card bg-white border rounded shadow-sm p-3 job-item-card {{ $index === 0 ? 'border-2 active-job-card' : '' }}" 
                         style="cursor: pointer; {{ $index === 0 ? 'border-color: #7B2FBE;' : '' }}" 
                         data-id="{{ $feedJob->id }}"
                         data-title="{{ $feedJob->title }}"
                         data-location="{{ $feedJob->location ?? 'Specified Base' }}"
                         data-setting="{{ $feedJob->work_setting }}"
                         data-description="{{ $feedJob->description }}"
                         data-url="{{ route('jobs.show', $feedJob->id) }}"
                         onmouseover="this.style.borderColor='#7B2FBE';" 
                         onmouseout="if(!this.classList.contains('active-job-card')) this.style.borderColor='#dee2e6';"
                         onclick="switchJobPreview(this)">
                        <div class="d-flex justify-content-between mb-1">
                            <h3 class="h5 fw-bold text-dark mb-0">{{ $feedJob->title }}</h3>
                        </div>
                        <p class="text-secondary small mb-2"><i class="bi bi-geo-alt"></i> {{ $feedJob->location ?? 'Nepal (Remote)' }}</p>
                        
                        <div class="mb-2">
                            <span class="badge bg-light text-dark border small me-1">{{ $feedJob->work_setting }}</span>
                            <span class="badge small fw-semibold" style="background-color: #f0e6ff; color: #5B1A8A;">{{ $feedJob->salary_range ?? 'Negotiable' }}</span>
                        </div>

                        <p class="text-muted small mb-0 text-truncate-3">{{ Str::limit($feedJob->description, 140) }}</p>
                        <span class="text-muted fs-7 d-block mt-2">{{ $feedJob->created_at->diffForHumans() }}</span>
                    </div>
                @empty
                    <div class="text-center py-5 bg-white border rounded text-muted small">No vacancies matched your active filter parameters.</div>
                @endforelse

                <div class="mt-2">
                    {{ $jobs->links() }}
                </div>
            </div>
        </div>

        <!-- Live Detail Preview Column -->
        <div class="col-md-7 d-none d-md-block">
            @if($jobs->count() > 0)
                <div id="job-preview-panel" class="card bg-white border rounded shadow-sm p-4 position-sticky" style="top: 90px; z-index: 10; border-color: #7B2FBE !important;">
                    <h2 id="preview-title" class="h4 fw-bold text-dark mb-1">{{ $jobs[0]->title }}</h2>
                    <p id="preview-meta" class="text-muted small mb-3"><i class="bi bi-geo-alt"></i> {{ $jobs[0]->location ?? 'Specified Base' }} &bull; {{ $jobs[0]->work_setting }}</p>
                    <hr>
                    <h4 class="h6 fw-bold text-dark text-uppercase tracking-wide mb-2">Description Snapshot</h4>
                    <p id="preview-description" class="text-secondary small mb-4" style="white-space: pre-line;">{{ Str::limit($jobs[0]->description, 400) }}</p>
                    <a id="preview-link" href="{{ route('jobs.show', $jobs[0]->id) }}" class="btn fw-bold px-4 shadow-sm text-white" 
                       style="background-color: #7B2FBE; border-color: #7B2FBE;"
                       onmouseover="this.style.backgroundColor='#5B1A8A'; this.style.borderColor='#5B1A8A';" 
                       onmouseout="this.style.backgroundColor='#7B2FBE'; this.style.borderColor='#7B2FBE';">View Full Specification Interface &rarr;</a>
                </div>
            @else
                <div class="card bg-light border border-dashed rounded h-100 d-flex align-items-center justify-content-center text-muted p-5">
                    Select an entry from the tracking feed on the left to review processing telemetry parameters.
                </div>
            @endif
        </div>
    </div>
</div>

<script>
function switchJobPreview(cardElement) {
    document.querySelectorAll('.job-item-card').forEach(card => {
        card.classList.remove('active-job-card', 'border-2');
        card.style.borderColor = '#dee2e6';
    });

    cardElement.classList.add('active-job-card', 'border-2');
    cardElement.style.borderColor = '#7B2FBE';

    const title = cardElement.getAttribute('data-title');
    const location = cardElement.getAttribute('data-location');
    const setting = cardElement.getAttribute('data-setting');
    const description = cardElement.getAttribute('data-description');
    const url = cardElement.getAttribute('data-url');

    document.getElementById('preview-title').innerText = title;
    document.getElementById('preview-meta').innerHTML = `<i class="bi bi-geo-alt"></i> ${location} &bull; ${setting}`;
    
    let cutText = description.length > 400 ? description.substring(0, 400) + '...' : description;
    document.getElementById('preview-description').innerText = cutText;
    
    document.getElementById('preview-link').href = url;
}
</script>
@endsection