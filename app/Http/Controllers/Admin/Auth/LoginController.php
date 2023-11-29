<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function show()
    {
        return view('auth.login');
    }

    public function dashboard()
    {
        return to_route('home');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'phone' => 'required|regex:/(01)[0-9]{9}/|exists:users,phone|max:11',
            'password' => 'required|min:6'
        ]);

        $user = User::where('phone', $credentials['phone'])->first();

        if($user->role != 1) {
            return redirect()->back()->withInput()->with('error', 'Access denied');
        }

        if (!Auth::attempt( $credentials)) {

            return redirect()->back()->withInput()->with('error', 'Incorrect Password');
        }

        return redirect()->route('admin.dashboard');
    }

    public function logout()
    {
        Session::flush();
        Auth::logout();

        return redirect('/');
    }
}



