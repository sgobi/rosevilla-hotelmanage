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
                <form method="POST" action="{{ $editingLandmark ? route('admin.landmarks.update', $editingLandmark) : route('admin.landmarks.store') }}" enctype="multipart/form-data">
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
                            <span>Landmark Image</span>
                            @if($editingLandmark && $editingLandmark->image_url)
                                <div class="mb-2">
                                    <img src="{{ str_starts_with($editingLandmark->image_url, 'http') ? $editingLandmark->image_url : asset('storage/' . $editingLandmark->image_url) }}" alt="Preview" class="h-20 w-32 object-cover rounded border">
                                </div>
                            @endif
                            <input type="file" name="image" class="w-full border rounded px-3 py-2" accept="image/*">
                            <p class="text-xs text-gray-500 mt-1">Leave empty to keep current image (if editing) or use URL below.</p>
                        </label>
                        <label class="text-sm text-gray-700 space-y-1 md:col-span-2">
                            <span>Alternatively, Image URL</span>
                            <input name="image_url" class="w-full border rounded px-3 py-2" value="{{ old('image_url', $editingLandmark->image_url ?? '') }}" placeholder="https://example.com/image.jpg">
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
                    <div class="bg-white shadow rounded-xl border border-gray-100 overflow-hidden flex flex-col">
                        @if($landmark->image_url)
                            <div class="h-48 w-full overflow-hidden">
                                <img src="{{ str_starts_with($landmark->image_url, 'http') ? $landmark->image_url : asset('storage/' . $landmark->image_url) }}" 
                                     alt="{{ $landmark->title }}" 
                                     class="w-full h-full object-cover">
                            </div>
                        @else
                            <div class="h-48 w-full bg-gray-100 flex items-center justify-center text-gray-400">
                                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            </div>
                        @endif
                        <div class="p-4 space-y-2 flex-grow">
                            <div class="flex items-start justify-between">
                                <div>
                                    <p class="font-semibold text-gray-800">{{ $landmark->title }}</p>
                                    <p class="text-xs text-gray-500">{{ $landmark->distance }}</p>
                                </div>
                                <span class="text-xs px-2 py-1 rounded-full bg-gray-100 text-gray-700">{{ $landmark->category }}</span>
                            </div>
                            <p class="text-sm text-gray-600 line-clamp-3">{{ $landmark->description }}</p>
                            <div class="flex items-center gap-3 mt-4">
                                @if($landmark->map_link)
                                    <a href="{{ $landmark->map_link }}" target="_blank" class="text-indigo-600 hover:underline text-sm font-medium">Map</a>
                                @endif
                                <a href="{{ route('admin.landmarks.edit', $landmark) }}" class="text-indigo-600 hover:underline text-sm font-medium">Edit</a>
                                <div x-data="{ confirming: false }">
                                    <button @click="confirming = true" class="text-red-600 hover:underline text-sm font-medium">Delete</button>
                                
                                <!-- Modal Backdrop -->
                                <template x-teleport="body">
                                    <div x-show="confirming" 
                                         x-transition:enter="transition ease-out duration-300"
                                         x-transition:enter-start="opacity-0"
                                         x-transition:enter-end="opacity-100"
                                         x-transition:leave="transition ease-in duration-200"
                                         x-transition:leave-start="opacity-100"
                                         x-transition:leave-end="opacity-0"
                                         class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm">
                                        
                                        <!-- Modal Content -->
                                        <div @click.away="confirming = false"
                                             x-show="confirming"
                                             x-transition:enter="transition ease-out duration-300"
                                             x-transition:enter-start="opacity-0 scale-95"
                                             x-transition:enter-end="opacity-100 scale-100"
                                             x-transition:leave="transition ease-in duration-200"
                                             x-transition:leave-start="opacity-100 scale-100"
                                             x-transition:leave-end="opacity-0 scale-95"
                                             class="bg-white rounded-2xl shadow-2xl border border-gray-100 p-8 w-full max-w-md text-left">
                                            
                                            <div class="flex items-center gap-4 mb-6">
                                                <div class="p-3 bg-red-100 rounded-full text-red-600">
                                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                                </div>
                                                <div>
                                                    <h3 class="text-xl font-bold text-gray-900">Confirm Landmark Deletion</h3>
                                                    <p class="text-sm text-gray-500">Deleting <strong>{{ $landmark->title }}</strong> is permanent.</p>
                                                </div>
                                            </div>

                                            <form action="{{ route('admin.landmarks.destroy', $landmark) }}" method="POST" class="space-y-6">
                                                @csrf
                                                @method('DELETE')
                                                
                                                <div>
                                                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-widest mb-2">Administrator Password</label>
                                                    <input type="password" name="password" required 
                                                           class="w-full border-gray-200 rounded-xl text-sm bg-gray-50 focus:ring-4 focus:ring-red-100 focus:border-red-500 py-3 px-4 transition-all"
                                                           placeholder="Confirm with your password">
                                                    @error('password')
                                                        <p class="text-xs text-red-600 font-semibold mt-2">{{ $message }}</p>
                                                    @enderror
                                                </div>

                                                <div class="flex items-center gap-3 pt-2">
                                                    <button type="button" @click="confirming = false"
                                                            class="flex-1 px-4 py-3 border border-gray-200 text-gray-700 rounded-xl text-sm font-bold hover:bg-gray-50 transition-colors">
                                                        Cancel
                                                    </button>
                                                    <button type="submit" 
                                                            class="flex-2 px-8 py-3 bg-red-600 text-white rounded-xl text-sm font-bold hover:bg-red-700 transition shadow-lg shadow-red-200">
                                                        Permanently Delete
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
