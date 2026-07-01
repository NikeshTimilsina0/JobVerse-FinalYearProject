<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use App\Models\UserJob;
use App\Models\JobApplication;
use Illuminate\Support\Facades\Auth;

class EmployerDashboardController extends Controller
{
    public function index()
    {
        $employerId = Auth::id();

        $stats = [
            'total_jobs'  => UserJob::where('employer_id', $employerId)->count(),
            'active_apps' => JobApplication::whereHas('userJob', function($q) use ($employerId) {
                                 $q->where('employer_id', $employerId);
                             })->where('status', 'Pending')->count(),
            'flagged_jobs'=> UserJob::where('employer_id', $employerId)->where('is_fraud', true)->count(),
        ];

        $recentJobs = UserJob::where('employer_id', $employerId)
            ->latest()
            ->take(5)
            ->get();

        return view('employer.dashboard', compact('stats', 'recentJobs'));
    }
}