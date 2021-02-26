<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Validator;

class RegisterController extends Controller
{
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
        
        // $rules = array(
        //     'user_id' => 'required'
        // );
        // $messages = array(
        //     'user_id.required' => 'Please enter user id.'
        // );

        // $rules = array(
        //     'mobile' => 'required|unique:users,mobile,'.$request->user_id,
        // );
        // $messages = array(      
        //     'mobile.required' => 'Please enter mobile number.'
        // );

        $rules = array(
             'mobile' => 'required',
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
            $update->name = $request->name;
            $update->mobile = $request->mobile;
            $update->email = $request->email;
            $update->address = $request->address;
            $update->pin_code = $request->pin_code;
            $update->city = $request->city;
            $update->birth_date = $request->birth_date;
            $update->profile_photo_path = $profile;
            $update->save();

            $image="";
            if($update->profile_photo_path){
                $image = env('APP_URL')."/upload/profile/".$update->profile_photo_path;    
            }

            $data = ['name' => $update->name,'mobile' => $update->mobile,'email' => $update->email,'address' => $update->address,'pin_code' => $update->pin_code,'city' => $update->city,'birth_date' => $update->birth_date,'profile_photo' => $image];

            return response()->json([
                "code" => 200,
                "message" => "success",
                "data" => $data,
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

    public function logout(Request $request)
    {      
		$request->user()->token()->revoke();
        return response()->json([
            'message' => 'Successfully logged out'
        ]);
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
