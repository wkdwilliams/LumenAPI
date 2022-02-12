<?php

namespace App\User\Models;

use App\Message\Models\Message;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = "users";

    public function messages()
    {
        return $this->hasMany(Message::class);
    }
}
