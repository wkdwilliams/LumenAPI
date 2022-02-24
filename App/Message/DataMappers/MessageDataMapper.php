<?php

namespace App\Message\DataMappers;

use App\Image\DataMappers\ImageDataMapper;
use App\Message\Entities\MessageEntity;
use Core\DataMapper;
use Core\Entity;

class MessageDataMapper extends DataMapper
{
    protected $entity = MessageEntity::class;

    protected function fromRepository(array $data): array
    {
        $images = (new ImageDataMapper())
                        ->repoToEntityCollection($data['images']);

        return [
            'id'         => $data['id'],
            'message'    => $data['message'],
            'images'     => $images,
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
