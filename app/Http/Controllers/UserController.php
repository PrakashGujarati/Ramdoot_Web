<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Hash;
use Session;

class UserController extends Controller
{
    public function index()
    {
    	$users=User::all();
    	return view('user.index',compact('users'));
    }
    public function create()
    {
    	$roles=Role::all();
    	return view('user.add',compact('roles'));
    }
    public function store(request $request)
    {
    	$request->validate([
    		'role_id'=>'required',
    		'name'=>'required',
    		'email'=>'required|unique:users',
    		'address'=>'required',
    		'password'=>'required',
    		'city'=>'required',
    		'birth_date'=>'required',
    		'mobile'=>"required|unique:users"
    	]);

    	$validated_data = $request->only([
            'name', 'email','address','password','city','birth_date','mobile'
        ]);

        if ($request->has('password')) {
            $validated_data['password'] = Hash::make($request->get('password'));
        }

        $created_user = User::create($validated_data);
        /// Assign Role
        $role = Role::findById(request()->role_id);
        $created_user->syncRoles([$role]);
        $created_user->save();

        storeLog('user',$created_user->id,date('Y-m-d H:i:s'),'create');
        storeReview('user',$created_user->id,date('Y-m-d H:i:s'));

        Session::flash('success',"New user '$created_user->name', created successfully.");

        return redirect()
            ->route('user.index')
            ->with(['success' => "New user '$created_user->name', created successfully."]);
    }
    public function edit($id)
    {
    	$roles=Role::all();
    	$user=User::where('id',$id)->first();
    	// dd($user->getRoleNames());
    	return view('user.edit',compact('roles','user','id'));
    }
    public function update(request $request)
    {
    	$request->validate([
    		'role_id'=>'required',
    		'name'=>'required',
    		'email'=>'required|unique:users,email,'.$request->id,
    		'address'=>'required',
    		'city'=>'required',
    		'birth_date'=>'required',
    		'mobile'=>"required|unique:users,mobile,".$request->id,
    	]);

    	$validated_data = $request->only([
            'name', 'email','address','city','birth_date','mobile'
        ]);
    	$id=$request->id;

        $user = User::findOrFail($id);
        $user->update($validated_data);
        if ($request->has('role_id')) {
            $role = Role::findById(request()->role_id);
            $user->syncRoles([$role]);
        }
        $user->save();

        Session::flash('success',"New user '$user->name', updated successfully.");

        return redirect()->route('user.index')
            ->with(['success' => "User '$user->name', updated successfully."]);

        $post = $request->all();

        if (isset($post) && $id) {
            $user = User::with('roles')->find($id);
            if ($user->update($post)) {
                if (isset($user->roles[0]->id)) {
                    if ($user->roles[0]->id != $post['role_id']) {
                        $oldRole = Sentinel::findRoleById($user->roles[0]->id);
                        $oldRole->users()->detach($user);
                        $role = Sentinel::findRoleById($post['role_id']);
                        $role->users()->attach($user);
                    }
                }
                return redirect()->route('users.index')->with('message', __('messages.update', ['name' => 'user']));
            }

            return redirect()->back()->with('error', __('messages.somethingWrong'));
        }

        return redirect()->back()->with('error', __('messages.somethingWrong'));
    }
    public function distroy($id)
    {
        $user = User::where('id',$id)->delete();
        Session::flash('success',"User deleted successfully.");

        return redirect()->route('user.index')
            ->with(['success' => "User deleted successfully."]);
    }
}