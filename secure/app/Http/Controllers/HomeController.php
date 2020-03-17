<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }
    public function main()
    {
        return view('home');
    }

    public function postHome()
    {
        $rules = array(
            'username' => 'required',
            'password' => 'required'
        );
        $validator = Validator::make(\request()->all(),$rules);
        if($validator->fails()){
            return redirect()->back()->withErrors((array) $validator->errors());
        }
        else{
            if(Auth::attempt(['username'=>$this->request->get('username'), 'password' => $this->request->get('password')])){
                if($this->request->has('ref')){
                    return redirect()->to($this->request->get('ref'));
                }
                else{
                    return redirect()->route('landing');
                }
            }
            else{
                return redirect()->back()->with('fail_login','Username or password is incorrect!');
            }
        }
    }

    public function landing()
    {
        $seo_title = 'Search';
        if(Auth::check()){
            $user = Auth::user();
            $default_gender = $user->gender;
            $default_preference = $user->preference == 3?[1,2]:[$user->preference];
        }
        else{
            $default_gender = 1;
            $default_preference = [2];
        }
        $gender = $this->request->get('gender');
        $seeking = $this->request->get('seeking');
        if($this->request->has('gender') && ($gender == 'male' || $gender == 'female')){
            $default_gender = $gender == 'male'?1:2;
        }
        if($seeking && is_array($seeking) && in_array('male', $seeking)){
            $default_preference = [1];
        }
        if($seeking && is_array($seeking) && in_array('female', $seeking)){
            $default_preference = [2];
        }
        if($seeking && is_array($seeking) && in_array('female', $seeking) && in_array('male', $seeking)){
            $default_preference = [1,2];
        }
        $users = User::whereIn('gender',$default_preference);
        if(Auth::check()){
            $users->whereNotIn('id',[Auth::user()->id]);
        }
        if($this->request->has('country') && $this->request->country != ''){
            $users->where('country', $this->request->country);
        }
        $users = $users->paginate(16);
        return view('landing', compact('users','seo_title','default_preference'));
    }
}
