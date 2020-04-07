<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Conversation;
use App\Message;
use App\Photo;
use App\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AjaxController extends Controller
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }
    public function main(Request $request)
    {
      // dd($this->request->get('action'));
        if($this->request->has('action')){
            $action = $this->request->get('action');
            if(method_exists($this,$action)){
                return $this->$action();
            }
        }
        return response()->json(['status'=>'error']);
    }

    public function check_username()
    {
        if($this->request->has('username')){
            $check = User::where('username', $this->request->get('username'))->first();
            if($check){
                return response()->json(['status'=>'error']);
            }
            else return response()->json(['status'=>'success']);
        }
        return response()->json(['status'=>'error']);
    }

    public function check_email()
    {
        if($this->request->has('email')){
            $check = User::where('email', $this->request->get('email'))->first();
            if($check){
                return response()->json(['status'=>'error']);
            }
            else return response()->json(['status'=>'success']);
        }
        return response()->json(['status'=>'error']);
    }

    public function search_more()
    {
        if(Auth::check()){
            $user = Auth::user();
            $default_gender = $user->gender;
            $default_preference = $user->preference == 3?[1,2]:$user->preference;
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
        // if($this->request->has('seeking') && ($seeking == 'male' || $seeking == 'female' || $seeking == 'male,female')){
        // $default_preference = $seeking == 'male'?[1]:($seeking == 'female'?[2]:[1,2]);
        // }
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
        return view('ajax_filter', compact('users'));
    }

    public function view_photo()
    {
        if($this->request->has('id')){
          $get_user = Photo::with('comments','likes','user')->where('id',$this->request->id)->first();
          $user_id = $get_user->user_id;
          $id = $get_user->id;
            $photos = Photo::with('comments','likes','user')->where('user_id',$user_id)->get();
            $type='';
            if($photos) {
                // $html = view('photo.view',compact('photo','type'))->render();
                $html = view('photo.view2',compact('photos','type','id'))->render();
                // return response()->json(['status' => 'success', 'height' => $photo->height, 'width'=>$photo->width ,'html'=>$html]);
                return response()->json(['status' => 'success', 'height' => $photos[0]->height, 'width'=>$photos[0]->width ,'html'=>$html]);
            }
        }
        return response()->json(['status'=>'error']);
    }
    // public function view_photo()
    // {
    //     if($this->request->has('id')){
    //       $photo = Photo::with('comments','likes','user')->where('id',$this->request->id)->first();
    //       $user_id = $photo->user_id;
    //       $id = $photo->id;
    //         // dd($photo);
    //         $type='';
    //         if($photo) {
    //           $html = view('photo.view3',compact('photo','type'))->render();
    //             return response()->json(['status' => 'success', 'height' => $photo->height, 'width'=>$photo->width ,'html'=>$html]);
    //         }
    //     }
    //     return response()->json(['status'=>'error']);
    // }

    public function view_cover_photo()
    {
        if($this->request->has('id')){
            $photo = User::where('id',$this->request->id)->first();
            $type = "cover";
            if($photo) {
                $html = view('photo.view',compact('photo','type'))->render();
                return response()->json(['status' => 'success', 'height' => $photo->height, 'width'=>$photo->width ,'html'=>$html]);
            }
        }
        return response()->json(['status'=>'error']);
    }

    public function like_photo()
    {
        if($this->request->has('id') && \auth()->check()){
            $photo = Photo::with('likes')->where('id',$this->request->id)->first();
            if($photo) {
                if(in_array(auth()->id(), collect($photo->likes()->get())->pluck('id')->all())){
                    $photo->likes()->detach(auth()->id());
                    return response()->json(['status'=>'success', 'type' => 'dislike']);
                }
                else{
                    $photo->likes()->attach(auth()->id());
                    return response()->json(['status'=>'success', 'type' => 'like']);
                }
            }
        }
        return response()->json(['status'=>'login']);
    }

    public function follow()
    {
        if($this->request->has('id') && \auth()->check()){
            $user = \auth()->user();
            if($this->request->id == \auth()->id()){
                return response()->json(['status'=>'success', 'type' => 'self']);
            }
            elseif(in_array($this->request->id, collect($user->follows()->get())->pluck('id')->all())){
                $user->follows()->detach($this->request->id);
                return response()->json(['status'=>'success', 'type' => 'unfollow']);
            }
            else{
                $user->follows()->attach($this->request->id);
                return response()->json(['status'=>'success', 'type' => 'follow']);
            }
        }
        return response()->json(['status'=>'login']);
    }

    public function comment_photo()
    {
        if($this->request->has('id') && $this->request->has('text') && \auth()->check()){
            $comment = new Comment();
            $comment->user_id = \auth()->id();
            $comment->comment = $this->request->text;
            $comment->object_id = $this->request->id;
            $comment->object_type = 'photo';
            $comment->save();
            $html = view('photo.comment', compact('comment'))->render();
            return response()->json(['status'=>'success', 'html' => $html]);
        }
        return response()->json(['status'=>'login']);
    }

    public function love()
    {
        if($this->request->has('id') && $this->request->has('type') && \auth()->check()){
            $user = \auth()->user();
            if($user->likes()->where('id', $this->request->id)->first()){
                $old_type = $user->likes()->where('id', $this->request->id)->first()->pivot->type;
                $user->likes()->detach($this->request->id);
                if($old_type != $this->request->type){
                    $user->likes()->attach($this->request->id, ['type' => $this->request->type]);
                }
                return response()->json(['status'=>'success', 'type'=>'old']);
            }
            else{
                $user->likes()->sync($this->request->id, ['type' => $this->request->type]);
                return response()->json(['status'=>'success', 'type'=>'new']);
            }
        }
        return response()->json(['status'=>'login']);
    }

    public function load_photo()
    {
        if($this->request->id && $this->request->page){
            $user = User::with('photos')->where('id', $this->request->id)->first();
            if($user){
                $photos = $user->photos()->orderBy('created_at','DESC')->paginate(16);
                if($photos->count()){
                    $html = view('photo.load', compact('photos'))->render();
                    return response()->json(['status'=>'success', 'html'=>$html]);
                }
            }
        }
        return response()->json(['status'=>'error']);
    }

    public function send_message()
    {
        if($this->request->id && $this->request->text){
            if(\auth()->check()){
                $conversation = Conversation::where('id', $this->request->id)->first();
                if($conversation){
                    if(\auth()->id() == $conversation->sender_id && $conversation->waiting == 1 && !empty($conversation->last_message)){
                        return response()->json(['status'=>'wait']);
                    }
                    else {
                        $receive_id = $conversation->receive_id;
                        $sender_id = $conversation->sender_id;
                        if (\auth()->id() === $conversation->receive_id) {
                            $sender_id = $conversation->receive_id;
                            $receive_id = $conversation->sender_id;
                        }
                        // Send email or sms to receive user
                        // end send email
                        $message = new Message();
                        $message->message = $this->request->text;
                        $message->user_id = \auth()->id();
                        $message->conversation_id = $conversation->id;
                        $message->seen = 0;
                        $message->save();
                        if (\auth()->id() != $conversation->sender_id) {
                            $conversation->waiting = 0;
                        }
                        $conversation->last_message = $this->request->text;
                        $conversation->updated_at = date('Y-m-d H:i:s');
                        $conversation->save();
                        $conv = $conversation;
                        $html = view('messages.message', compact('message'))->render();
                        $html_receive = true;
                        $receive_html = view('messages.message', compact('message', 'html_receive'))->render();
                        $notice_html = view('messages.notice',compact('message'))->render();
                        $conversation_html = view('messages.item', compact('conv','html_receive'))->render();
                        return response()->json([
                            'status' => 'success',
                            'html' => $html,
                            'id' => $message->id,
                            'receive_html' => $receive_html,
                            'conversation_html' => $conversation_html,
                            'notice_html' => $notice_html,
                            'message' => $message->message
                        ]);
                    }
                }
            }
            else{
                return response()->json(['status'=>'login']);
            }
        }
        return response()->json(['status'=>'error']);
    }

    public function load_messages()
    {
        if($this->request->id && $this->request->page && \auth()->check()){
            $conversation = Conversation::with('messages', 'sender','receive')->where('id', $this->request->id)->where(function (Builder $query){
                $query->where('sender_id', \auth()->id())->orWhere('receive_id', \auth()->id());
            })->first();
            if($conversation){
                $messages = $conversation->messages()->paginate(20);
                if($messages->count()){
                    $html = '';
                    foreach($messages->reverse() as $message){
                        $html .= view('messages.message', compact('message'))->render();
                    }
                    return response()->json(['status'=>'success', 'html' => $html]);
                }
                else{
                    return response()->json(['status'=>'empty']);
                }
            }
        }
        return response()->json(['status'=>'error']);
    }

    public function check_messages()
    {
        if(\auth()->check()){
            $conversations = Conversation::with('messages')->where(function(Builder $query){
                $query->where('sender_id', \auth()->id())->orWhere('receive_id', \auth()->id());
            })->whereHas('messages', function (Builder $query){
                $query->where('seen', 0)->where('user_id','!=', \auth()->id());
            })->orderBy('updated_at',"DESC")->get();
            if($conversations->count()){
                $result = [];
                foreach($conversations as $key=>$conv){
                    $result[$key]['id'] = $conv->id;
                    $result[$key]['messages'] = [];
                    $result[$key]['html'] = view('messages.item', compact('conv'))->render();
                    $result[$key]['last_message'] = $conv->last_message;
                    $messages = $conv->messages()->where('seen', 0)->where('user_id','!=', \auth()->id())->get();
                    foreach($messages->reverse() as $keym => $message){
                        if($this->request->id && $this->request->id == $message->conversation_id){
                            $message->seen();
                        }
                        $result[$key]['messages'][$keym]['id'] = $message->id;
                        $result[$key]['messages'][$keym]['html'] = view('messages.message', compact('message'))->render();
                    }
                }
                return response()->json(['status'=>'success', 'result' => $result]);
            }
            else{
                return response()->json(['status'=>'empty']);
            }
        }
        return response()->json(['status'=>'error']);
    }

    public function load_conversation()
    {
        if($this->request->id && \auth()->check()){
            $conversation = Conversation::with('messages', 'sender','receive')->where('id', $this->request->id)->where(function (Builder $query){
                $query->where('sender_id', \auth()->id())->orWhere('receive_id', \auth()->id());
            })->first();
            if($conversation){
                Message::where('conversation_id',$conversation->id)->where('user_id','!=',\auth()->id())->update(['seen'=>1]);
                $html = view('messages.conversation', compact('conversation'))->render();
                return response()->json(['status'=>'success', 'html' => $html, 'unread' => \auth()->user()->unread()->count(), 'url' => route('message',['id' => $conversation->id])]);
            }
        }
        return response()->json(['status'=>'error']);
    }

    public function seen()
    {
        if($this->request->id && \auth()->check()){
            Message::where('id', $this->request->id)->update(['seen'=>1]);
            return response()->json(['status'=>'success']);
        }
        return response()->json(['status'=>'error']);
    }

    public function delete_conversation()
    {
        if($this->request->id && \auth()->check()) {
            $conversation = Conversation::where('id', $this->request->id)->where(function (Builder $builder) {
                $builder->where('sender_id', auth()->id())->orWhere('receive_id', auth()->id());
            })->first();

            if ($conversation) {
                Message::where('conversation_id', $this->request->id)->delete();
                $conversation->delete();
            }
            return response()->json(['status'=>'success']);
        }
        return response()->json(['status'=>'error']);
    }
}
