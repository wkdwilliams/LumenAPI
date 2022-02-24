<?php

namespace App\Image\DataMappers;

use App\Image\Entities\ImageEntity;
use Core\DataMapper;
use Core\Entity;

class ImageDataMapper extends DataMapper
{
    protected $entity = ImageEntity::class;

    protected function fromRepository(array $data): array
    {
        return [
            'id'         => $data['id'],
            'url'        => $data['url'],
            'created_at' => $data['created_at'],
            'updated_at' => $data['updated_at']
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
