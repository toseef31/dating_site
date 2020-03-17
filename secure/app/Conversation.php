<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    protected $table = 'conversations';
    public $timestamps = false;

    public function messages()
    {
        return $this->hasMany(Message::class, 'conversation_id')->orderBy('created_at','DESC');
    }

    public function sender()
    {
        return $this->belongsTo(User::class,'sender_id');
    }

    public function receive()
    {
        return $this->belongsTo(User::class, 'receive_id');
    }

    public function unread()
    {
        return $this->hasMany(Message::class, 'conversation_id')->where('seen',0)->count();
    }
}
