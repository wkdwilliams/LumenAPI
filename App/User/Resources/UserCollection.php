<?php

namespace App\User\Resources;

use Core\ResourceCollection;

class UserCollection extends ResourceCollection
{

    public function toArray($request)
    {
        return $this->collection->transform(function($client){
            return new UserResource($client);
        });
    }

}