<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Interest;
use App\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class SettingController extends Controller
{
    protected $request;
    protected $base_path;

    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->base_path = base_path('../');
    }

    public function main()
    {
        return view('admin.setting');
    }

    public function saveSetting()
    {
        $rules = array(
            'website_title' => 'required',
            'website_tagline' => 'required',
            'website_description' => 'required',
            'website_keywords' => 'required',
            'online_delay' => 'required',
            'min_age' => 'numeric',
            'min_upload' => 'numeric'
        );
        $validator = Validator::make($this->request->all(), $rules);
        if($validator->fails()){
            return redirect()->back()->withErrors((array) $validator->errors());
        }
        else{
            Setting::where('meta','website_title')->update(['value'=>$this->request->get('website_title')]);
            Setting::where('meta','website_tagline')->update(['value'=>$this->request->get('website_tagline')]);
            Setting::where('meta','website_description')->update(['value'=>$this->request->get('website_description')]);
            Setting::where('meta','website_keywords')->update(['value'=>$this->request->get('website_keywords')]);
            Setting::where('meta','analytics_code')->update(['value'=>$this->request->get('analytics_code')]);
            $captcha = $this->request->has('active_captcha')?1:0;
            $timeline = $this->request->has('user_timeline')?1:0;
            Setting::where('meta','active_captcha')->update(['value'=>$captcha]);
            Setting::where('meta','user_timeline')->update(['value'=>$timeline]);
            Setting::where('meta','online_delay')->update(['value'=>$this->request->get('online_delay')]);
            Setting::where('meta','min_age')->update(['value'=>$this->request->get('min_age')]);
            Setting::where('meta','min_upload')->update(['value'=>$this->request->get('min_upload')]);

            if($this->request->hasFile('logo')){
                $old_logo = setting('website_logo');
                $logo = $this->request->file('logo');
                if(in_array($logo->getClientOriginalExtension(),['jpg','png','gif','jpeg'])){
                  $image=Str::random(20).'.'.$logo->getClientOriginalExtension();
                  $destinationPath = $this->base_path.'uploads/sites/';
                  $upload = $logo->move($destinationPath,$image);
                  $image = 'uploads/sites/'.$image;
                    Setting::where('meta','website_logo')->update(['value'=>$image]);
                    if($old_logo && file_exists($this->base_path.'/'.$old_logo)){
                        unlink($this->base_path.'/'.$old_logo);
                    }
                }
            }
            if($this->request->hasFile('logo_second')){
                $old_logo = setting('logo_second');
                $logo = $this->request->file('logo_second');
                if(in_array($logo->getClientOriginalExtension(),['jpg','png','gif','jpeg'])){
                  $image=Str::random(20).'.'.$logo->getClientOriginalExtension();
                  $destinationPath = $this->base_path.'uploads/sites/';
                  $upload = $logo->move($destinationPath,$image);
                  $image = 'uploads/sites/'.$image;
                    Setting::where('meta','logo_second')->update(['value'=>$image]);
                    if($old_logo && file_exists($this->base_path.'/'.$old_logo)){
                        unlink($this->base_path.'/'.$old_logo);
                    }
                }
            }
            if($this->request->hasFile('register_background')){
                $old_logo = setting('register_background');
                $logo = $this->request->file('register_background');
                if(in_array($logo->getClientOriginalExtension(),['jpg','png','gif','jpeg'])){
                  $image=Str::random(20).'.'.$logo->getClientOriginalExtension();
                  $upload = $logo->move($destinationPath,$image);
                  $image = 'uploads/sites/'.$image;
                    Setting::where('meta','register_background')->update(['value'=>$image]);
                    if($old_logo && file_exists($this->base_path.'/'.$old_logo)){
                        unlink($this->base_path.'/'.$old_logo);
                    }
                }
            }
            if($this->request->hasFile('home_background')){
                $old_logo = setting('home_background');
                $logo = $this->request->file('home_background');
                // if($logo->acceptFile(['jpg','png','gif','jpeg'])){
                if(in_array($logo->getClientOriginalExtension(),['jpg','png','gif','jpeg'])){
                  $image=Str::random(20).'.'.$logo->getClientOriginalExtension();
                  $destinationPath = $this->base_path.'uploads/sites/';
                  $upload = $logo->move($destinationPath,$image);
                  $image = 'uploads/sites/'.$image;
                    Setting::where('meta','home_background')->update(['value'=>$image]);
                    if($old_logo && file_exists($this->base_path.'/'.$old_logo)){
                        unlink($this->base_path.'/'.$old_logo);
                    }
                }
            }
            if($this->request->hasFile('social_image')){
                $old_logo = setting('social_image');
                $logo = $this->request->file('social_image');
                if(in_array($logo->getClientOriginalExtension(),['jpg','png','gif','jpeg'])){
                  $image=Str::random(20).'.'.$logo->getClientOriginalExtension();
                  $destinationPath = $this->base_path.'uploads/sites/';
                  $upload = $logo->move($destinationPath,$image);
                  $image = 'uploads/sites/'.$image;
                    Setting::where('meta','social_image')->update(['value'=>$image]);
                    if($old_logo && file_exists($this->base_path.'/'.$old_logo)){
                        unlink($this->base_path.'/'.$old_logo);
                    }
                }
            }
            return redirect()->route('adminsetting')->with('success_update','Setting updated successfully');
        }
    }

    public function interests()
    {
        $interests = Interest::all();
        return view('admin.interests', compact('interests'));
    }
}
