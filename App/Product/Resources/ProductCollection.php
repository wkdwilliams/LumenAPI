<?php

namespace App\Product\Resources;
    
use Core\ResourceCollection;
    
class ProductCollection extends ResourceCollection
{
    
    public function toArray($request)
    {
        return $this->collection->transform(function($client){
            return new ProductResource($client);
        });
    }
    
}