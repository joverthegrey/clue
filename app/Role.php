<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    public function clues() {
        return $this->hasMany('App\Clue');
    }
}
