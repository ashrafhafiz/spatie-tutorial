<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Flasher\Laravel\Facade\Flasher;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Flasher\Prime\FlasherInterface;
use Flasher\Toastr\Prime\ToastrFactory;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::all();
        return view('admin.roles.index', compact('roles'));
    }

    public function create()
    {
        return view('admin.roles.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate(['name' => 'required|min:3']);
        Role::create($validated);

        // return redirect()->route('admin.roles.index')->with('message', 'Role name created successfully!');;

        Flasher::addSuccess('Role has been created successfully!');
        return redirect()->route('admin.roles.index');
    }

    public function edit(Role $role)
    {
        $permissions = Permission::all();
        return view('admin.roles.edit', compact('role', 'permissions'));
    }

    public function update(Request $request, Role $role, FlasherInterface $flasher)


    {
        $validated = $request->validate(['name' => 'required|min:3']);
        $role->update($validated);

        // return redirect()->route('admin.roles.index')->with('message', 'Role name updated successfully!');

        // if you like to use Facades :
        // use Flasher\Laravel\Facade\Flasher;
        // Flasher::addSuccess('Data has been saved successfully!');
        //
        // or function:
        // flasher('Data has been saved successfully!', 'success');
        //
        // or:
        // $flasher->addSuccess('Data has been saved successfully!');

        // Flasher::addSuccess('Role name has been updated successfully!');
        // return redirect()->route('admin.roles.index');

        // public function update(Request $request, Role $role, ToastrFactory $flasher)
        // $flasher->closeButton()->newestOnTop()->addSuccess('Data has been saved successfully!');
        // return redirect()->route('admin.roles.index');

        $flasher->type('success')
            ->message('Role name updated successfully!')
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
        return redirect()->route('admin.roles.index');

    }

    public function destroy(Role $role)
    {
        $role->delete();
        Flasher::addInfo('Role has been deleted successfully!');
        return redirect()->route('admin.roles.index');
    }
}
