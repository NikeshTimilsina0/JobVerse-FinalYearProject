<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JobAppeal;
use Illuminate\Http\Request;

class AppealController extends Controller
{
    public function index()
    {
        $appeals = JobAppeal::with(['userJob', 'employer'])->latest()->get();
        return view('admin.appeals.index', compact('appeals'));
    }

    public function show(JobAppeal $appeal)
    {
        $appeal->load(['userJob', 'employer']);
        return view('admin.appeals.show', compact('appeal'));
    }

    public function update(Request $request, JobAppeal $appeal)
    {
        $request->validate([
            'status' => 'required|in:approved,rejected',
            'admin_notes' => 'nullable|string',
        ]);

        $appeal->update([
            'status' => $request->status,
            'admin_notes' => $request->admin_notes,
        ]);

        // Handshake logic: if approved, override the ML fraud classification
        if ($request->status === 'approved') {
            $appeal->userJob->update([
                'is_fraud' => false,
                'is_visible' => true,
                'admin_override' => true
            ]);
        }

        return redirect()->route('admin.appeals.index')->with('success', 'Appeal application updated successfully.');
    }
}