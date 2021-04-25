<?php

namespace App\User\Resources;

use Core\Resource;

class UserResource extends Resource
{

    /**
     * @inheritDoc
     */
    public function toArray($entity): array
    {
        return [
            'id'    => $entity->getId(),
            'name'  => $entity->getName(),
            'email' => $entity->getEmail()
        ];
    }
}