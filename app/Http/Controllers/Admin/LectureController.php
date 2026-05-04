<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DigitalTrack;
use App\Models\DigitalLecture;
use Illuminate\Http\Request;

class LectureController extends Controller
{
    public function index()
    {
        $lectures = DigitalLecture::with('track')
            ->orderBy('track_id')
            ->orderBy('order')
            ->get();

        return view('admin.lectures.index', compact('lectures'));
    }

    public function create()
    {
        $tracks = DigitalTrack::orderBy('title')->get();
        return view('admin.lectures.create', compact('tracks'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'track_id'  => 'required|exists:digital_tracks,id',
            'title'     => 'required|string|max:255',
            'content'   => 'nullable|string',
            'video_url' => 'nullable|url',
            'order'     => 'nullable|integer',
        ]);

        DigitalLecture::create($data);

        return redirect()->route('admin.lectures.index')->with('success', 'Lecture created.');
    }

    public function edit(DigitalLecture $lecture)
    {
        $tracks = DigitalTrack::orderBy('title')->get();
        return view('admin.lectures.edit', compact('lecture', 'tracks'));
    }

    public function update(Request $request, DigitalLecture $lecture)
    {
        $data = $request->validate([
            'track_id'  => 'required|exists:digital_tracks,id',
            'title'     => 'required|string|max:255',
            'content'   => 'nullable|string',
            'video_url' => 'nullable|url',
            'order'     => 'nullable|integer',
        ]);

        $lecture->update($data);

        return redirect()->route('admin.lectures.index')->with('success', 'Lecture updated.');
    }

    public function destroy(DigitalLecture $lecture)
    {
        $lecture->delete();
        return back()->with('success', 'Lecture deleted.');
    }
}