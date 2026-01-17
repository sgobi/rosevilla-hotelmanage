<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.rooms.index', [
            'rooms' => Room::latest()->get(),
            'editingRoom' => null,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return redirect()->route('admin.rooms.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $this->validatedData($request);

        if ($request->hasFile('featured_image_file')) {
            $data['featured_image'] = $request->file('featured_image_file')->store('rooms', 'public');
        }

        if ($request->hasFile('gallery_files')) {
            $gallery = [];
            foreach ($request->file('gallery_files') as $file) {
                $gallery[] = $file->store('rooms/gallery', 'public');
            }
            $data['gallery_urls'] = array_merge($data['gallery_urls'] ?? [], $gallery);
        }

        Room::create($data);

        return redirect()->route('admin.rooms.index')->with('success', 'Room added successfully.');
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
    public function edit(Room $room)
    {
        return view('admin.rooms.index', [
            'rooms' => Room::latest()->get(),
            'editingRoom' => $room,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Room $room)
    {
        $data = $this->validatedData($request, $room->id);

        if ($request->hasFile('featured_image_file')) {
            $data['featured_image'] = $request->file('featured_image_file')->store('rooms', 'public');
        }

        if ($request->hasFile('gallery_files')) {
            $gallery = [];
            foreach ($request->file('gallery_files') as $file) {
                $gallery[] = $file->store('rooms/gallery', 'public');
            }
            $data['gallery_urls'] = array_merge($data['gallery_urls'] ?? [], $gallery);
        }

        $room->update($data);

        return redirect()->route('admin.rooms.index')->with('success', 'Room updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Room $room)
    {
        $request->validate([
            'password' => 'required',
        ]);

        if (!Hash::check($request->password, auth()->user()->password)) {
            return back()->withErrors(['password' => 'Incorrect password. Deletion failed.']);
        }

        $room->delete();

        return back()->with('success', 'Room removed.');
    }

    protected function validatedData(Request $request, ?int $roomId = null): array
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:rooms,slug,' . $roomId],
            'subtitle' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'amenities' => ['nullable', 'string'],
            'price_per_night' => ['required', 'numeric', 'min:0'],
            'capacity' => ['nullable', 'integer', 'min:1', 'max:12'],
            'bed_type' => ['nullable', 'string', 'max:255'],
            'featured_image' => ['nullable', 'string'],
            'featured_image_file' => ['nullable', 'image', 'max:2048'],
            'gallery_urls' => ['nullable', 'string'],
            'gallery_files.*' => ['nullable', 'image', 'max:2048'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $data['slug'] = Str::slug($data['slug'] ?? $data['title']);
        $data['is_active'] = $request->boolean('is_active', true);
        $data['amenities'] = $this->stringListToArray($data['amenities'] ?? '');
        $data['gallery_urls'] = $this->stringListToArray($data['gallery_urls'] ?? '');

        return $data;
    }

    protected function stringListToArray(?string $value): array
    {
        return collect(preg_split('/[\n,]+/', (string) $value))
            ->map(fn ($item) => trim($item))
            ->filter()
            ->values()
            ->toArray();
    }
}
