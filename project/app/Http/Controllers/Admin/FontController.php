<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Font;
use Brian2694\Toastr\Facades\Toastr;
use Datatables;

class FontController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }
    
    public function datatables(){
        $datas = Font::orderBy('id','desc')->get();
        return Datatables::of($datas)
                            ->addColumn('action',function(Font $data){
                                $token = csrf_token();
                                $default = $data->is_default == 1 ? '<a><i class="fa fa-check"></i> Default</a>' : '<form method="POST" action="'.route('admin.fonts.status',$data->id).'" style="display:inline">'.csrf_field().'<button type="submit" class="btn btn-link" style="padding:0"><i class="fa fa-check"></i> Set Default</button></form>';
                                return '<div class="action-list">'.$default.'</div>';
                            })
                            ->rawColumns(['action'])
                            ->toJson();
    }

    public function index(){
        return view('admin.fonts.index');
    }

    public function status($id){
        $font_update =  Font::find($id);
        $font_update->is_default = 1;
        $font_update->update();

        $previous_fonts = Font::where('id','!=',$id)->get();

        foreach($previous_fonts as $previous_font){
            $previous_font->is_default = 0;
            $previous_font->update();
        }
        Toastr::success('Data Updated Successfully');
        return redirect()->back();
   }
}
