<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\GeneralSettings;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Classes\geniusMailer;


class ForgotController extends Controller
{
    public function showForgotForm()
    {
      return view('frontend.forgot');
    }

    public function forgot(Request $request)
    {
        $gs = GeneralSettings::findOrFail(1);

        $user = User::where('email', $request->email)->first();
        if (!$user) {
          return response()->json(array('errors' => [ 0 => 'No Account Found With This Email.' ]));
        }

        $token = Str::random(60);
        $user->update(['verification_link' => $token]);

        $resetLink = route('user.reset.password.form', $token);
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
      $user = User::where('verification_link', $token)->first();
      if (!$user) {
          return redirect()->route('front.LogReg')->withErrors(['Invalid or expired reset token.']);
      }
      return view('frontend.reset', compact('token'));
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

      $user = User::where('verification_link', $request->token)->first();
      if (!$user) {
          return response()->json(array('errors' => [ 0 => 'Invalid or expired reset token.' ]));
      }

      $user->update([
          'password' => bcrypt($request->password),
          'verification_link' => null,
      ]);

      return response()->json('Password has been reset successfully. You can now login with your new password.');
    }
}
