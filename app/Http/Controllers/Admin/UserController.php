<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Flasher\Laravel\Facade\Flasher;
use Flasher\Prime\FlasherInterface;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
// use Flasher\Toastr\Prime\ToastrFactory;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required|unique',
            'password' => 'required|min:8',
            'confirm_password' => 'required'
        ]);
        User::create($validated);

        Flasher::addSuccess('User has been created successfully!');
        return redirect()->route('admin.users.index');
    }

    public function edit(User $user)
    {
        $data['user'] = $user;
        $data['roles'] = Role::all();
        $data['user_assigned_roles'] = $user->getRoleNames()->toArray();

        $data['permissions'] = Permission::all();
        // get all permissions for the user, both directly, and from roles
        $data['user_assigned_permissions'] = $user->getAllPermissions()->toArray();

        return view('admin.users.edit', $data);
    }

    public function update(Request $request, User $user, FlasherInterface $flasher)
    {
        $validated = $request->validate(['name' => 'required|min:3']);
        $user->update($validated);

        $old_permissions = $user->permissions;

        foreach ($old_permissions as $old_permission)
        {
            $user->revokePermissionTo($old_permission->name);
        }

        if($request->input('permission') != null)
        {
            $new_permissions = $request->input('permission');
            foreach ($new_permissions as $permission) {
                $user->givePermissionTo($permission);
            }
        }

        $flasher->type('success')
            ->message('User has been updated successfully!')
            ->priority(2)
            ->handler('toastr')
            ->options([
                'timeOut' => 1000,
                'showEasing' => 'swing',
                'hideEasing ' => 'linear',
                'showMethod' => 'slideDown',
                'hideMethod' => 'slideUp'
            ], true)
            ->flash();
        return redirect()->route('admin.users.index');

    }

    public function destroy(User $user)
    {
        $user->delete();
        Flasher::addInfo('User has been deleted successfully!');
        return redirect()->route('admin.users.index');
    }
}
