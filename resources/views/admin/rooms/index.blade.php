<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $editingRoom ? 'Edit Room' : 'Rooms & Suites' }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @if(session('success'))
                <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white shadow rounded-xl border border-gray-100 p-6">
                <form method="POST" action="{{ $editingRoom ? route('admin.rooms.update', $editingRoom) : route('admin.rooms.store') }}" enctype="multipart/form-data">
                    @csrf
                    @if($editingRoom)
                        @method('PUT')
                    @endif
                    <div class="grid md:grid-cols-2 gap-4">
                        <label class="text-sm text-gray-700 space-y-1">
                            <span>Title</span>
                            <input name="title" class="w-full border rounded px-3 py-2" value="{{ old('title', $editingRoom->title ?? '') }}" required>
                        </label>
                        <label class="text-sm text-gray-700 space-y-1">
                            <span>Slug</span>
                            <input name="slug" class="w-full border rounded px-3 py-2" value="{{ old('slug', $editingRoom->slug ?? '') }}">
                        </label>
                        <label class="text-sm text-gray-700 space-y-1">
                            <span>Subtitle</span>
                            <input name="subtitle" class="w-full border rounded px-3 py-2" value="{{ old('subtitle', $editingRoom->subtitle ?? '') }}">
                        </label>
                        <label class="text-sm text-gray-700 space-y-1">
                            <span>Price per day (LKR)</span>
                            <input type="number" step="0.01" name="price_per_night" class="w-full border rounded px-3 py-2" value="{{ old('price_per_night', $editingRoom->price_per_night ?? 0) }}" required>
                        </label>
                        <label class="text-sm text-gray-700 space-y-1">
                            <span>Capacity</span>
                            <input type="number" name="capacity" min="1" class="w-full border rounded px-3 py-2" value="{{ old('capacity', $editingRoom->capacity ?? 2) }}">
                        </label>
                        <label class="text-sm text-gray-700 space-y-1">
                            <span>Bed type</span>
                            <input name="bed_type" class="w-full border rounded px-3 py-2" value="{{ old('bed_type', $editingRoom->bed_type ?? '') }}">
                        </label>
                        <label class="text-sm text-gray-700 space-y-1 md:col-span-2">
                            <span>Description</span>
                            <textarea name="description" rows="3" class="w-full border rounded px-3 py-2">{{ old('description', $editingRoom->description ?? '') }}</textarea>
                        </label>
                        <label class="text-sm text-gray-700 space-y-1 md:col-span-2">
                            <span>Amenities (comma or newline separated)</span>
                            <textarea name="amenities" rows="2" class="w-full border rounded px-3 py-2">{{ old('amenities', isset($editingRoom) ? implode(', ', $editingRoom->amenities ?? []) : '') }}</textarea>
                        </label>
                        
                        <div class="md:col-span-2 grid md:grid-cols-2 gap-4 border-t pt-4">
                            <div class="space-y-2">
                                <span class="text-sm font-semibold text-gray-700">Featured Image</span>
                                @if(isset($editingRoom) && $editingRoom->featured_image)
                                    <div class="mb-2">
                                        <img src="{{ str_starts_with($editingRoom->featured_image, 'http') ? $editingRoom->featured_image : asset('storage/' . $editingRoom->featured_image) }}" class="h-20 w-32 object-cover rounded shadow-sm">
                                    </div>
                                @endif
                                <label class="block">
                                    <span class="text-xs text-gray-500 block">Upload new:</span>
                                    <input type="file" name="featured_image_file" class="text-sm">
                                </label>
                                <label class="block mt-2">
                                    <span class="text-xs text-gray-500 block">Or use URL:</span>
                                    <input name="featured_image" class="w-full border rounded px-2 py-1 text-sm" value="{{ old('featured_image', $editingRoom->featured_image ?? '') }}" placeholder="https://...">
                                </label>
                            </div>

                            <div class="space-y-2">
                                <span class="text-sm font-semibold text-gray-700">Gallery Images</span>
                                @if(isset($editingRoom) && !empty($editingRoom->gallery_urls))
                                    <div class="flex gap-1 overflow-x-auto pb-2">
                                        @foreach($editingRoom->gallery_urls as $url)
                                            <img src="{{ str_starts_with($url, 'http') ? $url : asset('storage/' . $url) }}" class="h-10 w-10 object-cover rounded">
                                        @endforeach
                                    </div>
                                @endif
                                <label class="block">
                                    <span class="text-xs text-gray-500 block">Upload files:</span>
                                    <input type="file" name="gallery_files[]" multiple class="text-sm">
                                </label>
                                <label class="block mt-2">
                                    <span class="text-xs text-gray-500 block">Or add URLs (comma/newline separated):</span>
                                    <textarea name="gallery_urls" rows="1" class="w-full border rounded px-2 py-1 text-sm">{{ old('gallery_urls', isset($editingRoom) ? implode(', ', $editingRoom->gallery_urls ?? []) : '') }}</textarea>
                                </label>
                            </div>
                        </div>
                        <label class="flex items-center gap-2 text-sm text-gray-700">
                            <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $editingRoom->is_active ?? true))>
                            <span>Active</span>
                        </label>
                    </div>
                    <div class="mt-4 flex gap-3">
                        <button class="px-4 py-2 bg-indigo-600 text-white rounded shadow">{{ $editingRoom ? 'Update Room' : 'Add Room' }}</button>
                        @if($editingRoom)
                            <a href="{{ route('admin.rooms.index') }}" class="px-4 py-2 border rounded text-gray-700">Cancel edit</a>
                        @endif
                    </div>
                </form>
            </div>

            <div class="bg-white shadow rounded-xl border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-gray-800">All Rooms</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm text-left">
                        <thead class="text-xs uppercase text-gray-500 bg-gray-50">
                            <tr>
                                <th class="px-6 py-3">Title</th>
                                <th class="px-6 py-3">Price</th>
                                <th class="px-6 py-3">Capacity</th>
                                <th class="px-6 py-3">Status</th>
                                <th class="px-6 py-3"></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($rooms as $room)
                                <tr>
                                    <td class="px-6 py-3">
                                        <p class="font-semibold text-gray-800">{{ $room->title }}</p>
                                        <p class="text-gray-500 text-xs">{{ $room->slug }}</p>
                                    </td>
                                    <td class="px-6 py-3 text-gray-700">LKR {{ number_format($room->price_per_night, 0) }} per day</td>
                                    <td class="px-6 py-3 text-gray-700">{{ $room->capacity }}</td>
                                    <td class="px-6 py-3">
                                        <span class="px-2 py-1 rounded-full text-xs font-semibold {{ $room->is_active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-700' }}">
                                            {{ $room->is_active ? 'Active' : 'Hidden' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-3 flex items-center gap-2">
                                        <a href="{{ route('admin.rooms.edit', $room) }}" class="text-indigo-600 hover:underline text-sm">Edit</a>
                                        <div x-data="{ confirming: false }">
                                            <button @click="confirming = true" class="text-red-600 hover:underline text-sm">Delete</button>
                                            
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
                                                                <h3 class="text-xl font-bold text-gray-900">Confirm Room Deletion</h3>
                                                                <p class="text-sm text-gray-500">Deleting <strong>{{ $room->title }}</strong> is permanent.</p>
                                                            </div>
                                                        </div>

                                                        <form action="{{ route('admin.rooms.destroy', $room) }}" method="POST" class="space-y-6">
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
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
