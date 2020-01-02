<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Clue extends Model
{
    //

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function type() {
        return $this->belongsTo('App\Type');
    }
}
