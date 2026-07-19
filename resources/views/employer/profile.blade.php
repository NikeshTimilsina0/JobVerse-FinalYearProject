@extends('layouts.app')

@section('title', 'Company Profile Setup - JobVerse')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-9">

            @if(session('success'))
                <div class="alert alert-success border-0 shadow-sm mb-4">{{ session('success') }}</div>
            @endif

            <div class="card bg-white border rounded shadow-sm p-4 p-md-5" style="border-color: #7B2FBE;">
                <div class="border-bottom pb-3 mb-4 d-flex align-items-center justify-content-between" style="border-bottom-color: #f0e6ff;">
                    <div>
                        <h1 class="h3 fw-bold text-dark mb-1">Company Profile Workspace</h1>
                        <p class="text-secondary small mb-0">Configure branding parameters that candidates observe when browsing active job vacancy modules.</p>
                    </div>
                    @if($profile->company_logo)
                        <img src="{{ asset('storage/' . $profile->company_logo) }}" alt="Logo Preview" class="rounded border p-1" style="width: 60px; height: 60px; object-fit: cover; border-color: #7B2FBE !important;">
                    @endif
                </div>

                <form action="{{ route('employer.profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold text-secondary">Organization / Company Name</label>
                            <input type="text" name="company_name" class="form-control @error('company_name') is-invalid @enderror" value="{{ old('company_name', $profile->company_name) }}" required>
                            @error('company_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label small fw-semibold text-secondary">Corporate Website URL</label>
                            <input type="url" name="website_url" class="form-control @error('website_url') is-invalid @enderror" value="{{ old('website_url', $profile->website_url) }}" placeholder="https://example.com">
                            @error('website_url') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label small fw-semibold text-secondary">Industry Sector</label>
                            <input type="text" name="industry" class="form-control" value="{{ old('industry', $profile->industry) }}" placeholder="e.g. Software Architecture, FinTech">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label small fw-semibold text-secondary">Company Operational Size</label>
                            <select name="company_size" class="form-select">
                                <option value="1-10" {{ old('company_size', $profile->company_size) == '1-10' ? 'selected' : '' }}>1-10 Employees</option>
                                <option value="11-50" {{ old('company_size', $profile->company_size) == '11-50' ? 'selected' : '' }}>11-50 Employees</option>
                                <option value="51-200" {{ old('company_size', $profile->company_size) == '51-200' ? 'selected' : '' }}>51-200 Employees</option>
                                <option value="201+" {{ old('company_size', $profile->company_size) == '201+' ? 'selected' : '' }}>201+ Scale Corporates</option>
                            </select>
                        </div>
                    </div>

                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold text-secondary">Headquarters Location Address</label>
                            <input type="text" name="address" class="form-control" value="{{ old('address', $profile->address) }}" placeholder="e.g. Kathmandu, Nepal">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label small fw-semibold text-secondary">Contact Hotline / Phone</label>
                            <input type="text" name="phone" class="form-control" value="{{ old('phone', $profile->phone) }}" placeholder="e.g. +977 1-XXXXXX">
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label small fw-semibold text-secondary">Update Branding Logo Image (JPEG/PNG)</label>
                        <input type="file" name="company_logo" class="form-control @error('company_logo') is-invalid @enderror">
                        @error('company_logo') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label small fw-semibold text-secondary">About the Company / Business Profile Context</label>
                        <textarea name="about" class="form-control" rows="5" placeholder="Provide a breakdown of your organizational stack objectives, work culture, or core engineering focus details...">{{ old('about', $profile->about) }}</textarea>
                    </div>

                    <div class="d-grid border-top pt-4" style="border-top-color: #f0e6ff;">
                        <button type="submit" class="btn fw-bold py-2 shadow-sm" 
                                style="background-color: #7B2FBE; border-color: #7B2FBE; color: #ffffff;"
                                onmouseover="this.style.backgroundColor='#5B1A8A'; this.style.borderColor='#5B1A8A';" 
                                onmouseout="this.style.backgroundColor='#7B2FBE'; this.style.borderColor='#7B2FBE';">Commit Profile Updates</button>
                    </div>

                </form>
            </div>

        </div>
    </div>
</div>
@endsection