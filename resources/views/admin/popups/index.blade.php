<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Modal Popups') }}
            </h2>
            <a href="{{ route('admin.popups.create') }}" class="px-4 py-2 bg-indigo-600 text-white rounded shadow text-sm font-medium">Create Popup</a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @if(session('success'))
                <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="grid md:grid-cols-2 gap-6">
                @foreach($popups as $popup)
                    <div class="bg-white shadow rounded-xl border {{ $popup->is_active ? 'border-indigo-500 ring-2 ring-indigo-200' : 'border-gray-100' }} overflow-hidden flex flex-col">
                        <div class="p-5 flex-grow">
                            <div class="flex justify-between items-start mb-4">
                                <div>
                                    <h3 class="text-lg font-bold text-gray-900">{{ $popup->title }}</h3>
                                    @if($popup->subtitle)
                                        <p class="text-sm text-gray-500">{{ $popup->subtitle }}</p>
                                    @endif
                                </div>
                                @if($popup->is_active)
                                    <span class="px-2 py-1 bg-green-100 text-green-700 text-xs font-semibold rounded-full">Active</span>
                                @else
                                    <span class="px-2 py-1 bg-gray-100 text-gray-600 text-xs font-semibold rounded-full">Inactive</span>
                                @endif
                            </div>
                            
                            @if($popup->image_path)
                                <div class="mb-4">
                                    <img src="{{ asset('storage/' . $popup->image_path) }}" alt="Popup Image" class="w-full h-40 object-cover rounded border">
                                </div>
                            @endif

                            <div class="text-sm text-gray-600 space-y-2">
                                @if($popup->warning_text)
                                    <div class="p-2 bg-yellow-50 border border-yellow-100 rounded text-yellow-800 flex items-start gap-2">
                                        <svg class="w-4 h-4 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                        <span class="text-xs">{{ Str::limit($popup->warning_text, 100) }}</span>
                                    </div>
                                @endif
                                
                                @if($popup->button_text)
                                    <p><strong>Button:</strong> {{ $popup->button_text }} (Link: {{ $popup->button_link ?? '#' }})</p>
                                @endif
                            </div>
                        </div>
                        <div class="px-5 py-4 bg-gray-50 border-t border-gray-100 flex items-center justify-between">
                            <a href="{{ route('admin.popups.edit', $popup) }}" class="text-indigo-600 hover:text-indigo-900 font-medium text-sm">Edit Popup</a>
                            
                            <form action="{{ route('admin.popups.destroy', $popup) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this popup?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900 font-medium text-sm">Delete</button>
                            </form>
                        </div>
                    </div>
                @endforeach

                @if($popups->isEmpty())
                    <div class="col-span-2 bg-white border border-dashed border-gray-300 rounded-xl p-12 text-center text-gray-500">
                        No popups found. Create one to display on the frontend.
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
