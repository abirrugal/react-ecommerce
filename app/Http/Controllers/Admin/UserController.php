<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $users = User::query();

        if ($request->search) {
            $users = $users->where('first_name', 'LIKE', "%{$request->search}%")->orWhere('last_name', 'LIKE', "%{$request->search}%")->orWhere('email', 'LIKE', "%{$request->search}%")->orWhere('phone', 'LIKE', "%{$request->search}%");
        }
        $users = $users->latest()->paginate(15);

        return Inertia::render('Users/Users', ['users' => $users]);
        // return view('admin.user.index', compact('users'));
    }


    public function inactive($id)
    {

        User::findOrFail($id)->Update(['role' => 0]);

        $notification = array(
            'message' => 'User InActive Successfully ',
            'alert-type' => 'success'
        );
        return Redirect()->back()->with($notification);
    }


    public function active($id)
    {

        User::findOrFail($id)->Update(['role' => 2]);

        $notification = array(
            'message' => 'User InActive Successfully ',
            'alert-type' => 'success'
        );
        return Redirect()->back()->with($notification);
    }


    public function allInactive()
    {

        $users = User::where('role', '0')->latest()->paginate(15);

        return view('admin.user.inactive', compact('users'));
    }
}
