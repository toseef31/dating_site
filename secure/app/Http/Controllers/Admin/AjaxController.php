<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Interest;
use Illuminate\Http\Request;

class AjaxController extends Controller
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function main(Request $request)
    {
      return $request->all();
        if($this->request->has('action')){
            $action = $this->request->get('action');
            // dd($action);
            if(method_exists($this,$action)){
                return $this->$action();
            }
        }
        return response()->json(['status'=>'error']);
    }

    public function update_interest()
    {
        if($this->request->has('id') && $this->request->has('text') && $this->request->has('icon')){
            $interest = Interest::where('id',$this->request->get('id'))->first();
            if($interest){
                $interest->text = $this->request->get('text');
                $interest->icon = $this->request->get('icon');
                $interest->save();
                return response()->json(['status'=>'success']);
            }
        }
        return response()->json(['status'=>'error']);
    }

    public function add_interest()
    {
        if($this->request->has('text') && $this->request->has('icon')){
            $interest = new Interest();
            $interest->text = $this->request->get('text');
            $interest->icon = $this->request->get('icon');
            $interest->save();
            return response()->json(['status'=>'success']);
        }
        return response()->json(['status'=>'error']);
    }

    public function delete_interest()
    {
        if($this->request->has('id')){
            $interest = Interest::where('id',$this->request->get('id'))->first();
            if($interest){
                $interest->users()->detach();
                $interest->delete();
            }
            return response()->json(['status'=>'success']);
        }
        return response()->json(['status'=>'error']);
    }
}
