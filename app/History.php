<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    //
    public function detail()
    {
        return $this->hasMany('App\HistoryDetail');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
