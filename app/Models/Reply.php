<?php

namespace App\Models;

class Reply extends Model
{
    protected $fillable = ['content'];

    public function topic()
    {
        return $this->belongsTo('App\Models\Topic');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
