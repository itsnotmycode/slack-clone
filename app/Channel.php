<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Channel extends Model
{
    protected $fillable = ['name', 'admin', 'description', 'private', 'user_channel'];

    public function user()
    {
        return $this->belongsToMany(User::class);
    }

    public function message()
    {
        return $this->hasMany(Message::class);
    }
}
