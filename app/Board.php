<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Subscription;

class Board extends Model
{
    public $primaryKey = 'name';
    public $incrementing = false;

    public function userIsSubbed($id) {
        return ( count(Subscription::where('user_id', '=', $id)->where('board', '=', $this->name)->get()) > 0);
    }
}
