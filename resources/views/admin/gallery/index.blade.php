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
                                <form action="{{ route('admin.gallery.destroy', $item) }}" method="POST" onsubmit="return confirm('Delete this image?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-red-600 hover:underline text-sm">Delete</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
