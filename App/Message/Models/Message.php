<?php

namespace App\Message\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $table = "messages";

    public function user()
    {
        return $this->belongsTo('user', 'id');
    }
}
