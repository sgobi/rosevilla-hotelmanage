<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GalleryImage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.gallery.index', [
            'gallery' => GalleryImage::latest()->get(),
            'editingImage' => null,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return redirect()->route('admin.gallery.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $this->validatedData($request);

        if ($request->hasFile('image_file')) {
            $data['image_url'] = $request->file('image_file')->store('gallery', 'public');
        }

        GalleryImage::create($data);

        return redirect()->route('admin.gallery.index')->with('success', 'Gallery image added.');
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
    public function edit(GalleryImage $gallery)
    {
        return view('admin.gallery.index', [
            'gallery' => GalleryImage::latest()->get(),
            'editingImage' => $gallery,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, GalleryImage $gallery)
    {
        $data = $this->validatedData($request);

        if ($request->hasFile('image_file')) {
            $data['image_url'] = $request->file('image_file')->store('gallery', 'public');
        }

        $gallery->update($data);

        return redirect()->route('admin.gallery.index')->with('success', 'Gallery image updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, GalleryImage $gallery)
    {
        $request->validate([
            'password' => 'required',
        ]);

        if (!Hash::check($request->password, auth()->user()->password)) {
            return back()->withErrors(['password' => 'Incorrect password. Deletion failed.']);
        }

        $gallery->delete();

        return back()->with('success', 'Gallery image removed.');
    }

    protected function validatedData(Request $request): array
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'category' => ['nullable', 'string', 'max:120'],
            'image_url' => ['nullable', 'string'],
            'image_file' => ['nullable', 'image', 'max:5000'],
            'description' => ['nullable', 'string'],
            'is_featured' => ['nullable', 'boolean'],
        ]);

        $data['is_featured'] = $request->boolean('is_featured', false);

        return $data;
    }
}
