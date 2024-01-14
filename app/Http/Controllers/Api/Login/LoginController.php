<?php

namespace App\Http\Controllers\Api\Login;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Throwable;

class LoginController extends Controller
{
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
