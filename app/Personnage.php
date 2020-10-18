<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Personnage extends Model
{
    public function typePersonnage() {
        return $this->belongsTo('App\TypePersonnage');
    }
}
