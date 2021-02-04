<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Session;

class AdminController extends Controller
{
    public function login(Request $request)
    {
        if ($request->isMethod('post')){
            $data = $request->input();
//            dd($data);
            if (Auth::attempt(['email'=>$data['email'],'password'=>$data['password'],'admin'=>1])){
//                Session::put('adminSession',$data['email']);
                return redirect('/admin/dashboard');
            }else{
                return redirect('/admin')->with('flash_message_error','Invalid Username or Password');
            }
        }
        return view('admin.admin_login');
    }

    public function dashboard()
    {
//        if (Session::has('adminSession')){
//
//        }else{
//            return redirect('/admin')->with('flash_message_error','Please login to access');
//        }
        return view('admin.dashboard');
    }

    public function settings()
    {
        return view('admin.settings');
    }

    public function chkPassword(Request $request)
    {
        $data = $request->all();
        $current_password = $data['current_pwd'];
        $check_password = User::where(['admin'=>'1'])->first();
        if (Hash::check($current_password,$check_password->password)){
            echo "true";die;
        }else{
            echo "false";die;
        }
    }

    public function logout()
    {
        Session::flush();
        return redirect('/admin')->with('flash_message_success','Logged out Successfully');
    }
}
