<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Permission;
use Spatie\Permission\Models\Role;

class SpatieRolePermissionController extends Controller
{
    public function index_roles()
    {
        $data['roles'] = Role::select('id', 'name')->get();
        $data['selected_role'] = Role::whereId(request('role_id'))->first();
        $data['permissions'] = Permission::groupBy('module_name')->orderBy('id','asc')->get();
       // return view('spatie-role.index')->with($data);
       return view('spatie-role.index_new')->with($data);
    }

    public function assign_permissions(Request $request, $role_id)
    {
        // dd($request->all());
        $selected_permissions = collect(request('permissions'))->keys()->toArray();
        $role = Role::findOrFail($role_id);
        $role->syncPermissions($selected_permissions);
        return redirect()->back()->with('success', "Permissions are assigned successfully to selected role.");
    }
}
