<x-admin-layout>
    <div class="py-12 w-full">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-4">
                <div class="flex justify-between">
                    <h3 class="text-xl font-bold">Admin Roles</h3>
                    <a href="{{ route('admin.roles.create') }}"
                       class="px-4 py-2 bg-green-700 hover:bg-green-500 text-white rounded-md">Create Role</a>
                </div>
                <div class="flex flex-col mt-4">
                    <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                        <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                            <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Name
                                        </th>
                                        <th scope="col" class="relative px-6 py-3">
                                            <span class="sr-only">Edit</span>
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach ($roles as $role)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    {{ $role->name }}
                                                </div>
                                            </td>
                                            <td>
                                                <div class="flex justify-end">
                                                    <div class="flex space-x-4 mr-4">
                                                        @if($role->name === 'admin')
                                                            <button class="px-4 py-2 bg-gray-200 text-white rounded-md"
                                                                    disabled>Edit
                                                            </button>
                                                        @else
                                                            <a href="{{ route('admin.roles.edit', $role) }}"
                                                               class="px-4 py-2 bg-blue-500 hover:bg-blue-700 text-white rounded-md">Edit</a>
                                                        @endif
                                                        <form
                                                            class="@if($role->name !== 'admin') px-4 py-2 bg-red-500 hover:bg-red-700 text-white rounded-md @else px-4 py-2 bg-gray-200 text-white rounded-md @endif"
                                                            method="POST"
                                                            action="{{ route('admin.roles.destroy', $role) }}"
                                                            onsubmit="return confirm('Are you sure?');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit"
                                                                    @if($role->name === 'admin') disabled @endif>Delete
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
