<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\User;

class UserController extends Controller
{
    public function index(){

        $users = User::where('role','2')->latest()->paginate(15);
        return view('admin.user.index', compact('users'));
    }


    public function inactive($id){

        User::findOrFail($id)->Update(['role' => 0]);

        $notification=array(
            'message'=>'User InActive Successfully ',
            'alert-type'=>'success'
        );
        return Redirect()->back()->with($notification);
    }


    public function active($id){

        User::findOrFail($id)->Update(['role' => 2]);

        $notification=array(
            'message'=>'User InActive Successfully ',
            'alert-type'=>'success'
        );
        return Redirect()->back()->with($notification);
    }


    public function allInactive (){

        $users = User::where('role','0')->latest()->paginate(15);

        return view('admin.user.inactive',compact('users'));
    }
}
