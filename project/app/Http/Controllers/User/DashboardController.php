<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        $data['posts'] = Post::whereUserId(auth()->id())->count();
        $data['articles'] = Post::wherePostType('article')->whereUserId(auth()->id())->count();
        $data['audios'] = Post::wherePostType('audio')->whereUserId(auth()->id())->count();
        $data['videos'] = Post::wherePostType('video')->whereUserId(auth()->id())->count();
        $data['personalites'] = Post::wherePostType('Personality Quiz')->whereUserId(auth()->id())->count();
        $data['trivias'] = Post::wherePostType('Trivia Quiz')->whereUserId(auth()->id())->count();
        $data['sorted'] = Post::wherePostType('Sorted List')->whereUserId(auth()->id())->count();
        $data['pending_posts'] = Post::whereUserId(auth()->id())->where('is_pending','=',1)->where('status','=','true')->count();
        $data['drafts'] = Post::whereUserId(auth()->id())->where('status','=','draft')->count();
        $data['schedules'] = Post::whereUserId(auth()->id())->where('status','=','true')->where('schedule_post','=',1)->where('is_pending','=',0)->count();


        return view('user.dashboard',$data);
    }

    public function profile()
    {
        $data = auth()->user();
        return view('user.profile.edit',compact('data'));
    }

    public function profileupdate(Request $request)
    {
        //--- Validation Section
        $data = auth()->user();
        $rules =
        [
            'photo' => 'mimes:jpeg,jpg,png,svg',
            'email' => 'required|unique:users,email,'.$data->id,
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
          return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        }
        //--- Validation Section Ends
        $input = $request->all();

        if ($file = $request->file('photo'))
        {
            $name = time().Str::random(8).'.'.$file->getClientOriginalExtension();
            $file->move('assets/images/admin/',$name);
            @unlink('assets/images/admin/'.$data->photo);
            $input['photo'] = $name;
        }
        $data->update($input);
        $msg = 'Successfully updated your profile';
        return response()->json($msg);
    }

    public function passwordreset()
    {
        $data = auth()->user();
        return view('user.profile.password',compact('data'));
    }

    public function changepass(Request $request)
    {
        $admin = auth()->user();
        if ($request->cpass){
            if (Hash::check($request->cpass, $admin->password)){
                if ($request->newpass == $request->renewpass){
                    $input['password'] = Hash::make($request->newpass);
                }else{
                    return response()->json(array('errors' => [ 0 => 'Confirm password does not match.' ]));
                }
            }else{
                return response()->json(array('errors' => [ 0 => 'Current password Does not match.' ]));
            }
        }
        $admin->update($input);
        $msg = 'Successfully change your passwprd';
        return response()->json($msg);
    }

    public function logout(){
        auth()->logout();
        return redirect('/log-reg');
    }
}
