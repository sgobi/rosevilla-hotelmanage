<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h2 class="text-2xl font-black text-gray-900 leading-tight tracking-tight uppercase">Team Management Terminal</h2>
                <p class="text-[10px] font-black text-amber-600 uppercase tracking-[0.3em] mt-1 italic">Identity & Access Control</p>
            </div>
            
            <div class="flex items-center gap-3 bg-white/80 px-5 py-2.5 rounded-2xl border border-gray-100 shadow-sm transition-all hover:shadow-md">
                <div class="h-10 w-10 rounded-xl bg-gray-900 text-white flex items-center justify-center shadow-lg" style="background: #111827;">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                </div>
                <div>
                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest leading-none mb-1">Active Personnel</p>
                    <p class="text-xs font-black text-gray-900 tabular-nums uppercase">{{ $users->total() }} Authenticated</p>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @if(session('success'))
                <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded">
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white shadow rounded-xl border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                    <h3 class="text-lg font-semibold text-gray-800">All Users</h3>
                    <a href="{{ route('admin.users.create') }}" class="bg-gray-800 text-white px-4 py-2 rounded-md text-sm hover:bg-gray-700 shadow-sm transition font-semibold uppercase tracking-wider">
                        + Add New User
                    </a>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm text-left">
                        <thead class="text-xs uppercase text-gray-500 bg-gray-50">
                            <tr>
                                <th class="px-6 py-3">Photo</th>
                                <th class="px-6 py-3">Name</th>
                                <th class="px-6 py-3">Email</th>
                                <th class="px-6 py-3">Role</th>
                                <th class="px-6 py-3 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($users as $user)
                                <tr>
                                    <td class="px-6 py-3">
                                        @if($user->profile_photo_path)
                                            <img src="{{ asset('storage/' . $user->profile_photo_path) }}" alt="{{ $user->name }}" class="h-10 w-10 rounded-full object-cover border border-gray-200">
                                        @else
                                            <div class="h-10 w-10 rounded-full bg-rose-100 flex items-center justify-center text-rose-700 font-bold border border-rose-200">
                                                {{ substr($user->name, 0, 1) }}
                                            </div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-3 font-semibold text-gray-800">{{ $user->name }}</td>
                                    <td class="px-6 py-3 text-gray-700">{{ $user->email }}</td>
                                    <td class="px-6 py-3">
                                        <span class="px-2 py-1 rounded text-xs uppercase tracking-wide font-semibold
                                            {{ $user->role === 'admin' ? 'bg-purple-100 text-purple-800' : '' }}
                                            {{ $user->role === 'staff' ? 'bg-blue-100 text-blue-800' : '' }}
                                            {{ $user->role === 'accountant' ? 'bg-green-100 text-green-800' : '' }}
                                        ">
                                            {{ ucfirst($user->role) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-3 text-right">
                                        <div class="flex items-center justify-end gap-3">
                                            <a href="{{ route('admin.users.edit', $user) }}" class="text-indigo-600 hover:text-indigo-900 font-medium">Edit</a>
                                            @if($user->id !== auth()->id())
                                                <div x-data="{ confirming: false }">
                                                    <button @click="confirming = true" 
                                                            class="text-red-600 hover:text-red-900 font-medium">
                                                        Delete
                                                    </button>
                                                    
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
                                                                        <h3 class="text-xl font-bold text-gray-900">Confirm User Deletion</h3>
                                                                        <p class="text-sm text-gray-500">Deleting <strong>{{ $user->name }}</strong> is permanent.</p>
                                                                    </div>
                                                                </div>

                                                                <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="space-y-6">
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
                                            @else
                                                <span class="text-gray-400 cursor-not-allowed font-medium">Delete</span>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="px-6 py-4 border-t border-gray-100">
                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
