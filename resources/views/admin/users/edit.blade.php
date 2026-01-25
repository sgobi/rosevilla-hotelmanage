<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit User: {{ $user->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-md rounded-lg overflow-hidden border border-gray-100 p-8">
                <form action="{{ route('admin.users.update', $user) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @method('PUT')
                    
                    <div x-data="{ photoName: null, photoPreview: null }">
                        <x-input-label for="profile_photo" :value="__('Profile Photo')" />
                        
                        <!-- Current Photo -->
                        <div class="mt-2" x-show="! photoPreview">
                            @if($user->profile_photo_path)
                                <img src="{{ asset('storage/' . $user->profile_photo_path) }}" alt="{{ $user->name }}" class="rounded-full h-20 w-20 object-cover">
                            @else
                                <div class="h-20 w-20 rounded-full bg-rose-100 flex items-center justify-center text-rose-700 font-bold border border-rose-200 text-2xl">
                                    {{ substr($user->name, 0, 1) }}
                                </div>
                            @endif
                        </div>

                        <!-- New Photo Preview -->
                        <div class="mt-2" x-show="photoPreview" style="display: none;">
                            <span class="block rounded-full w-20 h-20 bg-cover bg-no-repeat bg-center border border-gray-200"
                                  x-bind:style="'background-image: url(\'' + photoPreview + '\');'">
                            </span>
                        </div>

                        <div class="mt-2 text-sm text-gray-500">
                            <input type="file" name="profile_photo" id="profile_photo" class="hidden"
                                   x-ref="photo"
                                   x-on:change="
                                        photoName = $refs.photo.files[0].name;
                                        const reader = new FileReader();
                                        reader.onload = (e) => {
                                            photoPreview = e.target.result;
                                        };
                                        reader.readAsDataURL($refs.photo.files[0]);
                                   ">
                            
                            <button type="button" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:ring focus:ring-blue-200 active:text-gray-800 active:bg-gray-50 disabled:opacity-25 transition"
                                    x-on:click.prevent="$refs.photo.click()">
                                {{ __('Change Photo') }}
                            </button>
                            
                            <x-input-error class="mt-2" :messages="$errors->get('profile_photo')" />
                        </div>
                    </div>
                    
                    <div>
                        <x-input-label for="name" :value="__('Name')" />
                        <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus />
                        <x-input-error class="mt-2" :messages="$errors->get('name')" />
                    </div>

                    <div>
                        <x-input-label for="email" :value="__('Email')" />
                        <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required />
                        <x-input-error class="mt-2" :messages="$errors->get('email')" />
                    </div>

                    <div>
                        <x-input-label for="role" :value="__('Role')" />
                        <select name="role" id="role" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                            <option value="staff" {{ old('role', $user->role) === 'staff' ? 'selected' : '' }}>Staff</option>
                            <option value="accountant" {{ old('role', $user->role) === 'accountant' ? 'selected' : '' }}>Accountant</option>
                            <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>Admin</option>
                        </select>
                        <x-input-error class="mt-2" :messages="$errors->get('role')" />
                    </div>

                    <div class="border-t border-gray-100 pt-6">
                        <h3 class="text-sm font-semibold text-gray-900 mb-4">Change Password (Optional)</h3>
                        
                        <div class="space-y-6">
                            <div>
                                <x-input-label for="password" :value="__('New Password')" />
                                <x-text-input id="password" name="password" type="password" class="mt-1 block w-full" placeholder="Leave blank to keep current password" />
                                <x-input-error class="mt-2" :messages="$errors->get('password')" />
                            </div>

                            <div>
                                <x-input-label for="password_confirmation" :value="__('Confirm New Password')" />
                                <x-text-input id="password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full" />
                                <x-input-error class="mt-2" :messages="$errors->get('password_confirmation')" />
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center gap-4 pt-4">
                        <x-primary-button>{{ __('Update User') }}</x-primary-button>
                        <a href="{{ route('admin.users.index') }}" class="text-gray-600 hover:text-gray-900">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
