<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Board extends Model
{
    public $primaryKey = 'name';
    public $incrementing = false;
}
