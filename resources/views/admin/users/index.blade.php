<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Users
            </h2>
            <a href="{{ route('admin.users.create') }}" class="bg-rose-600 text-white px-4 py-2 rounded-md hover:bg-rose-700">Add New User</a>
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
                                <th class="px-6 py-3">Name</th>
                                <th class="px-6 py-3">Email</th>
                                <th class="px-6 py-3">Role</th>
                                <th class="px-6 py-3 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($users as $user)
                                <tr>
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
                                    <td class="px-6 py-3 text-right flex justify-end gap-3">
                                        <a href="{{ route('admin.users.edit', $user) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                        @if($user->id !== auth()->id())
                                            <form action="{{ route('admin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this user?');">
                                                @csrf
                                                @method('DELETE')
                                                <button class="text-red-600 hover:text-red-900">Delete</button>
                                            </form>
                                        @else
                                            <span class="text-gray-400 cursor-not-allowed">Delete</span>
                                        @endif
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
