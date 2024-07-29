<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;




class AuthController extends Controller
{
    // Show Admin Login Form
    public function showAdminLogin()
    {


        return view('auth.login');
    }

    // Authenticate the Admin User
    public function Adminlogin(Request $request)
    {
        $input = $request->except('_token');
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if(Auth::attempt($input))
        {
            $username = Auth::user()->name;
            return redirect()->route('dashboard')->with('success', 'Welcome '.$username);
        }

        return back()->with('error', 'Please Enter Valid Email & Password');
    }
}
