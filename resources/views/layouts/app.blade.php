<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'JobVerse - Best Jobs For You')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
</head>
<body class="bg-light text-dark d-flex flex-column min-vh-100">

    <nav class="navbar navbar-expand-lg navbar-white bg-white border-bottom sticky-top">
        <div class="container">
            <a class="navbar-brand fw-bold fs-3" style="color: #7B2FBE;" href="/">JobVerse</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <!-- Main Navigation Links -->
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-3">
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('/') ? 'active fw-semibold' : '' }}" style="{{ Request::is('/') ? 'border-bottom: 3px solid #7B2FBE;' : '' }}" href="/">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('jobs') ? 'active fw-semibold' : '' }}" style="{{ Request::is('jobs') ? 'border-bottom: 3px solid #7B2FBE;' : '' }}" href="{{ route('jobs.index') }}">Find Jobs</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('about-us') ? 'active fw-semibold' : '' }}" style="{{ Request::is('about-us') ? 'border-bottom: 3px solid #7B2FBE;' : '' }}" href="{{ route('about') }}">About Us</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('contact-us') ? 'active fw-semibold' : '' }}" style="{{ Request::is('contact-us') ? 'border-bottom: 3px solid #7B2FBE;' : '' }}" href="{{ route('contact') }}">Contact Us</a>
                    </li>
                </ul>

                <!-- Right-Side Contextual Panel -->
                <div class="d-flex gap-2 align-items-center">
                    @auth
                        @hasrole('Employer')
                            <a href="{{ route('employer.jobs.create') }}" class="btn fw-semibold btn-sm px-3 me-2" style="background-color: #7B2FBE; border-color: #7B2FBE; color: #ffffff;">Post a Job</a>
                        @endhasrole

                        <!-- Context-Aware User Account Dropdown -->
<div class="dropdown">
    <button class="btn btn-light btn-sm dropdown-toggle px-3 py-2 rounded-pill border d-flex align-items-center gap-1" type="button" data-bs-toggle="dropdown" aria-expanded="false">
        <i class="bi bi-person-circle text-secondary"></i>
        <span class="text-secondary">Hi, <strong class="text-dark">{{ Auth::user()->name }}</strong></span>
    </button>
    <ul class="dropdown-menu dropdown-menu-start dropdown-menu-lg-end shadow border-0 p-2 mt-2" style="border-radius: 12px; min-width: 200px;">
        
        <!-- Employer Context Menu Options -->
        @hasrole('Employer')
            <li>
                <a class="dropdown-item py-2 rounded-3 {{ Request::is('employer/dashboard') ? 'fw-semibold text-white active' : 'text-secondary' }}" 
                   style="{{ Request::is('employer/dashboard') ? 'background-color: #7B2FBE; color: #ffffff;' : '' }} --bs-dropdown-link-active-bg: #fff; --bs-dropdown-link-active-color: #7B2FBE; --bs-dropdown-link-hover-bg: #f1f3f5; --bs-dropdown-link-hover-color: #212529;" 
                   href="{{ route('employer.dashboard') }}">
                    <i class="bi bi-speedometer2 me-2"></i>Dashboard
                </a>
            </li>
            <li>
                <a class="dropdown-item py-2 rounded-3 {{ Request::is('employer/jobs*') ? 'fw-semibold text-white active' : 'text-secondary' }}" 
                   style="{{ Request::is('employer/jobs*') ? 'background-color: #7B2FBE; color: #ffffff;' : '' }} --bs-dropdown-link-active-bg: #fff; --bs-dropdown-link-active-color: #7B2FBE; --bs-dropdown-link-hover-bg: #f1f3f5; --bs-dropdown-link-hover-color: #212529;" 
                   href="{{ route('employer.jobs.index') }}">
                    <i class="bi bi-briefcase me-2"></i>Your Jobs
                </a>
            </li>
            <li>
                <a class="dropdown-item py-2 rounded-3 {{ Request::is('employer/profile') ? 'fw-semibold text-white active' : 'text-secondary' }}" 
                   style="{{ Request::is('employer/profile') ? 'background-color: #7B2FBE; color: #ffffff;' : '' }} --bs-dropdown-link-active-bg: #fff; --bs-dropdown-link-active-color: #7B2FBE; --bs-dropdown-link-hover-bg: #f1f3f5; --bs-dropdown-link-hover-color: #212529;" 
                   href="{{ route('employer.profile.edit') }}">
                    <i class="bi bi-building me-2"></i>Company Profile
                </a>
            </li>
        @endhasrole

        <!-- Candidate Context Menu Options -->
        @if(!auth()->user()->hasRole('Employer'))
            <li>
                <a class="dropdown-item py-2 rounded-3 {{ Request::is('profile') ? 'fw-semibold text-white active' : 'text-secondary' }}" 
                   style="{{ Request::is('profile') ? 'background-color: #7B2FBE; color: #ffffff;' : '' }} --bs-dropdown-link-active-bg: #fff; --bs-dropdown-link-active-color: #7B2FBE; --bs-dropdown-link-hover-bg: #f1f3f5; --bs-dropdown-link-hover-color: #212529;" 
                   href="{{ route('profile.edit') }}">
                    <i class="bi bi-person me-2"></i>My Profile
                </a>
            </li>
            <li>
                <a class="dropdown-item py-2 rounded-3 {{ Request::is('my-applications') ? 'fw-semibold text-white active' : 'text-secondary' }}" 
                   style="{{ Request::is('my-applications') ? 'background-color: #7B2FBE; color: #ffffff;' : '' }} --bs-dropdown-link-active-bg: #fff; --bs-dropdown-link-active-color: #7B2FBE; --bs-dropdown-link-hover-bg: #f1f3f5; --bs-dropdown-link-hover-color: #212529;" 
                   href="{{ route('candidate.applications') }}">
                    <i class="bi bi-file-earmark-text me-2"></i>My Applications
                </a>
            </li>
        @endif

        <li><hr class="dropdown-divider opacity-50"></li>
        <li>
            <form action="{{ route('logout') }}" method="POST" class="p-1">
                @csrf
                <button type="submit" class="dropdown-item py-2 text-danger rounded-3 fw-medium d-flex align-items-center w-100 border-0 bg-transparent" 
                        style="--bs-dropdown-link-active-bg: #fff; --bs-dropdown-link-active-color: #dc3545; --bs-dropdown-link-hover-bg: #ffeef0; --bs-dropdown-link-hover-color: #dc3545;">
                    <i class="bi bi-box-arrow-right me-2"></i>Sign Out
                </button>
            </form>
        </li>
    </ul>
</div>
                    @else
                        <a href="/login" class="btn fw-semibold btn-sm" style="border: 1px solid #7B2FBE; color: #7B2FBE;">Sign in</a>
                        <a href="/register" class="btn fw-semibold btn-sm" style="background-color: #7B2FBE; border-color: #7B2FBE; color: #ffffff;">Register</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <main class="flex-grow-1">
        @yield('content')
    </main>

    <footer class="bg-white border-top py-4 mt-auto">
        <div class="container text-center">
            <p class="text-muted small mb-0">&copy; 2026 JobVerse, Inc. &bull; Find Jobs Easily &bull; All rights reserved.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>