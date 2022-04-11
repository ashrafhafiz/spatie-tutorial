<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Flasher\Laravel\Facade\Flasher;
use Flasher\Prime\FlasherInterface;
use Flasher\Toastr\Prime\ToastrFactory;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionController extends Controller
{
    public function index()
    {
        $permissions = Permission::all();
        return view('admin.permissions.index', compact('permissions'));
    }

    public function create()
    {
        return view('admin.permissions.create');
    }

    public function store(Request $request, ToastrFactory $flasher)
    {
        $validated = $request->validate(['name' => 'required']);
        Permission::create($validated);

        // return redirect()->route('admin.permissions.index')->with('message', 'Permission name created successfully!');;

        $flasher
            ->showMethod('slideDown')
            ->hideMethod('slideUp')
            ->timeOut(1000)
            ->addSuccess('Permission has been created successfully!');

        return redirect()->route('admin.permissions.index');
    }

    public function edit(Permission $permission)
    {
        $assigned_roles_array = [];
        // $roles = Role::all();

        // $admin = Role::where('name', '=', 'admin')->get()->first();
        // $roles = Role::all()->except($admin->id);

        $roles = Role::whereNotIn('name',['admin'])->get();

        foreach ($roles as $role)
        {
            if ($permission->hasRole($role))
            {
                $assigned_roles_array[] = $role->name;
            }
        }
        // dd($assigned_roles_array);
        return view('admin.permissions.edit', compact('permission', 'roles', 'assigned_roles_array'));
    }

    public function update(Request $request, Permission $permission, FlasherInterface $flasher)
    {
        $validated = $request->validate(['name' => 'required']);
        $permission->update($validated);

        $roles = Role::all();
        foreach ($roles as $role)
        {
            if ($permission->hasRole($role))
            {
                $permission->removeRole($role);
            }
        }

        if($request->input('role') != null)
        {
            $new_roles = $request->input('role');
            // dd($new_roles);
            foreach ($new_roles as $role) {
                $permission->assignRole($role);
            }
        }


        // return redirect()->route('admin.permissions.index')->with('message', 'Permission name updated successfully!');

        $flasher->handler('toastr')
            ->options([
                'timeOut' => 1000,
                'showEasing' => 'swing',
                'hideEasing ' => 'linear',
                'showMethod' => 'slideDown',
                'hideMethod' => 'slideUp'
            ], true)
            ->addSuccess('Permission name has been updated successfully!');

        return redirect()->route('admin.permissions.index');
    }

    public function destroy(Permission $permission, ToastrFactory $flasher)
    {
        $permission->delete();
        $flasher
            ->showMethod('slideDown')
            ->hideMethod('slideUp')
            ->timeOut(1000)
            ->addSuccess('Permission has been deleted successfully!');

        return redirect()->route('admin.permissions.index');
    }
}
