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
        //
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
}
