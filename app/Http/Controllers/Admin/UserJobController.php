<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\UserJob;
use Illuminate\Http\Request;

class UserJobController extends Controller
{
    public function index()
    {
        // Admin only manages non-legit (fraudulent) jobs
        $jobs = UserJob::where('is_fraud', true)->with('employer')->latest()->get();
        return view('admin.user_jobs.index', compact('jobs'));
    }

    public function show(UserJob $job)
    {
        // Enforce constraint: Admin can only view/manipulate non-legit jobs
        if (!$job->is_fraud && !$job->admin_override) {
            abort(403, 'Admin cannot manipulate natively legitimate job posts.');
        }

        return view('admin.user_jobs.show', compact('job'));
    }

    public function destroy(UserJob $job)
    {
        if (!$job->is_fraud && !$job->admin_override) {
            abort(403, 'Admin cannot manipulate natively legitimate job posts.');
        }

        $job->delete();
        return redirect()->route('admin.jobs.index')->with('success', 'Fraudulent job listing deleted successfully.');
    }
}