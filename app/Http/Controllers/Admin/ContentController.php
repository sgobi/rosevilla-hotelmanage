<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContentSetting;
use Illuminate\Http\Request;

class ContentController extends Controller
{
    public function edit()
    {
        return view('admin.content.edit', [
            'content' => ContentSetting::pluck('value', 'key'),
        ]);
    }

    public function update(Request $request)
    {
        $fields = $request->validate([
            'hero_title' => ['required', 'string', 'max:255'],
            'hero_subtitle' => ['nullable', 'string'],
            'about_text' => ['nullable', 'string'],
            'footer_text' => ['nullable', 'string'],
            'contact_phone' => ['nullable', 'string', 'max:120'],
            'contact_email' => ['nullable', 'email'],
            'contact_address' => ['nullable', 'string'],
            'map_embed' => ['nullable', 'string'],
            'signature' => ['nullable', 'image', 'max:2048'],
        ]);

        // Handle signature upload
        if ($request->hasFile('signature')) {
            $path = $request->file('signature')->store('signatures', 'public');
            $fields['signature_path'] = $path;
        }

        foreach ($fields as $key => $value) {
            ContentSetting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        return back()->with('success', 'Content updated.');
    }
}
