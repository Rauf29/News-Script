<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Post;
use Carbon\Carbon;
use Datatables;
use Auth;


class DraftController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }
    
    public function datatables(){
        $user = Auth::guard('admin')->user()->role;
        if($user->name == 'admin' || $user->name == 'moderator'){
            $datas = Post::where('status','=','draft')
                        ->orderBy('id','desc')
                        ->get();
        }else{
            $datas = Auth::guard('admin')->user()
                                        ->posts()
                                        ->where('status','=','draft')
                                        ->orderBy('id','desc')
                                        ->get();
        }

        return Datatables::of($datas)
                            ->addColumn('action', function(Post $data) {
                                $token = csrf_token();
                                $slider = $data->is_slider == 0 ? '<form method="POST" action="'.route('post.sliderChange',$data->id).'" style="display:inline">'.csrf_field().'<button type="submit" class="btn btn-link" style="padding:0"><i class="fa fa-plus"></i> Add Into Slider</button></form>' : '<form method="POST" action="'.route('post.sliderChange',$data->id).'" style="display:inline">'.csrf_field().'<button type="submit" class="btn btn-link" style="padding:0"><i class="fa fa-minus"></i> Remove From Slider</button></form>';
                                $is_trending = $data->is_trending == 0 ? '<form method="POST" action="'.route('post.trendingChange',$data->id).'" style="display:inline">'.csrf_field().'<button type="submit" class="btn btn-link" style="padding:0"><i class="fa fa-plus"></i> Add Into Breaking</button></form>' : '<form method="POST" action="'.route('post.trendingChange',$data->id).'" style="display:inline">'.csrf_field().'<button type="submit" class="btn btn-link" style="padding:0"><i class="fa fa-minus"></i> Remove Breaking</button></form>';
                                $is_approve = $data->is_pending == 0 ? '<form method="POST" action="'.route('post.pendingChange',$data->id).'" style="display:inline">'.csrf_field().'<button type="submit" class="btn btn-link" style="padding:0"><i class="fa fa-file"></i> Make Post Pending</button></form>' : '<form method="POST" action="'.route('post.pendingChange',$data->id).'" style="display:inline">'.csrf_field().'<button type="submit" class="btn btn-link" style="padding:0"><i class="fa fa-file"></i> Make Post Approve</button></form>';
                                $is_slider_lefts = $data->is_feature == 0 ? '<form method="POST" action="'.route('post.feature',$data->id).'" style="display:inline">'.csrf_field().'<button type="submit" class="btn btn-link" style="padding:0"><i class="fa fa-plus"></i> Add into Feature</button></form>' : '<form method="POST" action="'.route('post.feature',$data->id).'" style="display:inline">'.csrf_field().'<button type="submit" class="btn btn-link" style="padding:0"><i class="fa fa-minus"></i> Remove Feature</button></form>';
                                $is_slider_rights = $data->slider_right == 0 ? '<form method="POST" action="'.route('post.sliderright',$data->id).'" style="display:inline">'.csrf_field().'<button type="submit" class="btn btn-link" style="padding:0"><i class="fa fa-plus"></i> Add into sliderRight</button></form>' : '<form method="POST" action="'.route('post.sliderright',$data->id).'" style="display:inline">'.csrf_field().'<button type="submit" class="btn btn-link" style="padding:0"><i class="fa fa-minus"></i> Remove sliderRight</button></form>';
                                $details = '<a href="'.route('frontend.postBySubcategory.details',[$data->category->slug,$data->slug]).'"> <i class="fa fa-info-circle" aria-hidden="true"></i> View on Frontend</a>';
                                return '<div class="godropdown"><button class="go-dropdown-toggle"> Actions<i class="fas fa-chevron-down"></i></button><div class="action-list">'.$details.'<a href="'.route('post.edit',$data->id).'"> <i class="fas fa-edit"></i> Edit</a>'.$slider.''.$is_trending.''.$is_slider_lefts.''.$is_slider_rights.''. $is_approve.'<a href="javascript:;" data-href="'.route('post.delete',$data->id).'" data-toggle="modal" data-target="#confirm-delete" class="delete"><i class="fas fa-trash-alt"></i> Delete</a></div></div>';
                            })
                            ->editColumn('category_id',function(Post $data){
                                $category_id = $data->category_id ? $data->category->title : '';
                                return $category_id;
                            })
                            ->editColumn('image_big',function(Post $data){
                                $image_big = $data->image_big ? url('assets/images/post/'.$data->image_big):url('assets/images/noimage.png');
                                return '<img src="'.$image_big.'" alt="Image">';
                            })
                            ->addColumn('checkbox',function(Post $data){
                                $id = $data->id;
                                return $checkbox = $data->id ? '<input type="checkbox" class="form-check-input m-0 p-0 postCheck" value="'.$id.'">':'';
                            })
                            ->editColumn('language_id',function(Post $data){
                                $language_id = $data->language_id ? '<span class="badge badge-info">'.$data->language->language.'</span>' : '';
                                return $language_id;
                            })
                            ->editColumn('post_type',function(Post $data){
                                $post_type = $data->post_type ? '<span class="badge badge-secondary">'.$data->post_type.'</span>': '';
                                return $post_type;
                            })
                            ->editColumn('admin_id',function(Post $data){
                                $name = $data->admin_id ? $data->admin->name: '';
                                return $name;
                            })
                            ->rawColumns(['image_big','checkbox','category_id','language_id','post_type','admin_id','description','action'])
                            ->toJson(); //--- Returning Json Data To Client Side
    }
    public function index(){
        return view('admin.draft.index');
    }

    public function draftArticle(){
        $datas = Post::where('post_type','article')
        ->where('status','draft')
        ->where('schedule_post_date','<=',Carbon::now())
        ->get();

        foreach($datas as $data){
           $post = Post::find($data->id);
           $post->schedule_post = 0;
           $post->schedule_post_date = null;
           $post->status = 1;
           $post->save();
        }
    }

    public function draftAudio(){
        $datas = Post::where('post_type','audio')
        ->where('status','draft')
        ->where('schedule_post_date','<=',Carbon::now())
        ->get();
        foreach($datas as $data){
           $post = Post::find($data->id);
           $post->schedule_post = 0;
           $post->schedule_post_date = null;
           $post->status = 1;
           $post->save();
        }
    }

    public function draftVideo(){
        $datas = Post::where('post_type','video')
        ->where('status','draft')
        ->where('schedule_post_date','<=',Carbon::now())
        ->get();
        foreach($datas as $data){
           $post = Post::find($data->id);
           $post->schedule_post = 0;
           $post->schedule_post_date = null;
           $post->status = 1;
           $post->save();
        }
    }
}
