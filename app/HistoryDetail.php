<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HistoryDetail extends Model
{
    //
    public function history()
    {
        return $this->belongsTo('App\History')->withDefault();
    }
}
