<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Mail;
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
              $user = Auth::user();
              $id = $user->id;
              $input['status'] = 'Online';
                User::where('id',$id)->update($input);
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
        // dd($seeking);
        return view('landing', compact('users','seo_title','default_preference'));
    }

    public function forgetPassword(Request $request)
    {
      return view('forget_password');
    }
    public function checkEmail(Request $request)
    {
      // dd($request->all());
      $string = rand(5,999999999);
      // dd($string);
      $token = $string;
      $email = $request->input('email');
      $toemail=$email;
      $user = User::where('email','=',$email)->first();
      // dd($toemail);
      if ($user =="") {
        $request->session()->flash('resetAlert', "We can't find a user with that e-mail address.");
        return redirect()->back();
      }
      $first_name = "waqas";
      $last_name = "ali";
      // $first_name = $user->firstname;
      // $last_name = $user->lastname;
      $user_info['forget_token']=$token;
      // dd($toemail);
      Mail::send('mail.resetpassword',['u_name' =>$first_name." ".$last_name,'token' =>$token],
      function ($message) use ($toemail)
      {

        $message->subject('demo.myclouddate.com - Reset Password');
        $message->from('clouddate.dating@gmail.com', 'Singles Dating World');
        $message->to($toemail);
      });
      $user_id = User::where('email','=',$email)->update($user_info);
      $request->session()->flash('resetSuccess', 'Check your Email to change your password.');
      return redirect('/forget-password');

    }
}
