<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ImageAlbum;
use App\Models\ImageGallery;
use App\Models\Language;
use App\Models\Post;

class GalleryController extends Controller
{
    public function view($x){
        $data['gallery'] = ImageAlbum::with('categories.galleries')->findOrFail($x);

        if(session()->has('language')){
            $default_language = Language::find(session()->get('language'));
        }else{
            $default_language = Language::where('is_default',1)->first();
        }

        $is_trendings = Post::where('is_trending',1)
                            ->where('is_pending',0)
                            ->where('schedule_post',0)
                            ->where('language_id','=',$default_language->id)
                            ->where('status','true')
                            ->orderBy('id','desc')
                            ->take(20)
                            ->get();

        return view('frontend.gallery_view', $data, compact('is_trendings'));
    }

    public function showImage($id){
        $image = ImageGallery::findOrFail($id);
        $path = public_path('assets/images/image-gallery/'.$image->gallery);
        if(!file_exists($path)){
            abort(404);
        }
        return response()->file($path);
    }
}
