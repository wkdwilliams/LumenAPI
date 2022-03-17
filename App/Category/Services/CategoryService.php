<?php

namespace App\Category\Services;

use Core\Entity;
use Core\Service;
    
class CategoryService extends Service
{

    public function getResourceByName(string $name): Entity
    {
        return $this->repository->findByColumn('name', $name)->entity();
    }
        
}