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
        $userdata = User::all();
        return view('notification.index',compact('userdata'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return "create";
       /* $utoken="dWkMsvDzR-GLb-OJg1byo7:APA91bF-sisz1ifoNqW9SludcIu2aCtbnwVPdcdfGButhbgZI5vVs6rLXDpY7pInrOK_4uubV4T6reIPKZoHzzcgMMcyvFaHnibMDeNEFPdiZj4V91B8I5GiU9r9ybIIUTRlbZsYWmbu";
        $title="title for notification";
        $message="message body";
        $this->push_notification($utoken, $message, $title);*/
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
            if(count($request->user_id) > 0){
                foreach ($request->user_id as $value) {
                    $user=User::find($value)->first();
                    send_notification($user->device_token,$request->message,$request->title);

                    $add = new Notification;
                    $add->device_id = $user->device_token;
                    $add->user_id = $value;
                    $add->title = $request->title;
                    $add->message = $request->message;
                    $add->save();
                }
                return redirect()->route('notification.index')->with('success', 'Notification Send Successfully.');
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


    public function push_notification($utoken, $message, $title = null) {
        
            $API_ACCESS_KEY = 'AIzaSyCC3WAurKIK_h3h39QXxMm3_M2u61C_CkM';

            $headers = array
            (
            'Authorization: key=' . $API_ACCESS_KEY,
            'Content-Type: application/json'
            );                

            $token = $utoken;

            $msg = array(
            'alert' => $message,
            'title' => $title,
            'message' => $message,
            'notification_type' => "",
            'user_type' => "",
            'sound' => 'default',
            'client_id' => "",
            'flag'=>"",
            );

            $notification = array(
            'title' => $title,
            'body' => $message,               
            'sound' => 'default',
            );
            

            $fields = array(
            'to' => $token,
            'data' => $msg,
            'priority' => 'high',
            'vibrate' => 1,             
            'notification' => $notification
            );
                
            try {
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
                
                $result = curl_exec($ch);
                curl_close($ch);
                $errMsg = '';
                $res = (array) json_decode($result);

                $errMsg = '';
                
                if (!empty($res)) {
                    if ($res['failure'] == 1) {
                        $errMsg = $res['results'][0]->error;
                    }
                }
                
                
            } catch (Exception $e) {
                    Log::info("ERROR IN CACHE");
            }                    

    }
}
