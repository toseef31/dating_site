<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class HomeController extends Controller
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function main()
    {
        return view('admin.home');
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
