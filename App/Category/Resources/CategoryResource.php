<?php

namespace App\Category\Resources;
    
use Illuminate\Http\Resources\Json\JsonResource;
    
class CategoryResource extends JsonResource
{
    
    /**
    * @inheritDoc
    */
    public function toArray($request): array
    {
        return [
            'id'         => $this->getId(),
            'name'       => $this->getName(),
            'created_at' => $this->getCreatedAt(),
            'updated_at' => $this->getUpdatedAt()
        ];
    }
}