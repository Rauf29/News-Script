<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Language;
use App\Models\PollQuestion;
use App\Models\Post;
use App\Models\Role;
use App\Models\Rss;
use App\Models\Subscriber;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use InvalidArgumentException;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }
    
    public function index(){
        $default_language = Language::where('is_default',1)->first();
        $data['total_post'] = Post::all()->count();
        $data['author_post'] = Auth::guard('admin')->user()->posts->count();
        $data['pending_posts'] = Post::all()->where('is_pending','=',1)->where('status','=','true')->count();
        $data['author_pending'] = Auth::guard('admin')->user()->posts()->where('is_pending','=',1)->where('status','=','true')->count();
        $data['drafts'] = Auth::guard('admin')->user()->posts()->where('status','=','draft')->count();
        $data['schedules'] = Auth::guard('admin')->user()->posts()->where('status','=','true')->where('schedule_post','=',1)->where('is_pending','=',0)->count();
        $data['rss'] = Rss::all()->count();
        $data['polls'] = PollQuestion::all()->count();
        $data['userRole'] = Role::where('id','!=',1)->get();
        $data['subscribers'] = Subscriber::orderBy('id','desc')->orderBy('id','desc')->take(10)->get();
        $data['categories'] = Category::where('language_id','=',$default_language->id);

        return view('admin.dashboard',$data);
    }

    public function profile()
    {
        $data = Auth::guard('admin')->user();
        return view('admin.profile.edit',compact('data'));
    }

    public function profileupdate(Request $request)
    {
        //--- Validation Section
        $data = Auth::guard('admin')->user();
        $rules =
        [
            'photo' => 'mimes:jpeg,jpg,png,svg',
            'email' => 'required|unique:admins,email,'.$data->id,
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
            if($data->photo != null)
            {
                @unlink('assets/images/admin/'.$data->photo);
            }
            $input['photo'] = $name;
        }
        $data->update($input);
        $msg = 'Successfully updated your profile';
        return response()->json($msg);
    }

    public function passwordreset()
    {
        $data = Auth::guard('admin')->user();
        return view('admin.profile.password',compact('data'));
    }

    public function changepass(Request $request)
    {
        $admin = Auth::guard('admin')->user();
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
        if (!isset($input)) {
            $input = [];
        }
        $admin->update($input);
        $msg = 'Successfully change your password';
        return response()->json($msg);
    }

    public function logout(){
        Auth::guard('admin')->logout();
        return redirect('/');
    }




}
