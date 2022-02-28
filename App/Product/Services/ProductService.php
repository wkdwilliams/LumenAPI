<?php

namespace App\Product\Services;

use Core\EntityCollection;
use Core\Service;
    
class ProductService extends Service
{
    public function getResources(): EntityCollection
    {
        return $this->repository->findAll()->entityCollection();
    }
}