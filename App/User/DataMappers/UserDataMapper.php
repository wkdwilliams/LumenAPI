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
                        ->repoToEntityCollection($data['messages']);

        return [
            'id'         => $data['id'],
            'name'       => $data['name'],
            'email'      => $data['email'],
            'password'   => $data['password'],
            'messages'   => $messages,
            'api_token'  => $data['api_token'],
            'created_at' => $data['created_at'],
            'updated_at' => $data['updated_at'],
        ];
    }

    protected function toRepository(array $data): array
    {
        return [
            'name'      => $data['name'],
            'email'     => $data['email'],
            'password'  => $data['password'],
            'api_token' => $data['api_token'] ?? \Illuminate\Support\Str::uuid()
        ];
    }

    public function fromEntity(Entity $entity): array
    {
        return [
            'id'            => $entity->getId(),
            'name'          => $entity->getName(),
            'email'         => $entity->getEmail(),
            'password'      => $entity->getPassword(),
            'api_token'     => $entity->getApiToken(),
            'created_at'    => $entity->getCreatedAt(),
            'updated_at'    => $entity->getUpdatedAt()
        ];
    }

}
