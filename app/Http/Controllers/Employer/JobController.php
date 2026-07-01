<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use App\Models\UserJob;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;

class JobController extends Controller
{
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

        // Evaluate model meta flags accurately
        $isTelecommuting = $request->work_setting === 'Remote' ? 1 : 0;
        
        // Dynamically compute logo availability from profile database column
        $hasCompanyLogo = Auth::user()->image ? 1 : 0; 

        // Assemble JSON parameters to perfectly match your Python ColumnTransformer expectations
        $payload = [
            'title' => $request->title,
            'description' => $request->description,
            'requirements' => $request->requirements ?? '',
            'company_profile' => 'Verified Platform Recruiter Profile', 
            'telecommuting' => $isTelecommuting,
            'has_company_logo' => $hasCompanyLogo,
            'has_questions' => (int) $request->has_questions,
        ];

        $fraudScore = 0.0000;
        $isFraud = false;
        $isVisible = true;

        try {
            // Internal network request out to the active Flask server background process
            $response = Http::timeout(5)->post('http://127.0.0.1:5000/predict', $payload);

            if ($response->successful()) {
                $result = $response->json();
                $fraudScore = $result['fraud_score'];
                $isFraud = $result['is_fraud'];
                
                // Hide suspicious postings instantly from search visibility feeds
                if ($isFraud) {
                    $isVisible = false;
                }
            }
        } catch (\Exception $e) {
            // Service fallback path preserves functionality if local server port reboots
        }

        // Persist all data cleanly into MySQL records
        UserJob::create([
            'employer_id' => Auth::id(),
            'title' => $request->title,
            'description' => $request->description,
            'requirements' => $request->requirements,
            'salary_range' => $request->salary_range,
            'location' => $request->location,
            'work_setting' => $request->work_setting,
            'telecommuting' => (bool)$isTelecommuting,
            'has_questions' => $request->has_questions,
            'fraud_score' => $fraudScore,
            'is_fraud' => $isFraud,
            'is_visible' => $isVisible,
            'admin_override' => false,
        ]);

        if ($isFraud) {
            return redirect()->back()->with('error', 'Your posting was flagged as suspicious by our automated security filter and is hidden pending review.');
        }

        return redirect()->back()->with('success', 'Job posting published successfully!');
    }
}