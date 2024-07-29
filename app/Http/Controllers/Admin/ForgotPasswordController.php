<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\{ Auth, Mail, DB };
use Carbon\Carbon;
use App\Models\User;
use App\Http\Requests\PasswordRequest;



class ForgotPasswordController extends Controller
{
    //
        /**
         * Write code on show Forgetpassword Form
         */
        public function showForgetPasswordForm()
        {
            return view('auth.forgetPassword');
        }

        /**
     * Write code on check User Email Authenticated
     */
    public function submitForgetPasswordForm(PasswordRequest $request)
    {


        $token = Str::random(10);

        DB::connection('mysql')->table('password_resets')->insert([
            'email' => $request->email,
            'token' => $token,
            'created_at' => Carbon::now()
        ]);

        // Send Mail
        try {
            Mail::send(
                'auth.email',
                ['token' => $token],
                function ($message) use ($request) {
                    $message->from('developers@harmistechnology.com');
                    $message->to($request->email);
                    $message->subject('Reset Password');
                }
            );
           User::where('email', $request->email)->update(['remember_token' => $token]);
        return back()->with('success', 'We have e-mailed your password reset link!');

        }
        catch (\Throwable $th)
        {
            return back()->with('error', 'Failed to send an Email');
        }

        return back()->with('success', 'We have e-mailed your password reset link!');
    }

    public function showresetpasswordform($token)
    {
        return view('auth.resetPassword',['token' => $token]);
    }

    public function submitresetpasswordform(PasswordRequest $request)
    {
        $updatePassword = DB::connection('mysql')->table('users')
        ->where([
            'remember_token' => $request->token
            ])->first();
        if (!$updatePassword)
        {
            return back()->withInput()->with('error', 'Invalid token!');
        }
        // User Update Password
        $user = User::where('remember_token', $request->token)
        ->update(['password' => bcrypt($request->password)]);

        DB::connection('mysql')->table('password_resets')->where(['token'=> $request->token])->delete();

        return redirect()->route('admin.login')->with('success', 'Your password has been changed!');
    }
}
