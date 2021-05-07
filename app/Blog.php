<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    const OPEN = 1;
    const CLOSED = 0;
    public function user ()
    {
        return $this->belongsTo(User::class);
    }

    public function comments ()
    {
        return $this->hasMany(Comment::class);
    }

    public function scopeOnlyOpen ($query)
    {
        return $query->where('status', self::OPEN);
    }
}
