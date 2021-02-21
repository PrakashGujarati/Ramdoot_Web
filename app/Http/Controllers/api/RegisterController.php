<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Validator;

class RegisterController extends Controller
{
    /**
     * Registration
     */
    public function register(Request $request)
    {

        $this->validate($request, [            
            'mobile' => 'required|numeric|min:10',            
        ]);
 
        if(User::where('mobile',$request->mobile)->exists())
        {
            $data = [
                'mobile' => $request->mobile              
            ];

            $user = User::where('mobile',$request->mobile)->first();
            $token = $user->createToken('Ramdoot')->accessToken;
           return response()->json(['token' => $token], 200);
           
        }else{        
            $user = User::create([            
                'mobile' => $request->mobile,            
            ]);
           
            $token = $user->createToken('Ramdoot')->accessToken;
            return response()->json(['token' => $token], 200);
        }

        
    }
 
    /**
     * Login
     */
    public function login(Request $request)
    {
        $rules = array(
            'mobile' => 'required'
        );
        $messages = array(
            'mobile.required' => 'Please enter mobile number.'
        );

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            $msg = $validator->messages();
            return ['status' => "false",'msg' => $msg];
        }

        $checkuser = User::where('mobile',$request->mobile)->first();
        if($checkuser){
            return response()->json([
                "code" => 200,
                "message" => "success",
                "data" => $checkuser,
            ]);
        }
        else{
            return response()->json([
                "code" => 400,
                "message" => "User not found.",
                "data" => [],
            ]);
        }

    }   

    public function profile_update(Request $request)
    {
        
        $rules = array(
            'user_id' => 'required'
        );
        $messages = array(
            'user_id.required' => 'Please enter user id.'
        );

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            $msg = $validator->messages();
            return ['status' => "false",'msg' => $msg];
        }

        $checkuser = User::where('id',$request->user_id)->first();
        if($checkuser){

            $rules = array(
                'mobile' => 'required|unique:users,mobile,'.$request->user_id,
            );
            $messages = array(      
                'mobile.required' => 'Please enter mobile number.'
            );

            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {
                $msg = $validator->messages();
                return ['status' => "false",'msg' => $msg];
            }

            $update = User::find($checkuser->id);
            $update->name = $request->name;
            $update->mobile = $request->mobile;
            $update->email = $request->email;
            $update->save();

            return response()->json([
                "code" => 200,
                "message" => "success",
                "data" => $update,
            ]);

        }else{
            return response()->json([
                "code" => 400,
                "message" => "User not found.",
                "data" => [],
            ]);
        }

    }

    public function logout(Request $request)
    {      
		$request->user()->token()->revoke();
        return response()->json([
            'message' => 'Successfully logged out'
        ]);
	}
}
