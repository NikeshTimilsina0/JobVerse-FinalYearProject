@extends('layouts.app')

@section('title', 'About Us - JobVerse')

@section('content')
<!-- Hero Header Section -->
<div class="bg-white border-bottom py-5 mb-5 text-center" style="border-bottom-color: #7B2FBE ; border-bottom-width: 3px ;">
    <div class="container py-3">
        <span class="badge px-3 py-2 rounded-pill fw-bold text-uppercase small mb-3" 
              style="background-color: #f0e6ff; color: #5B1A8A; border: 1px solid #D4B8FF;">
            Our Mission
        </span>
        <h1 class="display-5 fw-bold text-dark mb-3">Building a Safer Employment Ecosystem</h1>
        <p class="fs-5 text-secondary mb-0 mx-auto" style="max-width: 700px;">
            JobVerse bridges the gap between talented developers and real organizations, backed by automated compliance checks to ensure every single opening is genuine.
        </p>
    </div>
</div>

<div class="container pb-5">
    <div class="row g-5 align-items-center mb-5">
        <div class="col-lg-6">
            <h2 class="fw-bold text-dark mb-3">Why JobVerse exists</h2>
            <p class="text-secondary" style="line-height: 1.7;">
                Traditional employment boards are cluttered with duplicate listings, stale data, and misleading postings that waste valuable candidate energy. We built JobVerse to shift the control balance back toward real transparency.
            </p>
            <p class="text-secondary" style="line-height: 1.7;">
                By utilizing automated telemetry and screening filters during job submission stages, we block low-quality and high-risk listings before they ever touch your feed panel indices.
            </p>
        </div>
        <div class="col-lg-6">
            <div class="p-4 bg-white border rounded shadow-sm" style="border-color: #7B2FBE !important;">
                <div class="d-flex gap-3 mb-4">
                    <div class="p-3 rounded h4 mb-0" style="background-color: #f0e6ff; color: #7B2FBE;"><i class="bi bi-shield-check"></i></div>
                    <div>
                        <h4 class="fw-bold text-dark mb-1">Algorithmic Auditing</h4>
                        <p class="text-secondary small mb-0">Every listing goes through strict text vector validation checks to verify authenticity indices before publishing.</p>
                    </div>
                </div>
                <div class="d-flex gap-3 mb-4">
                    <div class="p-3 rounded h4 mb-0" style="background-color: #f0e6ff; color: #7B2FBE;"><i class="bi bi-person-workspace"></i></div>
                    <div>
                        <h4 class="fw-bold text-dark mb-1">Direct Communication</h4>
                        <p class="text-secondary small mb-0">Candidates apply using structured profiles linked straight to live recruiter decision queues with zero third-party routing.</p>
                    </div>
                </div>
                <div class="d-flex gap-3">
                    <div class="p-3 rounded h4 mb-0" style="background-color: #f0e6ff; color: #7B2FBE;"><i class="bi bi-code-square"></i></div>
                    <div>
                        <h4 class="fw-bold text-dark mb-1">Built For Tech Profiles</h4>
                        <p class="text-secondary small mb-0">Tailored fields accommodate GitHub code configurations, LinkedIn metrics, and comprehensive experience histories.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection