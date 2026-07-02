<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use App\Models\JobApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmployerApplicationController extends Controller
{
    public function index()
    {
        $employerId = Auth::id();
        $applications = JobApplication::whereHas('userJob', function($q) use ($employerId) {
            $q->where('employer_id', $employerId);
        })->with(['job', 'user'])->latest()->get();

        return view('employer.applications.index', compact('applications'));
    }

    public function show(JobApplication $application)
    {
        if ($application->job->employer_id !== Auth::id()) {
            abort(403, 'Unauthorized access.');
        }
        
        $application->load(['job', 'user']);
        return view('employer.applications.show', compact('application'));
    }

    public function updateStatus(Request $request, JobApplication $application)
    {
        if ($application->job->employer_id !== Auth::id()) {
            abort(403, 'Unauthorized access.');
        }

        $request->validate(['status' => 'required|in:Shortlisted,Rejected']);
        $application->update(['status' => $request->status]);

        return redirect()->back()->with('success', 'Applicant selection status updated.');
    }
}