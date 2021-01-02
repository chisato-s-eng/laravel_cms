<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    //
    protected $fillable = [
        'user_id', 'item_id', 'amount',
    ];

    public function item()
    {
        return $this->belongsTo('App\Item');
    } 
}
