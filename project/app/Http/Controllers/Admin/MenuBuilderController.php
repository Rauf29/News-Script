<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Language;
use Toastr;

class MenuBuilderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }
    
    public function index(){
        $default_language   = Language::where('is_default',1)->first();
        $first_category = Category::where('parent_id','=',null)->where('language_id','=',$default_language->id)->first();

        if($first_category !=null){
            $data['menuBuilders'] = Category::orderBy('category_order','asc')
                                            ->where('id', '!=' , $first_category->id)
                                            ->where('parent_id','=',null)
                                            ->where('language_id','=',$default_language->id)
                                            ->get();
        }else{
             $data['menuBuilders'] = null;
        }
        return view('admin.menu-builder.index',$data);
    }

    public function store(Request $request){
        $category_list = $request->category_id_array;
        if (!is_array($category_list)) {
            return response()->json(['error' => 'Invalid category data']);
        }
        foreach($category_list as $i => $category_id)
        {
            $data = Category::find($category_id);
            if ($data) {
                $data->category_order = $i;
                $data->update();
            }
        }
        return response()->json('Menu Updated Successfully');
    }
}
