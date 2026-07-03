<?php

namespace App\Http\Controllers\Candidate;

use App\Http\Controllers\Controller;
use App\Models\UserJob;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JobFeedController extends Controller
{
    /**
     * Home Page (Hero section + 3 newest featured safe listings)
     */
    public function home()
    {
        
        $featuredJobs = UserJob::where('is_visible', true)
            ->latest()
            ->take(3)
            ->get();

        return view('public.home', compact('featuredJobs'));
    } 

    /**
     * Complete Filterable Job Feed (Indeed-Style Split View Layout)
     */
    public function index(Request $request)
    {
        $query = UserJob::where('is_visible', true)->latest();

        // Keyword Title/Description Searching
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        // Location Targeting
        if ($request->filled('location')) {
            $query->where('location', 'like', '%' . $request->location . '%');
        }

        // Work Setting Filtering
        if ($request->filled('work_setting')) {
            $query->where('work_setting', $request->work_setting);
        }

        $jobs = $query->paginate(10)->withQueryString();

        return view('public.jobs.index', compact('jobs'));
    }

    /**
     * Individual Job View Profile Detail Page
     */
    public function show(UserJob $job)
    {
        // Prevent seeing fraud items unless an admin manually approved it
        if (!$job->is_visible) {
            abort(404, 'Vacancy listing not found or undergoing safety analysis.');
        }

        $hasApplied = false;
        $applicationStatus = null;

        // If logged in, check if this candidate has already applied to this specific job
        if (Auth::check()) {
            $existingApp = Auth::user()->applications()->where('job_id', $job->id)->first();
            if ($existingApp) {
                $hasApplied = true;
                $applicationStatus = $existingApp->status;
            }
        }

        return view('public.jobs.show', compact('job', 'hasApplied', 'applicationStatus'));
    }
}