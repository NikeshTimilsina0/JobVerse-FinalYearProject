<?php

namespace App\Http\Controllers\JobSeeker;

use App\Http\Controllers\Controller;
use App\Models\UserJob;
use App\Models\JobApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JobFeedController extends Controller
{
    public function index(Request $request)
    {
        // Only load safe, verified job listings
        $query = UserJob::where('is_visible', true)->latest();

        // Optional Search Filters
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('setting')) {
            $query->where('work_setting', $request->setting);
        }

        $jobs = $query->get();

        // Pick the first job as default preview if available
        $selectedJob = null;
        if ($request->filled('selected')) {
            $selectedJob = UserJob::where('id', $request->selected)->where('is_visible', true)->first();
        }
        if (!$selectedJob) {
            $selectedJob = $jobs->first();
        }

        // Determine if current user already applied to this previewed job
        $hasApplied = false;
        if (Auth::check() && $selectedJob) {
            $hasApplied = JobApplication::where('job_id', $selectedJob->id)
                ->where('seeker_id', Auth::id())
                ->exists();
        }

        return view('jobs.index', compact('jobs', 'selectedJob', 'hasApplied'));
    }

    public function apply(Request $request, UserJob $job)
    {
        if (!$job->is_visible) {
            abort(404, 'Job posting unavailable.');
        }

        $request->validate([
            'cover_letter' => 'required|string|min:15',
        ]);

        $exists = JobApplication::where('job_id', $job->id)
            ->where('seeker_id', Auth::id())
            ->exists();

        if ($exists) {
            return redirect()->back()->with('error', 'You have already applied to this vacancy.');
        }

        // FIX: Removed 'Pending' string insertion which caused enum validation crash.
        // The table default string attribute fallback handles mapping this to 'applied'.
        JobApplication::create([
            'job_id' => $job->id,
            'seeker_id' => Auth::id(),
            'cover_letter' => $request->cover_letter,
            // 'status' => 'applied' <-- You can explicitly pass this if preferred
        ]);

        return redirect()->route('jobs.index', ['selected' => $job->id])
            ->with('success', 'Application package transmitted successfully!');
    }

    public function myApplications()
    {
        // View tracking screen for job seekers to monitor their application statuses
        $applications = JobApplication::where('seeker_id', Auth::id())
            ->with('userJob')
            ->latest()
            ->get();

        return view('jobs.my_applications', compact('applications'));
    }
}