<?php

namespace App\Http\Controllers;

use App\Actions\Fortify\CreateNewUser;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $users = User::filter($request->all())->select("id", "name", "email", "deleted_at", "profile_photo_path")->get();
        $roles = Role::all("name as key", DB::raw("CONCAT(UCASE(LEFT(name, 1)), SUBSTRING(name, 2)) as value"), "description");
        $filters = [
            [
                "key" => "status",
                "title" => "Status",
                "options" => [
                    ['key' => 'active', 'label' => 'Active users'],
                    ['key' => 'disabled', 'label' => 'Disabled users']
                ],
            ],
            [
                "key" => "roles",
                "title" => 'Roles',
                "options" => $roles->map(fn ($role) => ['key' => $role->key, 'label' => $role->value])->toArray(),
            ]
        ];


        return view('users.index',compact('users','roles','filters'));
        
    }

    public function show($id)
    {
        $user = User::with("permissions:id,name,description")->select("id", "name", "email")->findOrFail($id);
        $permissions = Permission::all("name", "description")->filter(fn ($item) => !$user->hasPermissionTo($item->name));

        //visa
        return view('users.show',compact('user','permissions'));
       
    }

    public function store(Request $request)
    {
        app(CreateNewUser::class)->create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'password_confirmation' => $request->password_confirmation,
            'terms' => $request->terms,
            'role' => $request->role
        ]);

        return back(303);
    }

    public function updateStatus(Request $request, $id)
    {
        $user = User::withTrashed()->findOrFail($id);
        $user->deleted_at = $request->status ? null : now();
        $user->save();
        return back(303);
    }

    public function destroy($id)
    {
        $user = User::onlyTrashed()->findOrFail($id);
        $user->forceDelete();

        return back(303);
    }

    public function givePermission(Request $request, $user_id)
    {
        $request->validate(['permissions' => 'array', 'permissions.*' => 'string']);
        $user = User::findOrFail($user_id);

        foreach ($request->permissions as $perm) {
            $permission = Permission::where(["name" => $perm])->first();
            $user->givePermissionTo($permission);
        }
        
        return back(303);
    }

    public function revokePermission($user_id, $perm_id)
    {
        $user = User::findOrFail($user_id);
        $permission = $user->permissions()->findOrFail($perm_id);
        $user->revokePermissionTo($permission);
        return back(303);
    }
}
