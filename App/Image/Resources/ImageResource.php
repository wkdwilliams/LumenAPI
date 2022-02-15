<?php

namespace App\Image\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ImageResource extends JsonResource
{

    /**
     * @inheritDoc
     */
    public function toArray($entity): array
    {
        return [
            'id'        => $this->getId(),
            'url'       => $this->getUrl()
        ];
    }
}