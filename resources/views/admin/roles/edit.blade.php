<x-admin-layout>
    <div class="py-12 w-full">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-4">
                <div class="flex">
                    <a href="{{ route('admin.roles.index') }}"
                       class="px-4 py-2 bg-green-700 hover:bg-green-500 text-slate-100 rounded-md">Back to Roles</a>
                </div>
                <div class="flex flex-col">
                    <div class="space-y-8 divide-y divide-gray-200 w-1/2 mt-10">
                        <form method="POST" action="{{ route('admin.roles.update', $role) }}">
                            @csrf
                            @method('PUT')
                            <div class="sm:col-span-6">
                                <label for="name" class="block text-sm font-medium text-gray-700"> Role name </label>
                                <div class="mt-1">
                                    <input type="text" id="name" name="name" value="{{ $role->name }}"
                                           class="block w-full appearance-none bg-white border border-gray-400 rounded-md py-2 px-3 text-base leading-normal transition duration-150 ease-in-out sm:text-sm sm:leading-5"/>
                                </div>
                                @error('name') <span class="text-red-400 text-sm">{{ $message }}</span> @enderror
                            </div>
                            <div class="sm:col-span-6 pt-5">
                                <button type="submit"
                                        class="px-4 py-2 bg-green-700 hover:bg-green-500 text-slate-100 rounded-md">
                                    Update
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="mt-6 p-2">
                    <h2 class="text-2xl font-semibold">Role Permissions</h2>
                    <div class="mt-4 p-2">
                        @if($role->permissions)
                            <ul>
                                @foreach($role->permissions as $role_permission)
                                    <li>{{ $role_permission->name }}</li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                    <div class="mt-4 p-2">
                        @if($permissions)
                            <ul>
                            @foreach($permissions as $permission)
                                    <li><label><input class="" type="checkbox" name="permission[]" value="{{ $permission->name }}"> {{ $permission->name }}</label></li>
                            @endforeach
                            </ul>
                        @else
                            <p>There is no permissions to list</p>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
