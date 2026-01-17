<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $editingImage ? 'Edit Gallery Image' : 'Gallery' }}
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
                <form method="POST" action="{{ $editingImage ? route('admin.gallery.update', $editingImage) : route('admin.gallery.store') }}" enctype="multipart/form-data">
                    @csrf
                    @if($editingImage)
                        @method('PUT')
                    @endif
                    <div class="grid md:grid-cols-2 gap-4">
                        <label class="text-sm text-gray-700 space-y-1">
                            <span>Title</span>
                            <input name="title" class="w-full border rounded px-3 py-2" value="{{ old('title', $editingImage->title ?? '') }}" required>
                        </label>
                        <label class="text-sm text-gray-700 space-y-1">
                            <span>Category</span>
                            <input name="category" class="w-full border rounded px-3 py-2" value="{{ old('category', $editingImage->category ?? '') }}" placeholder="villa / dining / garden">
                        </label>
                        <div class="md:col-span-2 grid md:grid-cols-2 gap-4 border-b pb-4 mb-2">
                            <label class="text-sm text-gray-700 space-y-1">
                                <span class="block font-semibold">Upload Image</span>
                                <input type="file" name="image_file" class="text-sm">
                            </label>
                            <label class="text-sm text-gray-700 space-y-1">
                                <span class="block font-semibold">Or use Image URL</span>
                                <input name="image_url" class="w-full border rounded px-3 py-2" value="{{ old('image_url', $editingImage->image_url ?? '') }}" placeholder="https://...">
                            </label>
                        </div>
                        <label class="text-sm text-gray-700 space-y-1 md:col-span-2">
                            <span>Description</span>
                            <textarea name="description" rows="2" class="w-full border rounded px-3 py-2">{{ old('description', $editingImage->description ?? '') }}</textarea>
                        </label>
                        <label class="flex items-center gap-2 text-sm text-gray-700">
                            <input type="checkbox" name="is_featured" value="1" @checked(old('is_featured', $editingImage->is_featured ?? false))>
                            <span>Featured</span>
                        </label>
                    </div>
                    <div class="mt-4 flex gap-3">
                        <button class="px-4 py-2 bg-indigo-600 text-white rounded shadow">{{ $editingImage ? 'Update Image' : 'Add Image' }}</button>
                        @if($editingImage)
                            <a href="{{ route('admin.gallery.index') }}" class="px-4 py-2 border rounded text-gray-700">Cancel edit</a>
                        @endif
                    </div>
                </form>
            </div>

            <div class="grid md:grid-cols-2 gap-4">
                @foreach($gallery as $item)
                    <div class="bg-white shadow rounded-xl border border-gray-100 overflow-hidden">
                        <img src="{{ str_starts_with($item->image_url, 'http') ? $item->image_url : asset('storage/' . $item->image_url) }}" alt="{{ $item->title }}" class="h-52 w-full object-cover">
                        <div class="p-4 space-y-1">
                            <div class="flex items-center justify-between">
                                <h3 class="font-semibold text-gray-800">{{ $item->title }}</h3>
                                <span class="text-xs px-2 py-1 rounded-full bg-gray-100 text-gray-700">{{ $item->category }}</span>
                            </div>
                            <p class="text-sm text-gray-600">{{ $item->description }}</p>
                            <div class="flex items-center gap-3 pt-2">
                                @if($item->is_featured)
                                    <span class="px-2 py-1 rounded-full text-xs bg-amber-100 text-amber-800">Featured</span>
                                @endif
                                <a href="{{ route('admin.gallery.edit', $item) }}" class="text-indigo-600 hover:underline text-sm">Edit</a>
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
                                                        <h3 class="text-xl font-bold text-gray-900">Confirm Gallery Image Deletion</h3>
                                                        <p class="text-sm text-gray-500">Deleting <strong>{{ $item->title }}</strong> is permanent.</p>
                                                    </div>
                                                </div>

                                                <form action="{{ route('admin.gallery.destroy', $item) }}" method="POST" class="space-y-6">
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
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
