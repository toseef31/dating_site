<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Interest extends Model
{
    protected $table = 'interests';
    public $timestamps = false;

    public function users()
    {
        return $this->belongsToMany(User::class, 'interest_user');
    }
}
