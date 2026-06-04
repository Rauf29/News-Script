<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\GeneralSettings;
use App\Models\Role;
use Toastr;
use Auth;
use App\Classes\geniusMailer;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    public function LogReg(){
        $this->code_image();
        return view('frontend.log-reg');
    }

    public function register(Request $request){
        $gs = GeneralSettings::findOrFail(1);

    	if($gs->is_capcha == 1)
    	{

            $rules=[
                'email'=> 'required|email|unique:users',
                'password'=> 'required|min:8|confirmed',
                'g-recaptcha-response' => 'required|captcha'
            ];
        }
        else
        {
            $rules=[
                'email'=> 'required|email|unique:users',
                'password'=> 'required|min:8|confirmed'
            ];
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        }

        $gs = GeneralSettings::findOrFail(1);
        $author  = new User();
        $input = $request->all();
        $input['password'] =bcrypt($request['password']);
        $input['token'] = md5(time().$request->name.$request->email);
        $token  = $input['token'];

        $author->fill($input)->save();

        if($gs->is_verification_email == 1)
        {
            $to = $request->email;
            $subject = 'Verify your email address.';
            $msg = "Dear Customer,<br> We noticed that you need to verify your email address. <a href=".url('register/verify/'.$token).">Simply click here to verify. </a>";

            if($gs->is_smtp == 1)
            {
                $data = [
                    'to' => $to,
                    'subject' => $subject,
                    'body' => $msg,
                ];

                $mailer = new geniusMailer();
                $mailer->sendCustomMail($data);
            }
            else
            {
                $headers = "From: ".$gs->from_name."<".$gs->from_email.">";
                mail($to,$subject,$msg,$headers);
            }
            return response()->json('We need to verify your email address. We have sent an email to '.$to.' to verify your email address.');
        }

    }

    public function token($token)
    {
          $user = User::where('token',$token)->first();
          if($user){
              $user->status = 1;
              $user->verify = 1;
              $user->token  = NULL;
              $user->update();

              Auth::guard('web')->login($user);
              Toastr::success('You are welcome!','success');
              return redirect()->route('frontend.index');
          }
          else{
              Toastr::error('Token mismatch!','error');
              return redirect('/');
          }
    }

    private function  code_image()
    {
        $actual_path = str_replace('project','',base_path());
        $image = imagecreatetruecolor(200, 50);
        $background_color = imagecolorallocate($image, 255, 255, 255);
        imagefilledrectangle($image,0,0,200,50,$background_color);

        $pixel = imagecolorallocate($image, 0,0,255);
        for($i=0;$i<500;$i++)
        {
            imagesetpixel($image,rand()%200,rand()%50,$pixel);
        }

        $font = $actual_path.'assets/front/fonts/NotoSans-Bold.ttf';
        $allowed_letters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        $length = strlen($allowed_letters);
        $letter = $allowed_letters[rand(0, $length-1)];
        $word='';
        //$text_color = imagecolorallocate($image, 8, 186, 239);
        $text_color = imagecolorallocate($image, 0, 0, 0);
        $cap_length=6;// No. of character in image
        for ($i = 0; $i< $cap_length;$i++)
        {
            $letter = $allowed_letters[rand(0, $length-1)];
            imagettftext($image, 25, 1, 35+($i*25), 35, $text_color, $font, $letter);
            $word.=$letter;
        }
        $pixels = imagecolorallocate($image, 8, 186, 239);
        for($i=0;$i<500;$i++)
        {
            imagesetpixel($image,rand()%200,rand()%50,$pixels);
        }
        session(['captcha_string' => $word]);
        imagepng($image, $actual_path."assets/images/capcha_code.png");
    }
}
