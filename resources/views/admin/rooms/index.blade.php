<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h2 class="text-2xl font-black text-gray-900 leading-tight tracking-tight uppercase">
                    {{ $editingRoom ? 'Configuration: ' . $editingRoom->title : 'Room Inventory Terminal' }}
                </h2>
                <p class="text-[10px] font-black text-amber-600 uppercase tracking-[0.3em] mt-1 italic">Property Asset Management & Rate Control</p>
            </div>
            
            <div class="flex items-center gap-3 bg-white/80 px-5 py-2.5 rounded-2xl border border-gray-100 shadow-sm transition-all hover:shadow-md">
                <div class="h-10 w-10 rounded-xl bg-indigo-600 text-white flex items-center justify-center shadow-lg shadow-indigo-100" style="background: #4f46e5;">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                </div>
                <div>
                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest leading-none mb-1">Asset Count</p>
                    <p class="text-xs font-black text-gray-900 tabular-nums">{{ count($rooms) }} Physical Units</p>
                </div>
            </div>
        </div>
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
                        
                        @php 
                            $currentGallery = old('existing_gallery', isset($editingRoom) && is_array($editingRoom->gallery_urls) ? array_values(array_filter($editingRoom->gallery_urls)) : []); 
                        @endphp

                        <div class="md:col-span-2 space-y-6 border-t pt-5 mt-2">
                            <!-- Featured Image Block -->
                            <div class="bg-gray-50/80 rounded-2xl p-4 sm:p-5 border border-gray-200">
                                <div class="flex items-center justify-between mb-3">
                                    <div>
                                        <span class="text-sm font-bold text-gray-800">Featured / Cover Image</span>
                                        <p class="text-xs text-gray-500">The primary image displayed on cards, banner previews, and landing page.</p>
                                    </div>
                                    @if(isset($editingRoom) && $editingRoom->featured_image)
                                        <span class="text-[10px] font-bold text-emerald-700 bg-emerald-100 px-2 py-0.5 rounded-full">Active</span>
                                    @endif
                                </div>
                                <div class="grid sm:grid-cols-12 gap-4 items-start">
                                    @if(isset($editingRoom) && $editingRoom->featured_image)
                                        <div class="sm:col-span-4 lg:col-span-3">
                                            <div class="relative aspect-[4/3] rounded-xl overflow-hidden border border-gray-200 shadow-sm bg-gray-100">
                                                <img src="{{ str_starts_with($editingRoom->featured_image, 'http') ? $editingRoom->featured_image : asset('storage/' . $editingRoom->featured_image) }}" 
                                                     alt="{{ $editingRoom->title }}" 
                                                     onerror="this.onerror=null; this.src='https://placehold.co/300x200?text=No+Cover';"
                                                     class="w-full h-full object-cover">
                                            </div>
                                        </div>
                                    @endif
                                    <div class="{{ isset($editingRoom) && $editingRoom->featured_image ? 'sm:col-span-8 lg:col-span-9' : 'sm:col-span-12' }} space-y-3">
                                        <label class="block">
                                            <span class="text-xs font-semibold text-gray-700 block mb-1">Upload New Cover File:</span>
                                            <input type="file" name="featured_image_file" accept="image/*" class="w-full text-xs text-gray-600 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 border border-gray-200 rounded-lg p-1 bg-white cursor-pointer">
                                        </label>
                                        <label class="block">
                                            <span class="text-xs font-semibold text-gray-700 block mb-1">Or Direct Image URL:</span>
                                            <input name="featured_image" class="w-full border border-gray-200 rounded-lg px-3 py-2 text-xs focus:ring-2 focus:ring-indigo-100 focus:border-indigo-500 font-mono" value="{{ old('featured_image', $editingRoom->featured_image ?? '') }}" placeholder="https://example.com/cover.jpg">
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <!-- Gallery Images Management (Alpine.js) -->
                            <div x-data="roomGalleryManager({{ json_encode($currentGallery) }})" class="bg-gray-50/80 rounded-2xl p-4 sm:p-5 border border-gray-200 space-y-4">
                                <input type="hidden" name="gallery_management" value="1">
                                <input type="hidden" name="clear_gallery" :value="isCleared ? '1' : '0'">

                                <!-- Hidden inputs for each retained gallery image -->
                                <template x-for="(item, idx) in items" :key="idx">
                                    <input type="hidden" name="existing_gallery[]" :value="item">
                                </template>

                                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 border-b border-gray-200/80 pb-3">
                                    <div>
                                        <div class="flex items-center gap-2">
                                            <span class="text-sm font-bold text-gray-800">Room Gallery Photos</span>
                                            <span class="bg-indigo-100 text-indigo-700 text-xs font-bold px-2 py-0.5 rounded-full tabular-nums" x-text="items.length + ' photos'"></span>
                                        </div>
                                        <p class="text-xs text-gray-500 mt-0.5">Manage existing gallery images, remove broken or unwanted entries, or clear all.</p>
                                    </div>

                                    <!-- Clear All Gallery Button -->
                                    <button type="button" 
                                            @click="clearAll()" 
                                            x-show="items.length > 0"
                                            class="inline-flex items-center gap-1.5 text-xs font-bold text-red-600 hover:text-red-700 bg-red-50 hover:bg-red-100 px-3 py-1.5 rounded-xl border border-red-200 transition shadow-sm self-start sm:self-auto">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        <span>Clear All Gallery</span>
                                    </button>
                                </div>

                                <!-- Thumbnails Grid with Delete Actions -->
                                <div x-show="items.length > 0" class="space-y-2">
                                    <div class="grid grid-cols-2 sm:grid-cols-4 md:grid-cols-6 lg:grid-cols-8 gap-3">
                                        <template x-for="(item, idx) in items" :key="idx">
                                            <div class="relative group aspect-square rounded-xl overflow-hidden border border-gray-200 shadow-sm bg-white flex flex-col justify-between">
                                                <img :src="resolveSrc(item)" 
                                                     :alt="'Gallery ' + (idx + 1)"
                                                     onerror="this.onerror=null; this.src='https://placehold.co/150x150?text=Broken+Image';" 
                                                     class="w-full h-full object-cover">
                                                
                                                <!-- Hover Overlay with Remove Button -->
                                                <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center p-2">
                                                    <button type="button" 
                                                            @click="removeItem(idx)" 
                                                            class="bg-red-600 hover:bg-red-700 text-white p-2 rounded-full shadow-lg transform hover:scale-110 transition flex items-center justify-center focus:outline-none"
                                                            title="Remove this photo">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                                    </button>
                                                </div>

                                                <!-- Top Index Pill -->
                                                <div class="absolute top-1.5 left-1.5 bg-black/70 text-white text-[10px] font-bold px-1.5 py-0.5 rounded-md backdrop-blur-xs pointer-events-none" x-text="idx + 1"></div>
                                                
                                                <!-- Direct Remove Button visible on mobile -->
                                                <button type="button" 
                                                        @click="removeItem(idx)" 
                                                        class="sm:hidden absolute top-1.5 right-1.5 bg-red-600 text-white p-1 rounded-md shadow focus:outline-none"
                                                        title="Remove photo">
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                                </button>

                                                <!-- Bottom Name / Source info -->
                                                <div class="absolute bottom-0 inset-x-0 bg-gradient-to-t from-black/85 via-black/50 to-transparent p-1 text-[9px] text-white/90 truncate font-mono pointer-events-none" x-text="getFilename(item)"></div>
                                            </div>
                                        </template>
                                    </div>
                                </div>

                                <div x-show="items.length === 0" class="py-6 text-center border-2 border-dashed border-gray-300 rounded-xl bg-white/60">
                                    <svg class="mx-auto h-8 w-8 text-gray-400 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    <p class="text-xs font-semibold text-gray-700">No gallery images currently stored.</p>
                                    <p class="text-[11px] text-gray-400 mt-0.5">Use the upload tool or URL input below to add photos to this room.</p>
                                </div>

                                <!-- Add New Gallery Images Controls -->
                                <div class="grid md:grid-cols-2 gap-4 pt-3 border-t border-gray-200/80">
                                    <div class="space-y-1.5">
                                        <label class="block">
                                            <span class="text-xs font-bold text-gray-700 uppercase tracking-wide block mb-1">Upload New Gallery Files</span>
                                            <input type="file" name="gallery_files[]" multiple accept="image/*" class="w-full text-xs text-gray-600 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 border border-gray-200 rounded-lg p-1 bg-white cursor-pointer">
                                        </label>
                                        <p class="text-[11px] text-gray-500">Select one or multiple images from your device (PNG, JPG, WebP). They will be automatically saved and added to the room gallery.</p>
                                    </div>

                                    <div class="space-y-1.5">
                                        <label class="block">
                                            <span class="text-xs font-bold text-gray-700 uppercase tracking-wide block mb-1">Or Add URLs (comma / newline separated)</span>
                                            <textarea name="gallery_urls" rows="2" placeholder="https://example.com/photo1.jpg&#10;https://example.com/photo2.jpg" class="w-full border border-gray-200 rounded-lg px-3 py-2 text-xs focus:ring-2 focus:ring-indigo-100 focus:border-indigo-500 font-mono">{{ old('gallery_urls') }}</textarea>
                                        </label>
                                        <p class="text-[11px] text-gray-500">Paste new image links here (separated by newlines or commas) to append them to the gallery.</p>
                                    </div>
                                </div>
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
                                        <div class="flex items-center gap-3">
                                            @if($room->featured_image)
                                                <img src="{{ str_starts_with($room->featured_image, 'http') ? $room->featured_image : asset('storage/' . $room->featured_image) }}" 
                                                     alt="{{ $room->title }}" 
                                                     class="h-10 w-12 object-cover rounded-lg shadow-xs border border-gray-100 flex-shrink-0"
                                                     onerror="this.onerror=null; this.src='https://placehold.co/100x100?text=Room';">
                                            @endif
                                            <div>
                                                <p class="font-semibold text-gray-800">{{ $room->title }}</p>
                                                <div class="flex items-center gap-2 text-gray-500 text-xs">
                                                    <span>{{ $room->slug }}</span>
                                                    @if(!empty($room->gallery_urls) && count($room->gallery_urls) > 0)
                                                        <span class="inline-flex items-center gap-1 text-[10px] font-bold text-indigo-600 bg-indigo-50 px-1.5 py-0.5 rounded">
                                                            <svg class="w-2.5 h-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                                            {{ count($room->gallery_urls) }} photos
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
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

    @push('scripts')
    <script>
        function roomGalleryManager(initial) {
            return {
                items: Array.isArray(initial) ? initial.filter(Boolean) : [],
                isCleared: false,
                removeItem(index) {
                    this.items.splice(index, 1);
                    if (this.items.length === 0) {
                        this.isCleared = true;
                    }
                },
                clearAll() {
                    if (confirm('Are you sure you want to remove all gallery images from this room?')) {
                        this.items = [];
                        this.isCleared = true;
                    }
                },
                resolveSrc(path) {
                    if (!path) return '';
                    if (path.startsWith('http://') || path.startsWith('https://') || path.startsWith('//')) {
                        return path;
                    }
                    return '/storage/' + path.replace(/^\/+/, '');
                },
                getFilename(path) {
                    if (!path) return '';
                    const parts = path.split('/');
                    return parts[parts.length - 1] || path;
                }
            };
        }
        window.roomGalleryManager = roomGalleryManager;
    </script>
    @endpush
</x-app-layout>
