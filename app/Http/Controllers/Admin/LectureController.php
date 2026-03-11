<?php
// app/Http/Controllers/Admin/LectureController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Track;
use App\Models\Lecture;
use Illuminate\Http\Request;

class LectureController extends Controller
{
    public function index(Request $request)
    {
        $query = Lecture::with('track');
        if ($request->has('track_id')) {
            $query->where('track_id', $request->track_id);
        }
        $lectures = $query->orderBy('order')->get();
        $tracks = Track::orderBy('name')->get();
        return view('admin.skill-garage.lectures.index', compact('lectures', 'tracks'));
    }

    public function create()
    {
        $tracks = Track::orderBy('name')->get();
        return view('admin.skill-garage.lectures.form', [
            'lecture' => new Lecture(),
            'tracks' => $tracks,
            'formAction' => route('admin.lectures.store'),
            'formMethod' => 'POST',
            'buttonText' => 'Create Lecture'
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'track_id' => 'required|exists:tracks,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'video_url' => 'required|url',
            'duration' => 'nullable|integer|min:0',
            'order' => 'integer',
            'is_preview' => 'boolean'
        ]);

        Lecture::create($data);
        return redirect()->route('admin.lectures.index')->with('success', 'Lecture created.');
    }

    public function edit(Lecture $lecture)
    {
        $tracks = Track::orderBy('name')->get();
        return view('admin.skill-garage.lectures.form', [
            'lecture' => $lecture,
            'tracks' => $tracks,
            'formAction' => route('admin.lectures.update', $lecture),
            'formMethod' => 'POST',
            'buttonText' => 'Update Lecture'
        ]);
    }

    public function update(Request $request, Lecture $lecture)
    {
        $data = $request->validate([
            'track_id' => 'required|exists:tracks,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'video_url' => 'required|url',
            'duration' => 'nullable|integer|min:0',
            'order' => 'integer',
            'is_preview' => 'boolean'
        ]);

        $lecture->update($data);
        return redirect()->route('admin.lectures.index')->with('success', 'Lecture updated.');
    }

    public function destroy(Lecture $lecture)
    {
        $lecture->delete();
        return redirect()->route('admin.lectures.index')->with('success', 'Lecture deleted.');
    }
}