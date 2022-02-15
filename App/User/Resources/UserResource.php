<?php

namespace App\User\Resources;

use App\Message\Resources\MessageCollection;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{

    /**
     * @inheritDoc
     */
    public function toArray($request): array
    {
        return [
            'id'         => $this->getId(),
            'name'       => $this->getName(),
            'email'      => $this->getEmail(),
            'messages'   => new MessageCollection($this->getMessages()),
            'created_at' => $this->getCreatedAt(),
            'updated_at' => $this->getUpdatedAt()
        ];
    }
}