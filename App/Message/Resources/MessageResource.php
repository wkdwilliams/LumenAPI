<?php

namespace App\Message\Resources;

use App\Image\Resources\ImageCollection;
use Illuminate\Http\Resources\Json\JsonResource;

class MessageResource extends JsonResource
{

    /**
     * @inheritDoc
     */
    public function toArray($entity): array
    {
        return [
            'id'        => $this->getId(),
            'message'   => $this->getMessage(),
            'images'    => new ImageCollection($this->getImages())
        ];
    }
}