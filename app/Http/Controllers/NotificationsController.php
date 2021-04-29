<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class NotificationsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $userdata = User::where('device_token','!=','')->get();
        return view('notification.index',compact('userdata'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $utoken="dWkMsvDzR-GLb-OJg1byo7:APA91bF-sisz1ifoNqW9SludcIu2aCtbnwVPdcdfGButhbgZI5vVs6rLXDpY7pInrOK_4uubV4T6reIPKZoHzzcgMMcyvFaHnibMDeNEFPdiZj4V91B8I5GiU9r9ybIIUTRlbZsYWmbu";
        $title="title for notification";
        $message="message body";
        send_notification($utoken, $message, $title);
        return "run";
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        if($request->has('user_id')){
            if(count($request->user_id) > 1){
                foreach ($request->user_id as $value) {
                    $user=User::find($value);
                    send_notification($user->device_token,$request->message,$request->title);

                    $add = new Notification;
                    $add->device_id = $user->device_token;
                    $add->user_id = $value;
                    $add->title = $request->title;
                    $add->message = $request->message;
                    $add->save();
                }
                return redirect()->route('notification.index')->with('success', 'Notification Send Successfully.');
            }else
            {
                $users = User::where('device_token','!=','')->get();
                foreach ($users as $user) {                    
                    send_notification($user->device_token,$request->message,$request->title);
                    $add = new Notification;
                    $add->device_id = $user->device_token;
                    $add->user_id = $user->id;
                    $add->title = $request->title;
                    $add->message = $request->message;
                    $add->save();
                }
                return redirect()->route('notification.index')->with('success', 'Notification Send Successfully.. to All Users');
            } 
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\notifications  $notifications
     * @return \Illuminate\Http\Response
     */
    public function show(notifications $notifications)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\notifications  $notifications
     * @return \Illuminate\Http\Response
     */
    public function edit(notifications $notifications)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\notifications  $notifications
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, notifications $notifications)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\notifications  $notifications
     * @return \Illuminate\Http\Response
     */
    public function destroy(notifications $notifications)
    {
        //
    }


    
}
