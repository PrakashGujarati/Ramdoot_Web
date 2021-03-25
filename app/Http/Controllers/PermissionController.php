<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Permission;
use Session;
use Illuminate\Support\Str;


class PermissionController extends Controller
{
    public function index()
    {
    	$permissions=Permission::all();
    	return view('permission.index',compact('permissions'));
    }
    public function create()
    {
    	return view('permission.add');	
    }
    public function store(request $request)
    {
    	$request->validate(['name'=>'required']);
    	$name=Str::slug($request->name, "-");
    	$add=new Permission;
    	$add->name=$name;
    	$add->save();
        Session::flash('success','Permission added successfully..');
    	return redirect()->route('permission.index');
    }
    public function edit($id)
    {
    	$permission=Permission::where('id',$id)->first();
    	return view('permission.edit',compact('permission'));
    }
    public function update($id,request $request)
    {
    	$request->validate(['name'=>'required']);
    	$name=Str::slug($request->name, "-");
    	$add=Permission::find($request->id);
    	$add->name=$name;
    	$add->guard_name="web";
    	$add->save();
        Session::flash('success','Permission updated successfully..');
    	return redirect()->route('permission.index');	
    }
    public function distroy($id)
    {
        $add=Permission::where($id)->delete();
        Session::flash('success','Permission deleted successfully..');
        return redirect()->route('permission.index');	
    }
}
