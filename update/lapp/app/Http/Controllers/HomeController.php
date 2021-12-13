<?php

namespace App\Http\Controllers;

use Auth;
use Hash;
use Illuminate\Http\Request;

class HomeController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /** Index */
    public function index()
    {
        return view('admin');
    }

     /** Account Settings Form */
     public function accountsettingsform()
    {
        return view('adminlte::settings.account');
    }

      /** Account Settings */
      public function accountsettings(Request $request)
    {
        if ($request->get('email') != Auth::user()->email) {
            if ((Hash::check($request->get('current-password'), Auth::user()->password))) {
                //Change E-mail
                $user = Auth::user();
                $user->email = $request->get('email');
                $user->save();
                return redirect()->back()->with("success", __('admin.email_changed'));
            }
        }

        if (!(Hash::check($request->get('current-password'), Auth::user()->password))) {
            // The passwords matches
            return redirect()->back()->with("error", __('admin.password_match_problem'));
        }

        if (strcmp($request->get('current-password'), $request->get('new-password')) == 0) {
            //Current password and new password are same
            return redirect()->back()->with("error", __('admin.new_old_password_same'));
        }

        $validatedData = $request->validate([
            'current-password' => 'required',
            'new-password' => 'required|string|min:6|confirmed',
        ]);

        //Change Password
        $user = Auth::user();
        $user->password = bcrypt($request->get('new-password'));
        $user->save();
        return redirect()->back()->with("success", __('admin.password_changed'));
    }

}
