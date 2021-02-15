<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\BaseController as BaseController;
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
        
    }   

    public function logout(Request $request)
    {      
		$request->user()->token()->revoke();
        return response()->json([
            'message' => 'Successfully logged out'
        ]);
	}
}
