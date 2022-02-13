<?php

namespace App\Message\DataMappers;

use App\Message\Entities\MessageEntity;
use Core\DataMapper;
use Core\Entity;

class MessageDataMapper extends DataMapper
{
    protected $entity = MessageEntity::class;

    protected function fromRepository(array $data): array
    {
        return [
            'id'         => $data['id'],
            'message'    => $data['message'],
            'created_at' => $data['created_at'],
            'updated_at' => $data['updated_at']
        ];
    }

    protected function toRepository(array $data): array
    {
        return [];
    }

    public function fromApplication(Entity $data): array
    {
        return [];
    }

}
