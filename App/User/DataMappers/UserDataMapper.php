<?php

namespace App\User\DataMappers;

use App\Message\DataMappers\MessageDataMapper;
use App\Message\Models\Message;
use App\Message\Repositories\MessageRepository;
use App\User\Entities\UserEntity;
use Core\DataMapper;

class UserDataMapper extends DataMapper
{
    protected $entity = UserEntity::class;

    protected function fromRepository(array $data): array
    {
        $messages = (new MessageRepository(new MessageDataMapper(), new Message()))
            ->findByForeignId('user_id', $data['id']);

        print_r([
            'id'         => $data['id'],
            'name'       => $data['name'],
            'email'      => $data['email'],
            'messages'   => $messages->getEntities(),
            'created_at' => $data['created_at'],
            'updated_at' => $data['updated_at']
        ]);
        exit();

        return [
            'id'         => $data['id'],
            'name'       => $data['name'],
            'email'      => $data['email'],
            'messages'   => $messages->getEntities(),
            'created_at' => $data['created_at'],
            'updated_at' => $data['updated_at']
        ];
    }

    protected function fromApplication(array $data): array
    {
        return [];
    }

}
