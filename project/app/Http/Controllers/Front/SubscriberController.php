<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Subscriber;
use Illuminate\Support\Facades\Validator;
use Toastr;

class SubscriberController extends Controller
{
    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
        ]);
        if ($validator->fails()) {
            Toastr::error('Please enter a valid email address.');
            return back();
        }
        $subscriber = Subscriber::where('email', $request->email)->first();
        if (!empty($subscriber)) {
            Toastr::error('This email is already subscribed!');
            return back();
        }
        $data = new Subscriber();
        $input = $request->all();
        $data->fill($input)->save();
        Toastr::success('You have subscribed successfully!');
        return back();
    }
}
