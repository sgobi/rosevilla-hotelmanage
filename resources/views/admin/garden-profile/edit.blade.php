<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Garden Profile</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow rounded-xl border border-gray-100 p-8">

                @if(session('success'))
                    <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded mb-6">
                        {{ session('success') }}
                    </div>
                @endif

                <p class="text-gray-500 text-sm mb-6">Update the public-facing details and photo of the garden. Changes will reflect on the homepage immediately.</p>

                <form action="{{ route('admin.garden-profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Title</label>
                            <input type="text" name="title" value="{{ old('title', $garden->title ?? '') }}"
                                class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-emerald-400 focus:outline-none" required>
                            @error('title') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Price Per Day (LKR)</label>
                            <input type="number" step="0.01" name="price_per_day" value="{{ old('price_per_day', $garden->price_per_day ?? 30000) }}"
                                class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-emerald-400 focus:outline-none" required>
                            @error('price_per_day') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Max Guests</label>
                            <input type="number" name="max_guests" value="{{ old('max_guests', $garden->max_guests ?? 1000) }}"
                                class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-emerald-400 focus:outline-none" required>
                            @error('max_guests') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Description</label>
                        <textarea name="description" rows="4"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-emerald-400 focus:outline-none" required>{{ old('description', $garden->description ?? '') }}</textarea>
                        @error('description') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Features / Highlights</label>
                        <p class="text-xs text-gray-400 mb-3">These appear below the title on the homepage card (e.g. "Up to 1000 Guests", "Live Music").</p>
                        <div id="features-container" class="space-y-2">
                            @php $features = old('features', $garden->features ?? ['Custom Rituals']); @endphp
                            @foreach($features as $feature)
                                <div class="flex gap-2 items-center">
                                    <input type="text" name="features[]" value="{{ $feature }}"
                                        class="flex-1 border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-emerald-400 focus:outline-none">
                                    <button type="button" onclick="this.parentElement.remove()"
                                        class="px-3 py-2 bg-red-50 text-red-500 rounded-lg hover:bg-red-100 text-sm font-bold">✕</button>
                                </div>
                            @endforeach
                        </div>
                        <button type="button" onclick="addFeature()"
                            class="mt-3 text-sm font-semibold text-emerald-600 hover:text-emerald-800">+ Add Feature</button>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Garden Photo</label>
                        @if(isset($garden->image_path) && $garden->image_path)
                            <div class="mb-4">
                                <img src="{{ str_starts_with($garden->image_path, 'http') ? $garden->image_path : asset('storage/' . $garden->image_path) }}"
                                    alt="Garden" class="h-52 rounded-xl object-cover border border-gray-200 shadow-sm">
                                <p class="text-xs text-gray-400 mt-1">Current photo. Upload a new one below to replace it.</p>
                            </div>
                        @endif
                        <input type="file" name="image" accept=".png,.jpg,.jpeg,.webp,.gif"
                            class="block text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100">
                        <p class="text-xs text-gray-400 mt-1">Accepted: PNG, JPG, WebP, GIF — max 10MB</p>
                        @error('image') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="flex justify-end pt-4 border-t border-gray-100">
                        <button type="submit"
                            class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold px-8 py-3 rounded-lg shadow transition-colors">
                            Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
    function addFeature() {
        const container = document.getElementById('features-container');
        const div = document.createElement('div');
        div.className = 'flex gap-2 items-center';
        div.innerHTML = `
            <input type="text" name="features[]" placeholder="E.g. Live Music"
                class="flex-1 border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-emerald-400 focus:outline-none">
            <button type="button" onclick="this.parentElement.remove()"
                class="px-3 py-2 bg-red-50 text-red-500 rounded-lg hover:bg-red-100 text-sm font-bold">✕</button>
        `;
        container.appendChild(div);
    }
    </script>
</x-app-layout>
