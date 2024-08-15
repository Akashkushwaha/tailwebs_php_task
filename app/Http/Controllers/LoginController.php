<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{

    public function __construct()
    {
        $this->middleware('guest')->except(['logout']);
    }

    public function register()
    {
        return view('register');
    }

    public function login()
    {
        return view('login');
    }

    public function register_user(Request $request)
    {
        $request->validate([
            'registration_type' => 'required|numeric',
            'username' => 'required',
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $name = $request->username;
        $email = $request->email;
        $password = Hash::make($request->password);
        $regsitration_type = $request->registration_type;

        $check_existing_user = $user = User::where('email', $email)->first();

        if (!empty($check_existing_user)) {
            return redirect()->route('register')->with('error', 'User already exists');
        }

        $create_user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => $password,
            'user_role_type_id' => $regsitration_type
        ]);

        if (empty($create_user)) {
            return redirect()->route('login')->with('error', 'User not created. Please try again after sometime');
        }

        return redirect()->route('login')->with('success', 'User created successfully');
    }

    public function attempt_login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $request_array = [
            'email' => $request->email,
            'password' => $request->password
        ];

        if (Auth::attempt($request_array)) {
            if (Auth::user()->user_role_type_id != 1) {
                Auth::logout();
                return redirect()->route('login')->with('error', 'Logged In User Not a Teacher');
            }
            return redirect()->route('dashboard');
        }

        return redirect()->route('login')->with('error', 'Invalid credentials');
    }

    public function logout()
    {
        Auth::logout();

        return redirect()->route('login');
    }
}
