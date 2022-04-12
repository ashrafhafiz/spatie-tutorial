<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Flasher\Laravel\Facade\Flasher;
use Flasher\Prime\FlasherInterface;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
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
         //dd($request->input('role'));
        $validated = $request->validate([
            'name' => 'required',
            'email' => [
                'required',
                Rule::unique('users')->ignore($user),
            ],
        ]);
        $user->update($validated);

//        $old_roles = $user->getRoleNames()->toArray();
//
//        foreach ($old_roles as $role)
//        {
//            $user->removeRole($role);
//        }
//
//        if($request->input('role') != null)
//        {
//            $new_roles = $request->input('role');
//            foreach ($new_roles as $role) {
//                $user->assignRole($role);
//            }
//        }

        // The following line replace the whole lines commented above
        $user->syncRoles($request->input('role'));

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



    public function editUserRoles(User $user)
    {
        $data['user'] = $user;
        $data['roles'] = Role::all();
        $data['user_assigned_roles'] = $user->getRoleNames()->toArray();

        $data['permissions'] = Permission::all();
        // get all permissions for the user, both directly, and from roles
        $data['user_assigned_permissions'] = $user->getAllPermissions()->toArray();

        return view('admin.users.edit-roles', $data);
    }

    public function updateUserRoles(Request $request, User $user, FlasherInterface $flasher)
    {
        $user->syncRoles($request->input('role'));
        Flasher::addInfo('User roles has been updated successfully!');
        return redirect()->route('admin.users.index');
    }

    public function editUserPermissions(User $user)
    {
        $data['user'] = $user;
        $data['roles'] = Role::all();
        $data['user_assigned_roles'] = $user->getRoleNames()->toArray();

        $data['permissions'] = Permission::all();
        // get all permissions for the user, both directly, and from roles
        $a = $user->getAllPermissions()->toArray();
        //dd($a);
        foreach($a as $key => $value){
            $b[] = $value['name'];
        }
        // dd($b);
        $data['user_assigned_permissions'] = $b;
        // dd($data['user_assigned_permissions']);

        return view('admin.users.edit-permissions', $data);
    }

    public function updateUserPermissions(Request $request, User $user, FlasherInterface $flasher)
    {
        $user->syncPermissions($request->input('permission'));
        Flasher::addInfo('User permissions has been updated successfully!');
        return redirect()->route('admin.users.index');
    }
}
