<?php

namespace Core\Events;

use App\User\Entities\UserEntity;

class UserCreated extends Event
{
    public UserEntity $entity;

    function __construct(UserEntity $entity)
    {
        $this->entity = $entity;
    }
}