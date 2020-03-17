<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function seen()
    {
        if(auth()->id() != $this->user_id) {
            $this->seen = 1;
            $this->save();
        }
    }
}
