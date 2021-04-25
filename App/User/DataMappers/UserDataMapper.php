<?php

namespace App\User\DataMappers;

use App\User\Entities\UserEntity;
use Core\DataMapper\DataMapper;

class UserDataMapper extends DataMapper
{
    protected $entity = UserEntity::class;

    protected function fromRepository(array $data): array
    {
        return [
            'id'    => $data['id'],
            'name'  => $data['name'],
            'email' => $data['email']
        ];
    }

    protected function fromApplication(array $data): array
    {
        return [];
    }

}
