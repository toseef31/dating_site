<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    public function comments()
    {
        return $this->hasMany(Comment::class, 'object_id')->where('object_type','photo');
    }

    public function likes()
    {
        return $this->belongsToMany(User::class, 'photo_user');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
