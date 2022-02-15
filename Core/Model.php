<?php

namespace Core;

use Illuminate\Database\Eloquent\Model as laravelModel;

abstract class Model extends laravelModel
{

    protected $casts = [
        'created_at' => 'date:Y-m-d',
        'updated_at' => 'datetime:Y-m-d H:00',
    ];

}
