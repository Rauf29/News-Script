<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Gallery;
use App\Models\Post;
use Illuminate\Support\Str;

class GalleryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function show(Request $request)
    {
        $data[0] = 0;
        $id = $request->id;
        $post = Post::findOrFail($id);
        if(count($post->galleries))
        {
            $data[0] = 1;
            $data[1] = $post->galleries;
        }
        return response()->json($data);
    }

    public function store(Request $request)
    {
        $data = null;
        $lastid = $request->post_id;
        if ($files = $request->file('gallery')){
            foreach ($files as  $key => $file){
                $val = $file->getClientOriginalExtension();
                if($val == 'jpeg'|| $val == 'jpg'|| $val == 'png'|| $val == 'svg')
                  {
                    $gallery = new Gallery;
                    $name = time().Str::random(8).'.'.$val;
                    $file->move('assets/images/galleries',$name);
                    $gallery['photo'] = $name;
                    $gallery['post_id'] = $lastid;
                    $gallery->save();
                    $data[] = $gallery;
                  }
            }
        }
        return response()->json($data);
    }

    public function destroy(Request $request)
    {
        $id = $request->id;
        $gal = Gallery::findOrFail($id);
        @unlink('assets/images/galleries/'.$gal->photo);
        $gal->delete();
        return response()->json('Gallery Deleted Successfully');
    }
}
