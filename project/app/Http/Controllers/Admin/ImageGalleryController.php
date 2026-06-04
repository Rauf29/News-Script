<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ImageAlbum;
use App\Models\ImageCategory;
use App\Models\ImageGallery;
use App\Models\Language;

use Illuminate\Support\Facades\Validator;
use Datatables;

class ImageGalleryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }
    
    public function datatables(){
        $all = ImageGallery::orderBy('id','desc')->get();
        $groups = $all->groupBy(function($item) {
            return $item->image_album_id . '|' . $item->image_category_id;
        });

        $datas = collect();
        foreach($groups as $key => $items) {
            $first = $items->first();
            $datas->push([
                'id' => $first->id,
                'language_id' => $first->language_id,
                'image_album_id' => $first->image_album_id,
                'image_category_id' => $first->image_category_id,
                'album_name' => $first->album->album_name ?? '',
                'category_name' => $first->category->name ?? '',
                'language_name' => $first->language->language ?? '',
                'images' => $items->pluck('gallery')->toArray(),
                'count' => $items->count(),
            ]);
        }

        return Datatables::of($datas)
                            ->addColumn('action', function($data) {
                                $manageUrl = route('image.gallery.manage', [$data['image_album_id'], $data['image_category_id']]);
                                $addMoreUrl = route('image.gallery.add.more', [$data['image_album_id'], $data['image_category_id']]);
                                $deleteGroupUrl = route('image.gallery.delete.group', [$data['image_album_id'], $data['image_category_id']]);
                                return '<div class="action-list">'
                                    . '<a href="'.$manageUrl.'"> <i class="fas fa-eye"></i> View Images</a>'
                                    . '<a href="'.$addMoreUrl.'"> <i class="fas fa-plus"></i> Add More</a>'
                                    . '<a href="javascript:;" data-href="'.$deleteGroupUrl.'" data-toggle="modal" data-target="#confirm-delete" class="delete"><i class="fas fa-trash-alt"></i> Delete All</a>'
                                    . '</div>';
                            })
                            ->addColumn('gallery', function($data) {
                                $html = '<div style="display:flex;flex-wrap:wrap;gap:4px;">';
                                $count = 0;
                                foreach($data['images'] as $img) {
                                    if($count >= 5) break;
                                    $html .= '<img src="'.url('assets/images/image-gallery/'.$img).'" width="50" height="50" style="object-fit:cover;border-radius:3px;">';
                                    $count++;
                                }
                                if($data['count'] > 5) {
                                    $html .= '<span style="display:inline-flex;align-items:center;justify-content:center;width:50px;height:50px;background:#eee;border-radius:3px;font-size:13px;font-weight:700;">+'.($data['count']-5).'</span>';
                                }
                                $html .= '</div>';
                                return $html;
                            })
                            ->editColumn('image_album_id', function($data) {
                                return $data['album_name'];
                            })
                            ->editColumn('image_category_id', function($data) {
                                return $data['category_name'];
                            })
                            ->editColumn('language_id', function($data) {
                                return $data['language_name'];
                            })
                            ->rawColumns(['action', 'gallery'])
                            ->toJson();
    }
    public function index(){
        return view('admin.image-gallery.index');
    }
    public function create(){
        $languages = Language::orderBy('id','desc')->get();
        return view('admin.image-gallery.create',compact('languages'));
    }
    public function manage($album_id, $category_id){
        $images = ImageGallery::where('image_album_id', $album_id)
            ->where('image_category_id', $category_id)
            ->orderBy('id', 'desc')
            ->get();
        $album = ImageAlbum::find($album_id);
        $category = ImageCategory::find($category_id);
        return view('admin.image-gallery.manage', compact('images', 'album', 'category'));
    }

    public function addMore($album_id, $category_id){
        $album = ImageAlbum::find($album_id);
        $category = ImageCategory::find($category_id);
        $languages = Language::orderBy('id','desc')->get();
        return view('admin.image-gallery.add-more', compact('album', 'category', 'languages'));
    }

    public function deleteGroup($album_id, $category_id){
        $images = ImageGallery::where('image_album_id', $album_id)
            ->where('image_category_id', $category_id)
            ->get();
        foreach($images as $image){
            @unlink('assets/images/image-gallery/'.$image->gallery);
            $image->delete();
        }
        $msg = 'All Images Deleted Successfully';
        return response()->json($msg);
    }

    public function albumByLanguage($id){
        $datas = Language::findOrFail($id)->albums;
         $output = '<option value="">Please Select Your Album</option>';
         foreach($datas as $data){
             $output .= '<option value="'.$data->id.'">'.$data->album_name.'</option>';
         }
         return $output;
    }
    public function categoryByAlbum($id){
        $datas = ImageAlbum::findOrFail($id)->categories;
         $output = '<option value="">Please Select Your Category</option>';
         foreach($datas as $data){
             $output .= '<option value="'.$data->id.'">'.$data->name.'</option>';
         }
         return $output;
    }
    public function store(Request $request){
        $rules = [
            'language_id' => 'required',
            'image_album_id' => 'required',
            'image_category_id' => 'required',
        ];
        $validation = Validator::make($request->all(),$rules);
        if($validation->fails()){
            return response()->json(['errors'=>$validation->getMessageBag()->toArray()]);
        }
        $language = $request->language_id;
        $album = $request->image_album_id;
        $category = $request->image_category_id;
        if ($files = $request->file('gallery')){
            foreach ($files as  $key => $file){
                $val = $file->getClientOriginalExtension();
                if($val == 'jpeg'|| $val == 'jpg'|| $val == 'png'|| $val == 'svg')
                  {
                    $gallery = new ImageGallery();
                    $ext = $file->getClientOriginalExtension();
                    $name = time().'-'.preg_replace('/[^A-Za-z0-9\-_]/', '-', pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)).'.'.$ext;
                    $name = preg_replace('/-+/', '-', $name);
                    $file->move('assets/images/image-gallery',$name);
                    $gallery['gallery'] = $name;
                    $gallery['language_id'] = $language;
                    $gallery['image_album_id'] = $album;
                    $gallery['image_category_id'] = $category;
                    $gallery->save();
                  }
            }
        }
        $msg = 'Data Added Successfully';
        return response()->json($msg);
    }
    public function edit($id){
        $data = ImageGallery::findOrFail($id);
        $languages = Language::orderBy('id','desc')->get();
        return view('admin.image-gallery.edit',compact('data','languages'));
    }
    public function albumByLanguageUpdate($x,$y){
        $datas   = Language::findOrFail($x)->albums;
        $gallery = ImageGallery::findOrFail($y);
         $output = '<option value="">Please Select Your Album</option>';
         foreach($datas as $data){
            if($data->id == $gallery->image_album_id){
                $msg = 'selected';
            }else{
                $msg = '';
            }
             $output .= '<option value="'.$data->id.'" '.$msg.'>'.$data->album_name.'</option>';
         }
         return $output;
    }
    public function categoryByAlbumUpdate($x,$y){
        $datas = ImageAlbum::findOrFail($x)->categories;
        $gallery = ImageGallery::findOrFail($y);
         $output = '<option value="">Please Select Your Category</option>';
         foreach($datas as $data){
            if($data->id == $gallery->image_category_id){
                $msg = 'selected';
            }else{
                $msg = '';
            }
             $output .= '<option value="'.$data->id.'" '.$msg.'>'.$data->name.'</option>';
         }
         return $output;
    }
    public function update(Request $request,$id){
        $rules = [
            'language_id' => 'required',
            'image_album_id' => 'required',
            'image_category_id' => 'required',
            'gallery' => 'image|mimes:jpeg,png,jpg,gif,svg,webp,heic',
        ];
        $validation = Validator::make($request->all(),$rules);
        if($validation->fails()){
            return response()->json(['errors'=>$validation->getMessageBag()->toArray()]);
        }
        $data = ImageGallery::findOrFail($id);
        $input = $request->all();
        if($request->hasFile('gallery')){
            $file = $request->file('gallery');
            $val = $file->getClientOriginalExtension();
            if($val == 'jpeg'|| $val == 'jpg'|| $val == 'png'|| $val == 'svg')
                  {
                    $ext = $file->getClientOriginalExtension();
                    $name = time().'-'.preg_replace('/[^A-Za-z0-9\-_]/', '-', pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)).'.'.$ext;
                    $name = preg_replace('/-+/', '-', $name);
                    $file->move('assets/images/image-gallery',$name);
                    @unlink('assets/images/image-gallery/'.$data->gallery);
                    $input['gallery'] = $name;
                  }
        }
        $data->update($input);
        $msg = 'Data Updated Successfully';
        return response()->json($msg);
    }

    public function delete($id){
        $data = ImageGallery::findOrFail($id);
        @unlink('assets/images/image-gallery/'.$data->gallery);
        $data->delete();
        $msg = 'Data Deleted Successfully';
        return response()->json($msg);

    }
}
