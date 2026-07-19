@extends('layouts.app')

@section('title', 'Contact Us - JobVerse')

@section('content')
<div class="container py-5">
    <div class="row g-4 justify-content-center">
        
        <!-- Left Side: Quick Support Details -->
        <div class="col-lg-4">
            <div class="card bg-white border rounded shadow-sm p-4 h-100 d-flex flex-column justify-content-between" style="border-color: #7B2FBE !important;">
                <div>
                    <h1 class="h3 fw-bold text-dark mb-2">Get in Touch</h1>
                    <p class="text-secondary small mb-4">Encountering system index problems or need assistance regarding your developer account profile parameters? Drop us a query packet.</p>

                    <div class="d-flex align-items-start gap-3 mb-3">
                        <span class="fs-5 mt-1" style="color: #7B2FBE;"><i class="bi bi-envelope-at"></i></span>
                        <div>
                            <strong class="text-dark d-block small">Support Terminal Desk</strong>
                            <span class="text-secondary small">support@jobverse.com</span>
                        </div>
                    </div>

                    <div class="d-flex align-items-start gap-3">
                        <span class="fs-5 mt-1" style="color: #7B2FBE;"><i class="bi bi-geo-alt"></i></span>
                        <div>
                            <strong class="text-dark d-block small">Administrative Hub</strong>
                            <span class="text-secondary small">Kathmandu, Nepal</span>
                        </div>
                    </div>
                </div>

                <div class="bg-light p-3 rounded border mt-4" style="border-color: #f0e6ff !important;">
                    <span class="text-muted d-block small mb-1"><i class="bi bi-clock me-1"></i> Operations Response Window:</span>
                    <small class="text-dark fw-medium">Sunday &ndash; Friday (9:00 AM &ndash; 6:00 PM NPT)</small>
                </div>
            </div>
        </div>

        <!-- Right Side: Contact Submission Panel Form -->
        <div class="col-lg-6">
            <div class="card bg-white border rounded shadow-sm p-4 p-md-5" style="border-color: #7B2FBE !important;">
                <h3 class="h4 fw-bold text-dark mb-3">Submit a Inquiry Packet</h3>
                
                @if(session('success'))
                    <div class="alert alert-success border-0 shadow-sm mb-4">
                        {{ session('success') }}
                    </div>
                @endif

                <form action="#" method="POST" onsubmit="event.preventDefault(); alert('Form wiring blueprint placeholder intercepted successfully.');">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold text-secondary">Your Name</label>
                            <input type="text" name="name" class="form-control" placeholder="John Doe" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold text-secondary">Email Address</label>
                            <input type="email" name="email" class="form-control" placeholder="john@example.com" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label small fw-semibold text-secondary">Inquiry Category</label>
                            <select name="subject" class="form-select" required>
                                <option value="General Support">General Support Request</option>
                                <option value="Employer Verification">Employer Verification Audit</option>
                                <option value="Bug Reporting">Technical Bug System Flag</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label small fw-semibold text-secondary">Message Payload Context</label>
                            <textarea name="message" class="form-control" rows="5" placeholder="Elaborate on your account telemetry or core issue detail records..." required></textarea>
                        </div>
                        <div class="col-12 d-grid mt-4">
                            <button type="submit" class="btn fw-bold py-2 shadow-sm" 
                                    style="background-color: #7B2FBE; border-color: #7B2FBE; color: #ffffff;"
                                    onmouseover="this.style.backgroundColor='#5B1A8A'; this.style.borderColor='#5B1A8A';" 
                                    onmouseout="this.style.backgroundColor='#7B2FBE'; this.style.borderColor='#7B2FBE';">Dispatch Message Terminal</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>
@endsection