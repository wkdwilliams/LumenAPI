<?php

namespace App\Product\Services;

use Core\EntityCollection;
use Core\Service;
    
class ProductService extends Service
{
    /**
    * @return EntityCollection
    */
    public function getProductsByUserId(string $id): EntityCollection
    {
        return $this->repository->findByForeignId('userid', $id)->entityCollection();
    }
}