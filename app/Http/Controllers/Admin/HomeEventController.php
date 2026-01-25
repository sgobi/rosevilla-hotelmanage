<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\HomeEvent;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;

class HomeEventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.home_events.index', [
            'events' => HomeEvent::orderBy('sort_order')->get(),
            'editingEvent' => null,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return redirect()->route('admin.home-events.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'required|image|max:2048',
            'icon' => 'required|string|in:heart,building,cake,star,music,camera',
            'sort_order' => 'required|integer',
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('home_events', 'public');
            $validated['image_path'] = $path;
        }

        HomeEvent::create($validated);

        return redirect()->route('admin.home-events.index')->with('success', 'Event card created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(HomeEvent $homeEvent)
    {
        return view('admin.home_events.index', [
            'events' => HomeEvent::orderBy('sort_order')->get(),
            'editingEvent' => $homeEvent,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, HomeEvent $homeEvent)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|max:2048',
            'icon' => 'required|string|in:heart,building,cake,star,music,camera',
            'sort_order' => 'required|integer',
        ]);

        if ($request->hasFile('image')) {
            // Delete old image
            if ($homeEvent->image_path && Storage::disk('public')->exists($homeEvent->image_path)) {
                Storage::disk('public')->delete($homeEvent->image_path);
            }
            $path = $request->file('image')->store('home_events', 'public');
            $validated['image_path'] = $path;
        }

        $homeEvent->update($validated);

        return redirect()->route('admin.home-events.index')->with('success', 'Event card updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, HomeEvent $homeEvent)
    {
        $request->validate([
            'password' => 'required',
        ]);

        if (!Hash::check($request->password, auth()->user()->password)) {
            return back()->withErrors(['password' => 'Incorrect password. Deletion failed.']);
        }

        if ($homeEvent->image_path && Storage::disk('public')->exists($homeEvent->image_path)) {
            Storage::disk('public')->delete($homeEvent->image_path);
        }
        $homeEvent->delete();

        return redirect()->route('admin.home-events.index')->with('success', 'Event card deleted successfully.');
    }
}
