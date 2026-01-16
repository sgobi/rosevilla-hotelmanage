<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $editingLandmark ? 'Edit Landmark' : 'Nearby Visits' }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @if(session('success'))
                <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white shadow rounded-xl border border-gray-100 p-6">
                <form method="POST" action="{{ $editingLandmark ? route('admin.landmarks.update', $editingLandmark) : route('admin.landmarks.store') }}">
                    @csrf
                    @if($editingLandmark)
                        @method('PUT')
                    @endif
                    <div class="grid md:grid-cols-2 gap-4">
                        <label class="text-sm text-gray-700 space-y-1">
                            <span>Title</span>
                            <input name="title" class="w-full border rounded px-3 py-2" value="{{ old('title', $editingLandmark->title ?? '') }}" required>
                        </label>
                        <label class="text-sm text-gray-700 space-y-1">
                            <span>Category</span>
                            <input name="category" class="w-full border rounded px-3 py-2" value="{{ old('category', $editingLandmark->category ?? '') }}" placeholder="culture / heritage / nature">
                        </label>
                        <label class="text-sm text-gray-700 space-y-1 md:col-span-2">
                            <span>Description</span>
                            <textarea name="description" rows="3" class="w-full border rounded px-3 py-2">{{ old('description', $editingLandmark->description ?? '') }}</textarea>
                        </label>
                        <label class="text-sm text-gray-700 space-y-1">
                            <span>Distance / timing</span>
                            <input name="distance" class="w-full border rounded px-3 py-2" value="{{ old('distance', $editingLandmark->distance ?? '') }}" placeholder="e.g., 10 minutes">
                        </label>
                        <label class="text-sm text-gray-700 space-y-1">
                            <span>Map link</span>
                            <input name="map_link" class="w-full border rounded px-3 py-2" value="{{ old('map_link', $editingLandmark->map_link ?? '') }}">
                        </label>
                        <label class="text-sm text-gray-700 space-y-1 md:col-span-2">
                            <span>Image URL</span>
                            <input name="image_url" class="w-full border rounded px-3 py-2" value="{{ old('image_url', $editingLandmark->image_url ?? '') }}">
                        </label>
                    </div>
                    <div class="mt-4 flex gap-3">
                        <button class="px-4 py-2 bg-indigo-600 text-white rounded shadow">{{ $editingLandmark ? 'Update' : 'Add Landmark' }}</button>
                        @if($editingLandmark)
                            <a href="{{ route('admin.landmarks.index') }}" class="px-4 py-2 border rounded text-gray-700">Cancel edit</a>
                        @endif
                    </div>
                </form>
            </div>

            <div class="grid md:grid-cols-2 gap-4">
                @foreach($landmarks as $landmark)
                    <div class="bg-white shadow rounded-xl border border-gray-100 p-4 space-y-2">
                        <div class="flex items-start justify-between">
                            <div>
                                <p class="font-semibold text-gray-800">{{ $landmark->title }}</p>
                                <p class="text-xs text-gray-500">{{ $landmark->distance }}</p>
                            </div>
                            <span class="text-xs px-2 py-1 rounded-full bg-gray-100 text-gray-700">{{ $landmark->category }}</span>
                        </div>
                        <p class="text-sm text-gray-600">{{ $landmark->description }}</p>
                        <div class="flex items-center gap-3">
                            @if($landmark->map_link)
                                <a href="{{ $landmark->map_link }}" target="_blank" class="text-indigo-600 hover:underline text-sm">Map</a>
                            @endif
                            <a href="{{ route('admin.landmarks.edit', $landmark) }}" class="text-indigo-600 hover:underline text-sm">Edit</a>
                            <form action="{{ route('admin.landmarks.destroy', $landmark) }}" method="POST" onsubmit="return confirm('Delete this landmark?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline text-sm">Delete</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
