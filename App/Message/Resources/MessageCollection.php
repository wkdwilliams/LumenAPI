<?php

namespace App\Message\Resources;

use Core\ResourceCollection;

class MessageCollection extends ResourceCollection
{

    public function toArray($request)
    {
        return $this->collection->transform(function($client){
            return new MessageResource($client);
        });
    }

}