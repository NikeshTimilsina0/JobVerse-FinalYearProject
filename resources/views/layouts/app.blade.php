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
            <a class="navbar-brand fw-bold text-primary fs-3" href="/">JobVerse</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-3">
                    
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('/') ? 'active fw-semibold border-bottom border-primary border-3' : '' }}" href="/">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('jobs') ? 'active fw-semibold border-bottom border-primary border-3' : '' }}" href="{{ route('jobs.index') }}">Find Jobs</a>
                    </li>

                    @hasrole('Employer')
                        <li class="nav-item">
                            <a class="nav-link {{ Request::is('employer/dashboard') ? 'active fw-semibold border-bottom border-primary border-3' : '' }}" href="{{ route('employer.dashboard') }}">Dashboard</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ Request::is('employer/jobs*') && !Request::is('employer/jobs/create') ? 'active fw-semibold border-bottom border-primary border-3' : '' }}" href="{{ route('employer.jobs.index') }}">Your Jobs</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ Request::is('employer/applications*') ? 'active fw-semibold border-bottom border-primary border-3' : '' }}" href="{{ route('employer.applications.index') }}">Applicants</a>
                        </li>
                    @endhasrole

                    @auth
                        @if(!auth()->user()->hasRole('Employer'))
                            <li class="nav-item">
                                <a class="nav-link {{ Request::is('my-applications') ? 'active fw-semibold border-bottom border-primary border-3' : '' }}" href="{{ route('candidate.applications') }}">My Applications</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ Request::is('profile*') ? 'active fw-semibold border-bottom border-primary border-3' : '' }}" href="{{ route('profile.edit') }}">My Profile</a>
                            </li>
                        @endif
                    @endauth

                    @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('about') }}">About Us</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('contact') }}">Contact Us</a>
                        </li>
                    @endguest

                </ul>

                <div class="d-flex gap-2 align-items-center">
                    @auth
                        <span class="text-secondary small me-2">Hi, <strong>{{ Auth::user()->name }}</strong></span>
                        
                        @hasrole('Employer')
                            <a href="{{ route('employer.jobs.create') }}" class="btn btn-primary fw-semibold btn-sm px-3">Post a Job</a>
                        @endhasrole

                        <form action="{{ route('logout') }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-outline-secondary fw-semibold btn-sm">Sign Out</button>
                        </form>
                    @else
                        <a href="/login" class="btn btn-outline-primary fw-semibold btn-sm">Sign in</a>
                                            @hasrole('Employer')

                        <a href="/register" class="btn btn-primary fw-semibold btn-sm">Employers / Post Job</a>
                        @endhasrole
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
            <p class="text-muted small mb-0">&copy; 2026 JobVerse, Inc. &bull; Slogan Matching Protocol &bull; All rights reserved.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>