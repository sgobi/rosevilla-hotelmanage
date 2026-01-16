<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $editingReview ? 'Edit Review' : 'Reviews' }}
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
                <form method="POST" action="{{ $editingReview ? route('admin.reviews.update', $editingReview) : route('admin.reviews.store') }}">
                    @csrf
                    @if($editingReview)
                        @method('PUT')
                    @endif
                    <div class="grid md:grid-cols-2 gap-4">
                        <label class="text-sm text-gray-700 space-y-1">
                            <span>Guest name</span>
                            <input name="guest_name" class="w-full border rounded px-3 py-2" value="{{ old('guest_name', $editingReview->guest_name ?? '') }}" required>
                        </label>
                        <label class="text-sm text-gray-700 space-y-1">
                            <span>Source</span>
                            <input name="source" class="w-full border rounded px-3 py-2" value="{{ old('source', $editingReview->source ?? '') }}">
                        </label>
                        <label class="text-sm text-gray-700 space-y-1">
                            <span>Rating</span>
                            <input type="number" min="1" max="5" name="rating" class="w-full border rounded px-3 py-2" value="{{ old('rating', $editingReview->rating ?? 5) }}">
                        </label>
                        <label class="flex items-center gap-2 text-sm text-gray-700">
                            <input type="checkbox" name="is_published" value="1" @checked(old('is_published', $editingReview->is_published ?? true))>
                            <span>Published</span>
                        </label>
                        <label class="text-sm text-gray-700 space-y-1 md:col-span-2">
                            <span>Comment</span>
                            <textarea name="comment" rows="3" class="w-full border rounded px-3 py-2" required>{{ old('comment', $editingReview->comment ?? '') }}</textarea>
                        </label>
                    </div>
                    <div class="mt-4 flex gap-3">
                        <button class="px-4 py-2 bg-indigo-600 text-white rounded shadow">{{ $editingReview ? 'Update Review' : 'Add Review' }}</button>
                        @if($editingReview)
                            <a href="{{ route('admin.reviews.index') }}" class="px-4 py-2 border rounded text-gray-700">Cancel edit</a>
                        @endif
                    </div>
                </form>
            </div>

            <div class="bg-white shadow rounded-xl border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-gray-800">Guest reviews</h3>
                </div>
                <div class="divide-y divide-gray-100">
                    @foreach($reviews as $review)
                        <div class="px-6 py-4 flex items-start justify-between">
                            <div class="space-y-1">
                                <div class="flex items-center gap-2">
                                    <p class="font-semibold text-gray-800">{{ $review->guest_name }}</p>
                                    <span class="text-amber-600 text-sm">Rating: {{ $review->rating }}/5</span>
                                </div>
                                <p class="text-gray-600">{{ $review->comment }}</p>
                                <p class="text-xs text-gray-500">{{ $review->source }}</p>
                            </div>
                            <div class="flex items-center gap-3">
                                <span class="px-2 py-1 rounded-full text-xs font-semibold {{ $review->is_published ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-700' }}">
                                    {{ $review->is_published ? 'Published' : 'Hidden' }}
                                </span>
                                <a href="{{ route('admin.reviews.edit', $review) }}" class="text-indigo-600 hover:underline text-sm">Edit</a>
                                <form action="{{ route('admin.reviews.destroy', $review) }}" method="POST" onsubmit="return confirm('Delete this review?');">
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
    </div>
</x-app-layout>
