<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\UserDataLog;
use App\Models\UserDataReview;

class LogController extends Controller
{
    public function index()
    {
        $users = User::where('role_id','<=',6)->get();
        return view('log.index', ['users'=>$users]);
    }
    public function getData(request $request)
    {
        $getData=UserDataLog::with('user')
        ->whereDate('upload_time', '>=', $request->start_date)
        ->whereDate('upload_time', '<=', $request->end_date)
        ->where(['user_id' => $request->user_id])
        ->orderBy('upload_time', 'desc')
        ->get();
        $role = Role::where('id', $getData[0]->user->role_id)->first() ;
        $html=view('log.dyanamicTable', ['getData' => $getData,'role' => $role])->render();
        return response()->json(['html'=>$html]);
    }
}
