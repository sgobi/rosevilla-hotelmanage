<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $editingEvent ? 'Edit Event Card' : 'Homepage Event Cards' }}
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
                <form method="POST" action="{{ $editingEvent ? route('admin.home-events.update', $editingEvent) : route('admin.home-events.store') }}" enctype="multipart/form-data">
                    @csrf
                    @if($editingEvent)
                        @method('PUT')
                    @endif
                    <div class="grid md:grid-cols-2 gap-4">
                        <label class="text-sm text-gray-700 space-y-1">
                            <span>Title</span>
                            <input name="title" class="w-full border rounded px-3 py-2" value="{{ old('title', $editingEvent->title ?? '') }}" required>
                        </label>
                        <label class="text-sm text-gray-700 space-y-1">
                            <span>Icon</span>
                            <select name="icon" class="w-full border rounded px-3 py-2" required>
                                <option value="heart" {{ old('icon', $editingEvent->icon ?? '') == 'heart' ? 'selected' : '' }}>Heart (Wedding)</option>
                                <option value="building" {{ old('icon', $editingEvent->icon ?? '') == 'building' ? 'selected' : '' }}>Building (Corporate)</option>
                                <option value="cake" {{ old('icon', $editingEvent->icon ?? '') == 'cake' ? 'selected' : '' }}>Cake (Dining)</option>
                                <option value="star" {{ old('icon', $editingEvent->icon ?? '') == 'star' ? 'selected' : '' }}>Star</option>
                                <option value="music" {{ old('icon', $editingEvent->icon ?? '') == 'music' ? 'selected' : '' }}>Music</option>
                                <option value="camera" {{ old('icon', $editingEvent->icon ?? '') == 'camera' ? 'selected' : '' }}>Camera</option>
                            </select>
                        </label>
                        <label class="text-sm text-gray-700 space-y-1 md:col-span-2">
                            <span>Description</span>
                            <textarea name="description" rows="3" class="w-full border rounded px-3 py-2" required>{{ old('description', $editingEvent->description ?? '') }}</textarea>
                        </label>
                        <label class="text-sm text-gray-700 space-y-1">
                            <span>Sort Order</span>
                            <input type="number" name="sort_order" class="w-full border rounded px-3 py-2" value="{{ old('sort_order', $editingEvent->sort_order ?? 0) }}" required>
                        </label>
                        <label class="text-sm text-gray-700 space-y-1">
                            <span>Image</span>
                            @if($editingEvent && $editingEvent->image_path)
                                <div class="mb-2">
                                    <img src="{{ str_starts_with($editingEvent->image_path, 'http') ? $editingEvent->image_path : (file_exists(public_path($editingEvent->image_path)) ? asset($editingEvent->image_path) : asset('storage/' . $editingEvent->image_path)) }}" alt="Preview" class="h-20 w-32 object-cover rounded border">
                                </div>
                            @endif
                            <input type="file" name="image" class="w-full border rounded px-3 py-2" accept="image/*" {{ $editingEvent ? '' : 'required' }}>
                        </label>
                    </div>
                    <div class="mt-4 flex gap-3">
                        <button class="px-4 py-2 bg-indigo-600 text-white rounded shadow">{{ $editingEvent ? 'Update' : 'Add Event Card' }}</button>
                        @if($editingEvent)
                            <a href="{{ route('admin.home-events.index') }}" class="px-4 py-2 border rounded text-gray-700">Cancel edit</a>
                        @endif
                    </div>
                </form>
            </div>

            <div class="grid md:grid-cols-3 gap-4">
                @foreach($events as $event)
                    <div class="bg-white shadow rounded-xl border border-gray-100 overflow-hidden flex flex-col">
                        <div class="h-40 w-full overflow-hidden relative">
                            <img src="{{ str_starts_with($event->image_path, 'http') ? $event->image_path : (file_exists(public_path($event->image_path)) ? asset($event->image_path) : asset('storage/' . $event->image_path)) }}" 
                                 alt="{{ $event->title }}" 
                                 class="w-full h-full object-cover">
                            <div class="absolute top-2 right-2 bg-white/90 p-1 rounded shadow-sm text-indigo-600">
                                @if($event->icon == 'heart')
                                    ❤
                                @elseif($event->icon == 'building')
                                    🏢
                                @elseif($event->icon == 'cake')
                                    🎂
                                @elseif($event->icon == 'star')
                                    ⭐
                                @elseif($event->icon == 'music')
                                    🎵
                                @elseif($event->icon == 'camera')
                                    📷
                                @endif
                            </div>
                        </div>
                        <div class="p-4 space-y-2 flex-grow">
                            <div class="flex items-start justify-between">
                                <div>
                                    <p class="font-semibold text-gray-800">{{ $event->title }}</p>
                                    <p class="text-xs text-gray-400">Order: {{ $event->sort_order }}</p>
                                </div>
                            </div>
                            <p class="text-sm text-gray-600 line-clamp-2">{{ $event->description }}</p>
                            <div class="flex items-center gap-3 mt-4 pt-4 border-t border-gray-50">
                                <a href="{{ route('admin.home-events.edit', $event) }}" class="text-indigo-600 hover:underline text-sm font-medium">Edit</a>
                                
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
                                                        <h3 class="text-xl font-bold text-gray-900">Confirm Deletion</h3>
                                                        <p class="text-sm text-gray-500">Deleting <strong>{{ $event->title }}</strong> is permanent.</p>
                                                    </div>
                                                </div>

                                                <form action="{{ route('admin.home-events.destroy', $event) }}" method="POST" class="space-y-6">
                                                    @csrf
                                                    @method('DELETE')
                                                    
                                                    <div>
                                                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-widest mb-2">Administrator Password</label>
                                                        <input type="password" name="password" required 
                                                               class="w-full border-gray-200 rounded-xl text-sm bg-gray-50 focus:ring-4 focus:ring-red-100 focus:border-red-500 py-3 px-4 transition-all"
                                                               placeholder="Confirm with your password">
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
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
