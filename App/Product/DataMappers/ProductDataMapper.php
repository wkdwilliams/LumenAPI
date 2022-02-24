<?php

namespace App\Product\DataMappers;
    
use App\Product\Entities\ProductEntity;
use Core\DataMapper;
use Core\Entity;
    
class ProductDataMapper extends DataMapper
{
    protected $entity = ProductEntity::class;
    
    protected function fromRepository(array $data): array
    {
        return [
            'id'         => $data['id'],
            'userid'     => $data['userid'],
            'name'       => $data['name'],
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
