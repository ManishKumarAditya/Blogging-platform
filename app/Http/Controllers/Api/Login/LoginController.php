<?php

namespace App\Http\Controllers\Api\Login;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules;

use Throwable;

class LoginController extends Controller
{

    public function create_user(Request $request) {
        // validate incoming request
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        if ($validator->fails()) {
            $response_data['errors'] = $validator->errors()->all();
            return response()->json(['data' => $response_data], 422);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'is_admin' => 0,
            'password' => Hash::make($request->password),
            'current_ip' => $request->ip(),
        ]);

        $response_data['message'] = 'success';
        $response_data['user'] = $user;
        
        return response()->json(['data' => $response_data], 200);   

    }

    public function login_user(Request $request) {
        try {
            if (Auth::attempt(array('email' => $request->email, 'password' => $request->password))) {
                $user = User::whereEmail($request->email)->first();
                //update current ip
                
                $user->update([
                    'current_ip' => $request->ip()
                ]);

                $data['user'] = $user;
                $data['token'] = $user->createToken('my-app-token')->plainTextToken;

                return response()->json(['is_success' => true, 'message' =>'Login Successfully!!!', 'data' => $data]);
            } else {
                return response()->json(['is_success' => false, 'message' => 'Wrong Details']);
            }
        } catch (Throwable $th) {
            return response()->json(['is_success' => false, 'message' => $th->getLine()]);
        }
    }

    public function logout_user(Request $request)
    {
        try {
            $request->user()->currentAccessToken()->delete();
            return response()->json(['is_success' => true, 'message' => 'Logout Successfully!!!']);
        } catch (Throwable $th) {
            return response()->json(['is_success' => false, 'message' => $th->getMessage()]);
        }
    }
}
