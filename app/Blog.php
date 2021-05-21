<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    const OPEN = 1;
    const CLOSED = 0;

    protected $guard = [];
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

    //statusがclosedの時
    public function isClosed ()
    {
        return $this->status == self::CLOSED;
    }

    public function validData($overrides = [])
    {
        $validData = [
            'title' => 'ブログのタイトル',
            'body' => 'ブログの本文',
            'status' => '1',
        ];

        return array_merge($validData, $overrides);
    }
}
