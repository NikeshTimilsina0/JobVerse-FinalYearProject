<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use App\Models\UserJob;
use App\Models\JobAppeal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmployerAppealController extends Controller
{
    public function create(UserJob $job)
    {
        if ($job->employer_id !== Auth::id() || !$job->is_fraud) {
            abort(403, 'Access denied.');
        }
        return view('employer.appeals.create', compact('job'));
    }

    public function store(Request $request, UserJob $job)
{
    if ($job->employer_id !== Auth::id() || !$job->is_fraud) {
        abort(403, 'Access denied.');
    }

    $request->validate(['reason' => 'required|string|min:20']);

    JobAppeal::updateOrCreate(
        ['job_id' => $job->id],
        [
            'employer_id'   => $job->employer_id, 
            'appeal_reason' => $request->reason, 
            'status'        => 'Pending'
        ]
    );

    return redirect()->route('employer.jobs.index')->with('success', 'Your manual administrative review appeal has been submitted.');
}
}