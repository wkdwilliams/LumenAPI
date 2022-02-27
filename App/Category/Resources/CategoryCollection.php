<?php

namespace App\Category\Resources;
    
use Core\ResourceCollection;
    
class CategoryCollection extends ResourceCollection
{
    
    public function toArray($request)
    {
        return $this->collection->transform(function($client){
            return new CategoryResource($client);
        });
    }
    
}