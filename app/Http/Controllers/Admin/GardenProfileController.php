<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Garden;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GardenProfileController extends Controller
{
    public function edit()
    {
        $garden = Garden::first() ?? new Garden([
            'title' => 'Reserve the Garden',
            'description' => 'Our scenic gardens provide a perfect backdrop for your most magical moments. Reserve exclusive access for your event or gathering with dedicated concierge service.',
            'max_guests' => 1000,
            'features' => ['Up to 1000 Guests', 'Custom Rituals'],
            'price_per_day' => 30000.00,
            'image_path' => 'garden/garden img.png'
        ]);

        return view('admin.garden-profile.edit', compact('garden'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'max_guests' => 'required|integer|min:1',
            'price_per_day' => 'required|numeric|min:0',
            'features' => 'nullable|array',
            'features.*' => 'string|max:255',
            'image' => 'nullable|mimes:jpeg,jpg,png,webp,gif|max:10240'
        ]);

        $garden = Garden::first() ?? new Garden();
        $garden->fill($validated);

        if ($request->hasFile('image')) {
            if ($garden->image_path && Storage::disk('public')->exists($garden->image_path) && !str_starts_with($garden->image_path, 'garden/garden img')) {
                Storage::disk('public')->delete($garden->image_path);
            }
            $garden->image_path = $request->file('image')->store('garden', 'public');
        } elseif (!$garden->exists && empty($garden->image_path)) {
             $garden->image_path = 'garden/garden img.png';
        }

        // Handle empty features list
        if (!isset($validated['features'])) {
            $garden->features = [];
        }

        $garden->save();

        return redirect()->route('admin.garden-profile.edit')->with('success', 'Garden profile updated successfully.');
    }
}
