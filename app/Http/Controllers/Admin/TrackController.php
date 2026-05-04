<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DigitalFaculty;
use App\Models\DigitalTrack;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TrackController extends Controller
{
    public function index()
    {
        $tracks = DigitalTrack::with('faculty')
            ->orderBy('faculty_id')
            ->orderBy('order')
            ->get();

        return view('admin.tracks.index', compact('tracks'));
    }

    public function create()
    {
        $faculties = DigitalFaculty::orderBy('name')->get();
        return view('admin.tracks.create', compact('faculties'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'faculty_id'      => 'required|exists:digital_faculties,id',
            'title'           => 'required|string|max:255',
            'description'     => 'nullable|string',
            'instructors'     => 'nullable|string|max:255',
            'image'           => 'nullable|image|max:2048',
            'rating'          => 'nullable|numeric|min:0|max:5',
            'reviews_count'   => 'nullable|integer|min:0',
            'duration_months' => 'required|integer|min:1',
            'price'           => 'nullable|numeric|min:0',
            'monthly_price'   => 'nullable|numeric|min:0',
            'quarterly_price' => 'nullable|numeric|min:0',
            'one_time_price'  => 'nullable|numeric|min:0',
            'currency'        => 'required|string|max:10',
            'order'           => 'nullable|integer',
            'is_active'       => 'boolean',
        ]);

        $data['slug'] = Str::slug($data['title']);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('tracks', 'public');
        }

        DigitalTrack::create($data);

        return redirect()->route('admin.tracks.index')->with('success', 'Track created.');
    }

    public function edit(DigitalTrack $track)
    {
        $faculties = DigitalFaculty::orderBy('name')->get();
        return view('admin.tracks.edit', compact('track', 'faculties'));
    }

    public function update(Request $request, DigitalTrack $track)
    {
        $data = $request->validate([
            'faculty_id'      => 'required|exists:digital_faculties,id',
            'title'           => 'required|string|max:255',
            'description'     => 'nullable|string',
            'instructors'     => 'nullable|string|max:255',
            'image'           => 'nullable|image|max:2048',
            'rating'          => 'nullable|numeric|min:0|max:5',
            'reviews_count'   => 'nullable|integer|min:0',
            'duration_months' => 'required|integer|min:1',
            'price'           => 'nullable|numeric|min:0',
            'monthly_price'   => 'nullable|numeric|min:0',
            'quarterly_price' => 'nullable|numeric|min:0',
            'one_time_price'  => 'nullable|numeric|min:0',
            'currency'        => 'required|string|max:10',
            'order'           => 'nullable|integer',
            'is_active'       => 'boolean',
        ]);

        $data['slug'] = Str::slug($data['title']);

        if ($request->hasFile('image')) {
            if ($track->image) {
                \Storage::disk('public')->delete($track->image);
            }
            $data['image'] = $request->file('image')->store('tracks', 'public');
        }

        $track->update($data);

        return redirect()->route('admin.tracks.index')->with('success', 'Track updated.');
    }

    public function destroy(DigitalTrack $track)
    {
        $track->delete();
        return back()->with('success', 'Track deleted.');
    }
}