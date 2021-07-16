<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\Models\Role;
use App\Models\UserDeviceToken;

class RegisterController extends Controller
{
    public function userRoles(Request $request)
    {
        $roles = Role::where(['status' => 0])->where('slug','!=',"")->get();
        return response()->json([
            "code" => 200,
            "message" => "success",
            "data" => $roles,
        ]);
    }
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
            $user->device_token = null; //$request->device_token;
            $user->save();
            $token = $user->createToken('Ramdoot')->accessToken;
            $image="";
            if($user->profile_photo_path){
                $image = config('ramdoot.appurl')."/upload/profile/".$user->profile_photo_path;    
            }

            $check_token = UserDeviceToken::where(['user_id' => $user->id,'device_token' => $request->device_token])->first();

            $check_device_token = UserDeviceToken::where(['device_token' => $request->device_token])->delete();

            // if($check_device_token){
            //     UserDeviceToken::where(['id' => $check_device_token->id])->delete();
            // }

            if(empty($check_token)){
                $add_token = new UserDeviceToken;
                $add_token->user_id = $user->id;
                $add_token->device_token = $request->device_token;
                $add_token->save();        
            }
            
            // $role_id = 0;
            // if($user->user_type == "Teacher / Faculty" || $user->user_type == "Teacher"){
            //     $getrole = Role::where(['slug' => 'Teacher'])->first();
            //     $role_id = $getrole->id;
            // }
            // elseif ($user->user_type == "Student"){
            //     $getrole = Role::where(['slug' => 'Student'])->first();
            //     $role_id = $getrole->id;
            // }
            $instituteid = null;
            if($user->institute_id){
                $instituteid = $user->institute_id;
            }

            $data = ['id' => $user->id,'role_id' => $user->role_id,'name' => $user->name,'mobile' => $user->mobile,'email' => $user->email,'address' => $user->address,'pin_code' => $user->pin_code,'city' => $user->city,'birth_date' => $user->birth_date,'user_type' => $user->user_type,'gender' => $user->gender,'profile_photo' => $image,'username' => $user->username,'institute_id' => $instituteid,'device_token' => $request->device_token,'token' => $token];
            return response()->json([
                "code" => 200,
                "message" => "success",
                "data" => $data,
            ]);
        }else{        
            $user = User::create([            
                'mobile' => $request->mobile,           
                'device_token' => $request->device_token,
            ]);

            $check_token = UserDeviceToken::where(['user_id' => $user->id,'device_token' => $request->device_token])->first();

            if(empty($check_token)){
                if($request->device_token){
                    $add_token = new UserDeviceToken;
                    $add_token->user_id = $user->id;
                    $add_token->device_token = $request->device_token;
                    $add_token->save(); 
                }       
            }
           
            $token = $user->createToken('Ramdoot')->accessToken;
            $image="";
            if($user->profile_photo_path){
                $image = config('ramdoot.appurl')."/upload/profile/".$user->profile_photo_path;    
            }
            $instituteid = null;
            if($user->institute_id){
                $instituteid = $user->institute_id;
            }

            $data = ['id' => $user->id,'role_id' => $user->role_id,'name' => $user->name,'mobile' => $user->mobile,'email' => $user->email,'address' => $user->address,'pin_code' => $user->pin_code,'city' => $user->city,'birth_date' => $user->birth_date,'user_type' => $user->user_type,'gender' => $user->gender,'profile_photo' => $image,'username' => $user->username,'institute_id' => $instituteid,'device_token' => $request->device_token,'token' => $token];
            return response()->json([
                "code" => 200,
                "message" => "success",
                "data" => $data,
            ]);
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
             'mobile' => 'required',
         );
         $messages = array(      
             'mobile.required' => 'Please enter mobile number.'
         );

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            $msg = $validator->messages();
            return ['code' => 500,'message'=>'Invalid input','data' => $msg];
        }

        $checkuser = User::where('mobile',$request->mobile)->first();

        if($checkuser){

            if($request->has('profile_image'))
            {
                $image = $request->file('profile_image');

                $profile = rand() . '.' . $image->getClientOriginalExtension();

                $valid_ext = array('png','jpeg','jpg');

                // Location
                $location = public_path('upload/profile/').$profile;

                $file_extension = pathinfo($location, PATHINFO_EXTENSION);
                $file_extension = strtolower($file_extension);

                if(in_array($file_extension,$valid_ext)){
                    $this->compressImage($image->getPathName(),$location,60);
                }
            }else{
                $profile = $checkuser->profile_photo_path;
            }


            $update = User::find($checkuser->id);
            $update->username = $request->username;
            $update->role_id = $request->role_id;
            $update->name = $request->name;
            $update->mobile = $request->mobile;
            $update->email = $request->email;
            $update->address = $request->address;
            $update->pin_code = $request->pin_code;
            $update->city = $request->city;
            $update->birth_date = $request->birth_date;
            $update->user_type = $request->user_type;
            $update->gender = $request->gender;
            $update->profile_photo_path = $profile;
            $update->institute_id = isset($request->institute_id) ? $request->institute_id:null;
            $update->save();

            $image="";
            if($update->profile_photo_path){
                $image = config('ramdoot.appurl')."/upload/profile/".$update->profile_photo_path;    
            }
            

            $data = ['role_id' => $update->role_id,'name' => $update->name,'mobile' => $update->mobile,'email' => $update->email,'address' => $update->address,'pin_code' => $update->pin_code,'city' => $update->city,'birth_date' => $update->birth_date,'user_type' => $update->user_type,'gender' => $update->gender,'profile_photo' => $image,'username' => $update->username,'institute_id' => $update->institute_id,'id'=>$checkuser->id];

            return response()->json([
                "code" => 200,
                "message" => "success",
                "data" => $data,
            ]);
        }
        else{
            return response()->json([
                "code" => 500,
                "message" => "User not found.",
                "data" => [],
            ]); 
        }

        

    }   

    public function logout(Request $request)
    {      

        $rules = array(
            'user_id' => 'required',
            'device_token' => 'required'
        );
        $messages = array(
            'user_id.required' => 'Please enter user id.',
            'device_token.required' => 'Please enter device token.'
        );

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            $msg = $validator->messages();
            return ['code' => 500,'message'=>'Invalid input','data' => $msg];
        }

        //$check_token = UserDeviceToken::where(['user_id' => $request->user_id,'device_token' => $request->device_token])->first();
        $check_token = UserDeviceToken::where(['device_token' => $request->device_token])->delete();

        return response()->json([
            'message' => 'Successfully logged out'
        ]);   

        // if($check_token){
        //     UserDeviceToken::where(['id' => $check_token->id])->delete();
        //     return response()->json([
        //         'message' => 'Successfully logged out'
        //     ]);    
        // }
        // else{
        //     return response()->json([
        //         "code" => 400,
        //         "message" => "User not found."
        //     ]); 
        // }

        
	}

    function compressImage($source, $destination, $quality) {
      $info = getimagesize($source);

      if ($info['mime'] == 'image/jpeg') 
        $image = imagecreatefromjpeg($source);

      elseif ($info['mime'] == 'image/gif') 
        $image = imagecreatefromgif($source);

      elseif ($info['mime'] == 'image/png') 
        $image = imagecreatefrompng($source);

      imagejpeg($image, $destination, $quality);
    }
}
