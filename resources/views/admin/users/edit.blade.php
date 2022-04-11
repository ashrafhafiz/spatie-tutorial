<x-admin-layout>
    <div class="py-12 w-full">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-4">
                <div class="flex">
                    <a href="{{ route('admin.users.index') }}"
                       class="px-4 py-2 bg-green-700 hover:bg-green-500 text-slate-100 rounded-md">Back to Users</a>
                </div>
                <div class="flex">
                    <div class="space-y-8 divide-y divide-gray-200 w-1/2 mt-10">
                        <form method="POST" action="{{ route('admin.users.update', $user) }}">
                            @csrf
                            @method('PUT')
                            <div class="sm:col-span-6">
                                <label for="name" class="block text-sm font-medium text-gray-700"> User Name </label>
                                <div class="mt-1">
                                    <input type="text" id="name" name="name" value="{{ $user->name }}"
                                           class="block w-full appearance-none bg-white border border-gray-400 rounded-md py-2 px-3 text-base leading-normal transition duration-150 ease-in-out sm:text-sm sm:leading-5"/>
                                </div>
                                @error('name') <span class="text-red-400 text-sm">{{ $message }}</span> @enderror
                            </div>
                            <div class="sm:col-span-6 mt-4">
                                <label for="email" class="block text-sm font-medium text-gray-700"> User Email </label>
                                <div class="mt-1">
                                    <input type="email" id="email" name="email" value="{{ $user->email }}"
                                           class="block w-full appearance-none bg-white border border-gray-400 rounded-md py-2 px-3 text-base leading-normal transition duration-150 ease-in-out sm:text-sm sm:leading-5"/>
                                </div>
                                @error('email') <span class="text-red-400 text-sm">{{ $message }}</span> @enderror
                            </div>

                            <div class="sm:col-span-6 py-5 mt-5">
                                <h2 class="text-2xl font-semibold">Roles</h2>
                            </div>

                            <div class="sm:col-span-6 p-5 bg-slate-50 rounded-2xl">
                                @if($roles)
                                    <ul>
                                        @foreach($roles as $role)
                                            <li class="my-2">
                                                <label>
                                                    <input
                                                        class="" type="checkbox" name="role[]"
                                                        value="{{ $role->name }}"
                                                        @if(in_array($role->name, $user_assigned_roles)) checked
                                                        @endif> {{ $role->name }}
                                                </label>
                                            </li>
                                        @endforeach
                                    </ul>
                                @else
                                    <p>There is no roles to list</p>
                                @endif
                            </div>

                            <div class="sm:col-span-6 pt-5">
                                <button type="submit"
                                        class="px-4 py-2 bg-green-700 hover:bg-green-500 text-slate-100 rounded-md">
                                    Update
                                </button>
                            </div>
                        </form>
                    </div>

{{--                    <div class="space-y-8 divide-y divide-gray-200 w-1/2 mt-10 bg-blue-100 border-l-8 border-amber-300 ">--}}
{{--                        <div class="sm:col-span-6">--}}
{{--                            <h3 class="p-4">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Autem error est eveniet iste nam neque provident quisquam quos sapiente vitae. Ab architecto aspernatur, beatae culpa deserunt dicta exercitationem iusto nemo odit officia praesentium quia suscipit! Aliquam at facere fuga, nostrum quas recusandae repudiandae sunt ut! Deserunt obcaecati quam reprehenderit ut?</h3>--}}
{{--                        </div>--}}
{{--                    </div>--}}
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
