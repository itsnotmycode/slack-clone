<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Channel extends Model
{
    public function user()
    {
        return $this->belongsToMany(User::class);
    }

    public function message()
    {
        return $this->hasMany(Message::class);
    }
}
