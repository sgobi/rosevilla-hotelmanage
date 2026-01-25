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
            'site_title' => ['required', 'string', 'max:255'],
            'hero_title' => ['required', 'string', 'max:255'],
            'hero_subtitle' => ['nullable', 'string'],
            'about_text' => ['nullable', 'string'],
            'events_title' => ['nullable', 'string', 'max:255'],
            'events_description' => ['nullable', 'string'],
            'footer_text' => ['nullable', 'string'],
            'contact_phone' => ['nullable', 'string', 'max:120'],
            'contact_email' => ['nullable', 'email'],
            'contact_address' => ['nullable', 'string'],
            'map_embed' => ['nullable', 'string'],
            'signature' => ['nullable', 'image', 'max:2048'],
            'logo' => ['nullable', 'image', 'max:2048'],
            'favicon' => ['nullable', 'image', 'max:1024'],
        ]);

        // Handle favicon upload
        if ($request->hasFile('favicon')) {
            $path = $request->file('favicon')->store('favicons', 'public');
            $fields['favicon_path'] = $path;
        }

        // Handle logo upload
        if ($request->hasFile('logo')) {
            $path = $request->file('logo')->store('logos', 'public');
            $fields['logo_path'] = $path;
        }

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
