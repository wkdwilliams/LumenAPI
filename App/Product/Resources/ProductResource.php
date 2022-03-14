<?php

namespace App\Product\Resources;

use App\Category\Resources\CategoryCollection;
use App\Category\Resources\CategoryResource;
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
            'user_id'    => $this->getUserId(),
            'name'       => $this->getName(),
            'category'   => new CategoryResource($this->getCategory()),
            'created_at' => $this->getCreatedAt(),
            'updated_at' => $this->getUpdatedAt(),
        ];
    }
}