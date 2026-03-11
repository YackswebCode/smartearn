<?php
// app/Http/Controllers/Admin/TrackController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Faculty;
use App\Models\Track;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TrackController extends Controller
{
    public function index(Request $request)
    {
        $query = Track::with('faculty');
        if ($request->has('faculty_id')) {
            $query->where('faculty_id', $request->faculty_id);
        }
        $tracks = $query->orderBy('order')->get();
        $faculties = Faculty::orderBy('name')->get();
        return view('admin.skill-garage.tracks.index', compact('tracks', 'faculties'));
    }

    public function create()
    {
        $faculties = Faculty::orderBy('name')->get();
        return view('admin.skill-garage.tracks.form', [
            'track' => new Track(),
            'faculties' => $faculties,
            'formAction' => route('admin.tracks.store'),
            'formMethod' => 'POST',
            'buttonText' => 'Create Track'
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'faculty_id' => 'required|exists:faculties,id',
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'detailed_explanation' => 'nullable|string',
            'price_monthly' => 'nullable|numeric|min:0',
            'price_quarterly' => 'nullable|numeric|min:0',
            'price_yearly' => 'nullable|numeric|min:0',
            'currency' => 'required|in:NGN,USD,GHS,XAF,KES',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'duration_months' => 'nullable|integer|min:1',
            'is_diploma' => 'boolean',
            'order' => 'integer'
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('tracks', 'public');
        }

        Track::create($data);
        return redirect()->route('admin.tracks.index')->with('success', 'Track created.');
    }

    public function edit(Track $track)
    {
        $faculties = Faculty::orderBy('name')->get();
        return view('admin.skill-garage.tracks.form', [
            'track' => $track,
            'faculties' => $faculties,
            'formAction' => route('admin.tracks.update', $track),
            'formMethod' => 'POST',
            'buttonText' => 'Update Track'
        ]);
    }

    public function update(Request $request, Track $track)
    {
        $data = $request->validate([
            'faculty_id' => 'required|exists:faculties,id',
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'detailed_explanation' => 'nullable|string',
            'price_monthly' => 'nullable|numeric|min:0',
            'price_quarterly' => 'nullable|numeric|min:0',
            'price_yearly' => 'nullable|numeric|min:0',
            'currency' => 'required|in:NGN,USD,GHS,XAF,KES',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'duration_months' => 'nullable|integer|min:1',
            'is_diploma' => 'boolean',
            'order' => 'integer'
        ]);

        if ($request->hasFile('image')) {
            if ($track->image) {
                Storage::disk('public')->delete($track->image);
            }
            $data['image'] = $request->file('image')->store('tracks', 'public');
        }

        $track->update($data);
        return redirect()->route('admin.tracks.index')->with('success', 'Track updated.');
    }

    public function destroy(Track $track)
    {
        // Check if any lectures exist
        if ($track->lectures()->count() > 0) {
            return back()->withErrors(['Cannot delete track with existing lectures.']);
        }
        if ($track->enrollments()->count() > 0) {
            return back()->withErrors(['Cannot delete track with enrollments.']);
        }
        if ($track->image) {
            Storage::disk('public')->delete($track->image);
        }
        $track->delete();
        return redirect()->route('admin.tracks.index')->with('success', 'Track deleted.');
    }
}