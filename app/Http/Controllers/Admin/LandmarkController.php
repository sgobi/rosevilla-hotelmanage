<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Landmark;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class LandmarkController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.landmarks.index', [
            'landmarks' => Landmark::latest()->get(),
            'editingLandmark' => null,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return redirect()->route('admin.landmarks.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $this->validatedData($request);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('landmarks', 'public');
            $data['image_url'] = $path;
        }

        Landmark::create($data);

        return redirect()->route('admin.landmarks.index')->with('success', 'Landmark added.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Landmark $landmark)
    {
        return view('admin.landmarks.index', [
            'landmarks' => Landmark::latest()->get(),
            'editingLandmark' => $landmark,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Landmark $landmark)
    {
        $data = $this->validatedData($request);

        if ($request->hasFile('image')) {
            // Delete old image if it exists
            if ($landmark->image_url && Storage::disk('public')->exists($landmark->image_url)) {
                Storage::disk('public')->delete($landmark->image_url);
            }
            $path = $request->file('image')->store('landmarks', 'public');
            $data['image_url'] = $path;
        }

        $landmark->update($data);

        return redirect()->route('admin.landmarks.index')->with('success', 'Landmark updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Landmark $landmark)
    {
        $request->validate([
            'password' => 'required',
        ]);

        if (!Hash::check($request->password, auth()->user()->password)) {
            return back()->withErrors(['password' => 'Incorrect password. Deletion failed.']);
        }

        // Delete image file if it exists
        if ($landmark->image_url && Storage::disk('public')->exists($landmark->image_url)) {
            Storage::disk('public')->delete($landmark->image_url);
        }

        $landmark->delete();

        return back()->with('success', 'Landmark removed.');
    }

    protected function validatedData(Request $request): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'distance' => ['nullable', 'string', 'max:120'],
            'map_link' => ['nullable', 'url'],
            'image' => ['nullable', 'image', 'max:2048'], // Added image validation
            'image_url' => ['nullable'], // URL field can still be used as fallback or path
            'category' => ['nullable', 'string', 'max:120'],
        ]);
    }
}
