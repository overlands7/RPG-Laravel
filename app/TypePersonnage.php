<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TypePersonnage extends Model
{
    public $timestamps = false;
    public static $GOBELIN = 3;
    public static $SORCIERE = 3;
    public static $ORC = 3;
}
