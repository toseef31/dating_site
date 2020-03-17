<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VideoCall extends Model
{
    protected $table = 'videocalles';
    public $timestamps = false;

    public function receive()
    {
        return $this->belongsTo(User::class, 'receive_id');
    }

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }
}
