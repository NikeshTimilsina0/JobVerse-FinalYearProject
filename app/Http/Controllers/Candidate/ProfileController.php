<?php

namespace App\Http\Controllers\Candidate;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function edit()
    {
        // Automatically fetch or initialize the single-row profile record matching schema
        $profile = Auth::user()->seekerProfile()->firstOrCreate(['user_id' => Auth::id()]);
        return view('public.candidate.profile', compact('profile'));
    }

    public function update(Request $request)
    {
        $profile = Auth::user()->seekerProfile;

        $request->validate([
            'current_title' => 'nullable|string|max:100',
            'phone'         => 'nullable|string|max:20',
            'availability'  => 'nullable|string|max:50',
            'github_url'    => 'nullable|url',
            'linkedin_url'  => 'nullable|url',
            'summary'       => 'nullable|string|max:1000',
            'skills'        => 'nullable|string', // Comma separated, will convert to JSON array
            'cv_file'       => 'nullable|mimes:pdf,doc,docx|max:4096'
        ]);

        $data = $request->only([
            'current_title', 'phone', 'availability', 'github_url', 'linkedin_url', 'summary'
        ]);

        // Process incoming string input values into explicit JSON matching schema rules
        if ($request->filled('skills')) {
            $skillsArray = array_map('trim', explode(',', $request->skills));
            $data['skills'] = $skillsArray; // Casts automatically to JSON on model save
        }

        // Handle structural document uploads cleanly
        if ($request->hasFile('cv_file')) {
            if ($profile->cv_path) {
                Storage::delete($profile->cv_path);
            }
            $data['cv_path'] = $request->file('cv_file')->store('cv_documents');
        }

        $profile->update($data);

        return redirect()->back()->with('success', 'Your candidate profile configuration index has been updated successfully.');
    }
}