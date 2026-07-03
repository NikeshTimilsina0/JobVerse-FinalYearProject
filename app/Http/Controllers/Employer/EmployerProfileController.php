<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class EmployerProfileController extends Controller
{
    public function edit()
    {
        // Fallback initialization using the user's base registration name if profile doesn't exist yet
        $profile = Auth::user()->employerProfile()->firstOrCreate([
            'user_id' => Auth::id()
        ], [
            'company_name' => Auth::user()->name
        ]);

        return view('employer.profile', compact('profile'));
    }

    public function update(Request $request)
    {
        $profile = Auth::user()->employerProfile;

        $request->validate([
            'company_name' => 'required|string|max:255',
            'website_url'  => 'nullable|url|max:255',
            'industry'     => 'nullable|string|max:100',
            'company_size' => 'nullable|string|max:50',
            'phone'        => 'nullable|string|max:20',
            'address'      => 'nullable|string|max:255',
            'about'        => 'nullable|string|max:2000',
            'company_logo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $data = $request->only([
            'company_name', 'website_url', 'industry', 'company_size', 'phone', 'address', 'about'
        ]);

        if ($request->hasFile('company_logo')) {
            if ($profile->company_logo) {
                Storage::delete($profile->company_logo);
            }
            $data['company_logo'] = $request->file('company_logo')->store('company_logos', 'public');
        }

        $profile->update($data);

        return redirect()->back()->with('success', 'Your organization profile profile index has been successfully updated.');
    }
}