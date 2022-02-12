<?php

namespace App\Message\Resources;

use Core\Resource;

class MessageResource extends Resource
{

    /**
     * @inheritDoc
     */
    public function toArray($entity): array
    {
        return [
            'id'        => $entity->getId(),
            'message'   => $entity->getMessage(),
        ];
    }
}