<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        // fetch user details
        $user = User::where('email', $request->email)->first();
        if(!$user) {
            return redirect()->back()->with('error','Credentials does not matched from our database!');
        }
        if(Auth::attempt(['email'=>$request->email,'password'=>$request->password, 'is_admin' => 1])){
            return redirect()->route('home')->with('success','Login Successfully');
        }
        else{
            return redirect()->back()->with('error','You have not admin privileges to access this dashboard!');
        }

        // $request->session()->regenerate();
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        toast('Logged out Successfully !','success');

        Auth::logout();
        return redirect()->route('home')->with('success', 'You have been successfully logged out!');
    }
}
