<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Page;
class WelcomeController extends Controller
{

    /**
     * Dynamic page render
     * @return Page
     */
    public function dynamicPage($slug)
    {
        $data = Page::where('slug',$slug)->first();
        $pages = Page::get();
        return view('custome',compact('data','pages'));
    }
}