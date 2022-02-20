<?php

namespace App\Product\Resources;
    
use Illuminate\Http\Resources\Json\JsonResource;
    
class ProductResource extends JsonResource
{
    
    /**
    * @inheritDoc
    */
    public function toArray($request): array
    {
        return [
            'id'         => $this->getId(),
            'name'       => $this->getName(),
            'userid'     => $this->getUserId(),
            'created_at' => $this->getCreatedAt(),
            'updated_at' => $this->getUpdatedAt(),
        ];
    }
}