<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\GeneralSettings;
use Auth;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $gs = GeneralSettings::findOrFail(1);
        if($gs->is_capcha == 1)
        {
            $rules=[
                'email'=> 'required|email',
                'password'=> 'required',
                'g-recaptcha-response' => 'required|captcha'
            ];
        }
        else
        {
            $rules=[
                'email'=> 'required|email',
                'password'=> 'required'
            ];
        }
        $validator=Validator::make($request->all(),$rules);

        if($validator->fails()){
            return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        }

        if(Auth::attempt(['email'=>$request->email,'password'=>$request->password], $request->remember))
        {
            if(Auth::user()->verify == 0)
            {
                auth()->logout();
                return response()->json(array('errors' => [ 0 => 'Your Email is not Verified!' ]));
            }
            return response()->json(route('user.dashboard'));
        }
        return response()->json(array('errors' => [ 0 => 'Credentials Doesn\'t Match !' ]));

    }

    public function logout(){
        auth()->logout();
        return redirect('/log-reg');
    }
}
