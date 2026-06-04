<?php

namespace App\Http\Controllers\Admin;

use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\GeneralSettings;

class EmailController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }
    
    public function config(){
        $data = GeneralSettings::find(1);
        return view('admin.email.config',compact('data'));
    }
    public function group(){
        return view('admin.email.group');
    }

    public function groupmailsend(Request $request){
        Toastr::error('Coming soon');
        return redirect()->back();
    }
}
