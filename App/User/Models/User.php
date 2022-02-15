<?php

namespace App\User\Models;

use App\Message\Models\Message;
use Core\Model;

class User extends Model
{
    protected $table = "users";

    protected $appends = [
        'messages'
    ];

    protected $casts = [
        'created_at' => 'date:Y-m-d',
        'updated_at' => 'datetime:Y-m-d H:00',
    ];

    public function messages()
    {
        return $this->hasMany(Message::class);
    }
    public function getMessagesAttribute()
    {
        return $this->messages()->get();
    }
}
