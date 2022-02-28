<?php

namespace App\Product\DataMappers;

use App\Category\DataMappers\CategoryDataMapper;
use App\Product\Entities\ProductEntity;
use Core\DataMapper;
use Core\Entity;
    
class ProductDataMapper extends DataMapper
{
    protected $entity = ProductEntity::class;
    
    protected function fromRepository(array $data): array
    {
        $category = (new CategoryDataMapper())
                    ->repoToEntity($data['category'][0]);

        return [
            'id'         => $data['id'],
            'name'       => $data['name'],
            'category'   => $category,
            'created_at' => $data['created_at'],
            'updated_at' => $data['updated_at'],
        ];
    }
    
    protected function toRepository(array $data): array
    {
        return [];
    }
    
    protected function fromEntity(Entity $data): array
    {
        return [];
    }
    
}
