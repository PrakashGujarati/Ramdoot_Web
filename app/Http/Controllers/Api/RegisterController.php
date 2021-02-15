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
            'name' => 'required|min:4',
            'mobile' => 'required|numeric|min:10',
            'password' => 'required|min:8',
        ]);
 
        $user = User::create([
            'name' => $request->name,            
            'mobile' => $request->mobile,
            'password' => bcrypt($request->password)
        ]);
       
        $token = $user->createToken('Ramdoot')->accessToken;
 
        return response()->json(['token' => $token], 200);
    }
 
    /**
     * Login
     */
    public function login(Request $request)
    {
        $data = [
            'mobile' => $request->mobile,
            'password' => $request->password
        ];
 
        if (auth()->attempt($data)) {
            $token = auth()->user()->createToken('Ramdoot')->accessToken;
            return response()->json(['token' => $token], 200);
        } else {
            return response()->json(['error' => 'Unauthorised'], 401);
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
