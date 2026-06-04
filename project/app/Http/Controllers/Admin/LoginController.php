<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Mail\Forgot;
use App\Models\Admin;
use App\Models\GeneralSettings;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Classes\geniusMailer;

class LoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest:admin');
    }
    
    public function loginForm(){
        return view('admin.login');
    }

    public function login(Request $request){
            $rules = [
                'email'    => 'required|email',
                'password' => 'required'
            ];

            $validator = Validator::make($request->all(),$rules);

            if($validator->fails()){
                return response()->json(['errors'=>$validator->getMessageBag()->toArray()]);
            }

        if(Auth::guard('admin')->attempt(['email'=>$request->email,'password'=>$request->password], $request->remember)){
            if(Auth::guard('admin')->user()->verify == 0)
            {
                Auth::guard('admin')->logout();
                return response()->json(array('errors' => [ 0 => 'Your Email is not Verified!' ]));   
            }

            if(Auth::guard('admin')->user()->role_id == 1){
                return response()->json(route('admin.dashboard'));
            }else{
                Auth::guard('admin')->logout();
                return response()->json(array('errors' => [ 0 => 'Credentials Doesn\'t Match !' ]));
            }

        }else{
            return response()->json(array('errors' => [0 => 'Credential Doesn,t Match']));
        }
    }

    public function showForgotForm()
    {
      return view('admin.forgot');
    }

    public function forgot(Request $request)
    {
      $gs = GeneralSettings::findOrFail(1);

      $admin = Admin::where('email', $request->email)->first();
      if (!$admin) {
        return response()->json(array('errors' => [ 0 => 'No Account Found With This Email.' ]));
      }

      $token = Str::random(60);
      $admin->update(['token' => $token]);

      $resetLink = route('admin.reset.password.form', $token);
      $subject = "Reset Password Request";
      $msg = "We received a password reset request. Click the link below to reset your password:\n\n".$resetLink."\n\nIf you did not request this, please ignore this email.";

      if($gs->is_smtp == 1)
      {
          $data = [
              'to' => $request->email,
              'subject' => $subject,
              'body' => $msg,
          ];
          $mailer = new geniusMailer();
          $mailer->sendCustomMail($data);                
      }
      else
      {
          $headers = "From: ".$gs->from_name."<".$gs->from_email.">";
          mail($request->email, $subject, $msg, $headers);            
      }
      return response()->json('Password reset link has been sent to your email. Please check your inbox.');
    }

    public function showResetForm($token)
    {
      $admin = Admin::where('token', $token)->first();
      if (!$admin) {
          return redirect()->route('admin.loginForm')->withErrors(['Invalid or expired reset token.']);
      }
      return view('admin.reset', compact('token'));
    }

    public function reset(Request $request)
    {
      $rules = [
          'token' => 'required',
          'password' => 'required|min:8|confirmed',
      ];

      $validator = Validator::make($request->all(), $rules);
      if ($validator->fails()) {
          return response()->json(['errors' => $validator->getMessageBag()->toArray()]);
      }

      $admin = Admin::where('token', $request->token)->first();
      if (!$admin) {
          return response()->json(array('errors' => [ 0 => 'Invalid or expired reset token.' ]));
      }

      $admin->update([
          'password' => bcrypt($request->password),
          'token' => null,
      ]);

      return response()->json('Password has been reset successfully. You can now login with your new password.');
    }
}
