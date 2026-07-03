<?php

namespace App\Http\Controllers\Candidate;

use App\Http\Controllers\Controller;
use App\Models\UserJob;
use App\Models\JobApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JobApplicationController extends Controller
{
    /**
     * Display current user's applied listings portfolio
     */
    public function index()
    {
        // Grabs applications belonging to the logged-in candidate
        $applications = JobApplication::where('seeker_id', Auth::id())
            ->with('userJob')
            ->latest()
            ->get();

        return view('public.candidate.applications', compact('applications'));
    }

    /**
     * Execute Application Submission Data Packet
     */
    public function store(Request $request, UserJob $job)
    {
        if (!$job->is_visible) {
            abort(403, 'Action barred.');
        }

        // Verify unique application state to prevent duplicate spamming
        $alreadyApplied = JobApplication::where('job_id', $job->id)
            ->where('seeker_id', Auth::id())
            ->exists();

        if ($alreadyApplied) {
            return redirect()->back()->with('error', 'You have already submitted an application package for this vacancy.');
        }

        $request->validate([
            'cover_letter' => 'required|string|min:15',
        ]);

        JobApplication::create([
            'job_id'       => $job->id,
            'seeker_id'    => Auth::id(),
            'cover_letter' => $request->cover_letter,
            'status'       => 'Pending'
        ]);

        return redirect()->route('jobs.show', $job->id)->with('success', 'Application transmission complete! The employer has been notified.');
    }
}