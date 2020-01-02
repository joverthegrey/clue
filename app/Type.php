<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    //

    public function clues()
    {
        return $this->hasMany('App\Clue');
    }
}
