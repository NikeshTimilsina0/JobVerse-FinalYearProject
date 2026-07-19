<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use App\Models\UserJob;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class EmployerJobController extends Controller
{
    public function index()
    {
        $jobs = UserJob::where('employer_id', Auth::id())->latest()->get();
        return view('employer.jobs.index', compact('jobs'));
    }

    public function create()
    {
        return view('employer.jobs.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'requirements' => 'nullable|string',
            'salary_range' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',
            'work_setting' => 'required|string|in:Onsite,Remote,Hybrid',
            'has_questions' => 'required|boolean',
        ]);

        $isRemote = $request->work_setting === 'Remote' ? 1 : 0;
        $hasCompanyLogo = Auth::user()->image ? 1 : 0; 

        $payload = [
            'title' => $request->title,
            'description' => $request->description,
            'requirements' => $request->requirements ?? '',
            'company_profile' => Auth::user()->company_profile ?? 'Verified Recruiter Platform Profile Context', 
            'telecommuting' => $isRemote,
            'has_company_logo' => $hasCompanyLogo,
            'has_questions' => (int) $request->has_questions,
        ];

        $fraudScore = 0.0000;
        $isFraud = false;
        $isVisible = true;

        try {
            $response = Http::timeout(4)->post('http://127.0.0.1:5000/predict', $payload);
            if ($response->successful()) {
                $result = $response->json();
                $fraudScore = $result['fraud_score'];
                $isFraud = $result['is_fraud'];
                if ($isFraud) { $isVisible = false; }
            }
        } catch (\Exception $e) {
            Log::error('Fraud detection service error: ' . $e->getMessage());
        }

        UserJob::create([
            'employer_id' => Auth::id(),
            'title' => $request->title,
            'description' => $request->description,
            'requirements' => $request->requirements,
            'salary_range' => $request->salary_range,
            'location' => $request->location,
            'work_setting' => $request->work_setting,
            'telecommuting' => (bool)$isRemote,
            'has_questions' => $request->has_questions,
            'fraud_score' => $fraudScore,
            'is_fraud' => $isFraud,
            'is_visible' => $isVisible,
            'admin_override' => false,
        ]);

        if ($isFraud) {
            return redirect()->route('employer.jobs.index')->with('error', 'Your posting was flagged as suspicious by our automated security filter and is hidden pending review.');
        }

        return redirect()->route('employer.jobs.index')->with('success', 'Job posting published successfully!');
    }
}