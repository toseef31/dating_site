<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function photos()
    {
        return $this->hasMany(Photo::class);
    }

    public function interests()
    {
        return $this->belongsToMany(Interest::class,'interest_user');
    }

    public function follows()
    {
        return $this->belongsToMany(User::class, 'user_follow','user_id','follow_id');
    }

    public function likes()
    {
        return $this->belongsToMany(User::class,'user_like','user_id','receive_id')->withPivot('type');
    }

    public function unread()
    {
        $user_id = $this->id;
        return Message::where('seen',0)->where('user_id','!=', $user_id)->leftJoin('conversations', 'messages.conversation_id','=','conversations.id')->where(function(Builder $query) use ($user_id){
            $query->where('sender_id', $user_id)->orWhere('receive_id', $user_id);
        })->get();
    }
}
