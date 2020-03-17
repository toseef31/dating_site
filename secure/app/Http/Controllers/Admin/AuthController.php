<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function login()
    {
        return view('admin.login');
    }

    public function postLogin()
    {
        $validator = Validator::make($this->request->all(), ['email'=>'required|email', 'password'=>'required']);
        if($validator->fails()){
            return redirect()->back()->withErrors((array)$validator->errors());
        }
        else{
            if(Auth::attempt(['is_admin'=>1,'email' => $this->request->get('email'), 'password' => $this->request->get('password')])){
                return redirect()->route('adminhome');
            }
            else return redirect()->back()->with('errorlogin', 'Something went wrong');
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('adminlogin');
    }
}
