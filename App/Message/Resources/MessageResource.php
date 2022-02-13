<?php

namespace App\Message\Resources;

use Core\Resource;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class MessageResource extends JsonResource
{

    /**
     * @inheritDoc
     */
    public function toArray($entity): array
    {
        return [
            'id'        => $this->getId(),
            'message'   => $this->getMessage()
        ];
    }
}