<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use app\User;
use app\Message;
use DB;
use Carbon;


class HomeController extends Controller
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function main()
    {
      // dd("Asdf");
      // $all_user = DB::table('users')->where('is_admin',0)->get()->count();
      $all_user=User::where('is_admin',0)->get()->count();
      $today_user=User::where('is_admin',0)->where('created_at',Carbon\Carbon::now())->get()->count();
      $online_user=User::where('is_admin',0)->where('active',1)->get()->count();
      $message=DB::table('messages')->get()->count();
      // dd($message);
        return view('admin.home',compact('all_user','today_user','online_user','message'));
    }

    public function pages()
    {
        $pages = Page::all();
        return view('admin.pages',compact('pages'));
    }

    public function addPage($id = false)
    {
        $page = false;
        if($id){
            $page = Page::where('id', $id)->first();
        }
        return view('admin.addpage',compact('page'));
    }

    public function submitPage($id = false)
    {
        $page = false;
        if($id){
            $page = Page::where('id', $id)->first();
        }

        if(!$page){
            $page = new Page();
        }

        $rules = array(
            'title' => 'required',
            'content' => 'required'
        );

        $validator = Validator::make($this->request->all(), $rules);
        if($validator->fails()){
            return redirect()->back()->withErrors((array)$validator->errors());
        }
        else{
            $page->title = $this->request->get('title');
            $page->slug = Str::slug($page->title);
            $page->content = $this->request->get('content');
            $page->save();
            return redirect()->route('adminpages');
        }
    }

    public function deletePage($id)
    {
        $page = false;
        if($id){
            $page = Page::where('id', $id)->first();
            if($page){
                $page->delete();
            }
        }
        return redirect()->back();
    }
}
