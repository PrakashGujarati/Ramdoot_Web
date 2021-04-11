<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Models\RoleHasPermission;


class SpatieRolePermissionController extends Controller
{
    public function index_roles()
    {
        $data['roles'] = Role::select('id', 'name')->get();
        $data['selected_role'] = Role::whereId(request('role_id'))->first();
        $data['permissions'] = Permission::orderBy('id','asc')->get();
        //return view('spatie-role.index')->with($data);
        return view('spatie-role.index_new')->with($data);
    }

    public function new_roles()
    {
        $data['roles'] = Role::select('id', 'name')->get();
        $data['selected_role'] = Role::whereId(request('role_id'))->first();
       // $data['permissions'] = Permission::orderBy('id','asc')->get();
        $data['permissions'] = Permission::get();
        return view('spatie-role.new_roles')->with($data);
    }

      

    public function assign_permissions(Request $request, $role_id)
    {
        // dd($request->all(),$role_id);
        // if(count($request->permissions) > 0){
        //     foreach ($request->permissions as $key => $value) {
        //         $add = new RoleHasPermission;
        //         $add->role_id = $role_id;
        //         $add->permission_id  = $value;
        //         $add->save();
        //     }
        // }

        $selected_permissions = request('permissions');//collect(request('permissions'))->keys()->toArray();
        $role = Role::findOrFail($role_id);
        $role->syncPermissions($selected_permissions);
        return redirect()->back()->with('success', "Permissions are assigned successfully to selected role.");
    }
}
