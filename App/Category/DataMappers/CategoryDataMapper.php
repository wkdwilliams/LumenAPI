<?php

namespace App\Category\DataMappers;
    
use App\Category\Entities\CategoryEntity;
use Core\DataMapper;
use Core\Entity;
    
class CategoryDataMapper extends DataMapper
{
    protected $entity = CategoryEntity::class;
    
    protected function fromRepository(array $data): array
    {
        return [
            'id'         => $data['id'],
            'name'       => $data['name'],
            'created_at' => $data['created_at'],
            'updated_at' => $data['updated_at'],
        ];
    }
    
    protected function toRepository(array $data): array
    {
        return [
            'name' => $data['name']
        ];
    }
    
    protected function fromEntity(Entity $data): array
    {
        return [
            'id'         => $data->getId(),
            'name'       => $data->getName(),
            'updated_at' => $data->getUpdatedAt(),
            'created_at' => $data->getCreatedAt()
        ];
    }
    
}
    
