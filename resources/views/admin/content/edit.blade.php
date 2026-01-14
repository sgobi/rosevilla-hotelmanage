<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Content Management
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @if(session('success'))
                <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white shadow rounded-xl border border-gray-100 p-6">
                <form method="POST" action="{{ route('admin.content.update') }}" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    <div class="grid md:grid-cols-2 gap-4">
                        <label class="text-sm text-gray-700 space-y-1">
                            <span>Hero title</span>
                            <input name="hero_title" class="w-full border rounded px-3 py-2" value="{{ old('hero_title', $content['hero_title'] ?? '') }}" required>
                        </label>
                        <label class="text-sm text-gray-700 space-y-1">
                            <span>Hero subtitle</span>
                            <input name="hero_subtitle" class="w-full border rounded px-3 py-2" value="{{ old('hero_subtitle', $content['hero_subtitle'] ?? '') }}">
                        </label>
                        <label class="text-sm text-gray-700 space-y-1 md:col-span-2">
                            <span>About</span>
                            <textarea name="about_text" rows="3" class="w-full border rounded px-3 py-2">{{ old('about_text', $content['about_text'] ?? '') }}</textarea>
                        </label>
                        <label class="text-sm text-gray-700 space-y-1">
                            <span>Contact phone</span>
                            <input name="contact_phone" class="w-full border rounded px-3 py-2" value="{{ old('contact_phone', $content['contact_phone'] ?? '') }}">
                        </label>
                        <label class="text-sm text-gray-700 space-y-1">
                            <span>Contact email</span>
                            <input name="contact_email" class="w-full border rounded px-3 py-2" value="{{ old('contact_email', $content['contact_email'] ?? '') }}">
                        </label>
                        <label class="text-sm text-gray-700 space-y-1 md:col-span-2">
                            <span>Address</span>
                            <input name="contact_address" class="w-full border rounded px-3 py-2" value="{{ old('contact_address', $content['contact_address'] ?? '') }}">
                        </label>
                        <label class="text-sm text-gray-700 space-y-1 md:col-span-2">
                            <span>Footer note</span>
                            <textarea name="footer_text" rows="2" class="w-full border rounded px-3 py-2">{{ old('footer_text', $content['footer_text'] ?? '') }}</textarea>
                        </label>
                        <label class="text-sm text-gray-700 space-y-1 md:col-span-2">
                            <span>Map embed iframe URL</span>
                            <input name="map_embed" class="w-full border rounded px-3 py-2" value="{{ old('map_embed', $content['map_embed'] ?? '') }}">
                        </label>
                        <label class="text-sm text-gray-700 space-y-1 md:col-span-2">
                            <span>Invoice Signature</span>
                            @if($content['signature_path'] ?? null)
                                <div class="mb-2">
                                    <img src="{{ asset('storage/' . $content['signature_path']) }}" alt="Current Signature" class="h-16 border rounded p-2">
                                    <p class="text-xs text-gray-500 mt-1">Current signature</p>
                                </div>
                            @endif
                            <input type="file" name="signature" accept="image/*" class="w-full border rounded px-3 py-2">
                            <p class="text-xs text-gray-500">Upload a new signature image (PNG, JPG, max 2MB)</p>
                        </label>
                    </div>
                    <button class="px-4 py-2 bg-indigo-600 text-white rounded shadow">Save Content</button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
