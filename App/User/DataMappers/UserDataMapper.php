<?php

namespace App\User\DataMappers;

use App\Message\DataMappers\MessageDataMapper;
use App\User\Entities\UserEntity;
use Core\DataMapper;
use Core\Entity;

class UserDataMapper extends DataMapper
{
    protected $entity = UserEntity::class;

    protected function fromRepository(array $data): array
    {
        $messages = (new MessageDataMapper())
                        ->getEntityCollection($data['messages']);

        return [
            'id'         => $data['id'],
            'name'       => $data['name'],
            'email'      => $data['email'],
            'messages'   => $messages,
            'created_at' => $data['created_at'],
            'updated_at' => $data['updated_at'],
        ];
    }

    protected function toRepository(array $data): array
    {
        return [
            'name'  => $data['name'] ?? '',
            'email' => $data['email'] ?? ''
        ];
    }

    public function fromApplication(Entity $entity): array
    {
        return [
            'name'  => $entity->getName(),
            'email' => $entity->getEmail()
        ];
    }

}
