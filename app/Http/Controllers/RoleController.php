<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;
use Session;

class RoleController extends Controller
{
    public function index()
    {
    	$roles=Role::all();
    	return view('role.index',compact('roles'));
    }
    public function create()
    {
    	return view('role.create');	
    }
    public function store(request $request)
    {
    	$name=str_slug($request->name, "-");
    	$add=new Role;
    	$add->name=$name;
    	$add->guard_name="web";
    	$add->save();
        Session::flash('success','Role added successfully..');
    	return redirect()->route('role.index');
    }
    public function edit($id)
    {
    	$role=Role::where('id',$id)->first();
    	return view('role.edit',compact('role'));
    }
    public function update($id,request $request)
    {
    	$name=str_slug($request->name, "-");
    	$add=Role::find($request->id);
    	$add->name=$name;
    	$add->guard_name="web";
    	$add->save();
        Session::flash('success','Role updated successfully..');
    	return redirect()->route('role.index');	
    }
    public function distroy($id)
    {
        Session::flash('success','Role deleted successfully..');
        return redirect()->route('role.index');	
    }
}
