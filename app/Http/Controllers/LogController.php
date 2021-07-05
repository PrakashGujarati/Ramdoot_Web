<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\UserDataLog;
use App\Models\UserDataReview;
use App\Exports\UserDataLogExport;
use Excel;

class LogController extends Controller
{
    public function index()
    {
        $users = User::all();
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
        $role = Role::where('id', $getData[0]->user->role_id)->first();
        $html=view('log.dyanamicTable', ['getData' => $getData,'role' => $role])->render();
        return response()->json(['html'=>$html]);
    }

    public function logMinutes(Request $request)
    {
        foreach ($request->log_ids as $key => $id) {
            UserDataLog::where('id', $id)->
            update([
                'minutes' => $request->minutes[$key]
            ]);
        }
    }

    public function getDetails(Request $request)
    {
        $userDataLog = UserDataLog::where('id', $request->userDataLogId)->first();
        $data = $userDataLog->logable->toArray();
        $html = view('log.modal', ['data' => $data,'model' => $userDataLog->logable_type])->render();
        return response()->json(['success'=>true,'html'=>$html]);
    }

    public function userLogExport($start_date,$end_date,$user_id)
    {
       // dd($start_date,$end_date,$user_id);
       // dd($Request->all());
        $getData=UserDataLog::with('user')
        ->whereDate('upload_time', '>=', $start_date)
        ->whereDate('upload_time', '<=', $end_date)
        ->where(['user_id' => $user_id])
        ->orderBy('upload_time', 'desc')
        ->get();

        $role='';
        if(count($getData) > 0){
            $role = Role::where('id', $getData[1]->user->role_id)->first();    
        }
        
        $data=[];
        if(count($getData) > 0){
            $totalInterval = 0;

            for($i=0; $i < count($getData); $i++){

                $nextKey = $i+1;
                if (($i != count($getData)-1) && date_format(date_create($getData[$i]->upload_time), 'd-m-Y') == date_format(date_create($getData[$nextKey]->upload_time), 'd-m-Y')) {
                    $dateDifference = date_diff(date_create($getData[$i]->upload_time), date_create($getData[$nextKey]->upload_time));
                    $minutes = $dateDifference->days * 24 * 60;
                    $minutes += $dateDifference->h * 60;
                    $interval = $minutes+$dateDifference->i;
                } else {
                    $interval = 0;
                }
                $totalInterval += $getData[$i]->minutes ? $getData[$i]->minutes : $interval ;

                if($interval > 59){

                   $final_interval = intdiv($interval, 60).' hours '. ($interval % 60).' minutes';
                }
                elseif($interval < 1 ){

                   $final_interval = "< 1 minute"; 
                }
                else{

                   $final_interval =  $interval."minutes";
                }

                $data[] = ['type' => $getData[$i]->logable_type,'datetime' => date_format(date_create($getData[$i]->upload_time), 'd-m-Y H:i:s'),'operation' => $getData[$i]->operation,'role' => $role ? $role->slug : '','interval' => $final_interval,'minutes' => $totalInterval];
                
            }

            return Excel::download(new UserDataLogExport($data), 'UserDataLog.xlsx');
        }
        return redirect()->route('user.log');
    }
}
