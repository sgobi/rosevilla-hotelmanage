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

        $data['gallery_urls'] = $this->syncGallery($request);

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

        $data['gallery_urls'] = $this->syncGallery($request, $room);

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

    /**
     * Process, merge, sanitize, and synchronize gallery images.
     */
    protected function syncGallery(Request $request, ?Room $room = null): array
    {
        // 1. Determine existing retained items
        $existing = [];

        if ($request->boolean('clear_gallery')) {
            $existing = [];
        } elseif ($request->has('existing_gallery')) {
            $existing = is_array($request->input('existing_gallery')) ? $request->input('existing_gallery') : [];
        } elseif ($request->boolean('gallery_management')) {
            // When submitted from our gallery manager and existing_gallery is empty, all were removed
            $existing = [];
        } elseif ($room && is_array($room->gallery_urls)) {
            $existing = $room->gallery_urls;
        }

        // 2. Parse newly added URLs (comma or newline separated, or array)
        $newUrls = [];
        $rawUrls = $request->input('gallery_urls');
        if (!empty($rawUrls)) {
            $newUrls = $this->stringListToArray($rawUrls);
        }

        // 3. Process newly uploaded files
        $uploaded = [];
        if ($request->hasFile('gallery_files')) {
            foreach ($request->file('gallery_files') as $file) {
                if ($file && $file->isValid()) {
                    $uploaded[] = $file->store('rooms/gallery', 'public');
                }
            }
        }

        // 4. Merge all sources
        $all = array_merge($existing, $newUrls, $uploaded);

        // 5. Sanitize, strip empty/broken entries, trim, and deduplicate
        return collect($all)
            ->map(function ($item) {
                return is_string($item) ? trim($item) : '';
            })
            ->filter(function ($item) {
                return !empty($item) && strlen($item) > 1;
            })
            ->unique()
            ->values()
            ->all();
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
            'featured_image_file' => ['nullable', 'image', 'max:5120'],
            'gallery_urls' => ['nullable'],
            'existing_gallery' => ['nullable', 'array'],
            'existing_gallery.*' => ['nullable', 'string'],
            'clear_gallery' => ['nullable'],
            'gallery_management' => ['nullable'],
            'gallery_files.*' => ['nullable', 'image', 'max:5120'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $data['slug'] = Str::slug($data['slug'] ?? $data['title']);
        $data['is_active'] = $request->boolean('is_active', true);
        $data['amenities'] = $this->stringListToArray($data['amenities'] ?? '');

        unset($data['existing_gallery'], $data['clear_gallery'], $data['gallery_management'], $data['featured_image_file'], $data['gallery_files']);

        return $data;
    }

    protected function stringListToArray(string|array|null $value): array
    {
        if (is_array($value)) {
            return collect($value)
                ->map(fn ($item) => is_string($item) ? trim($item) : '')
                ->filter()
                ->values()
                ->toArray();
        }

        return collect(preg_split('/[\r\n,]+/', (string) $value))
            ->map(fn ($item) => trim($item))
            ->filter()
            ->values()
            ->toArray();
    }
}
