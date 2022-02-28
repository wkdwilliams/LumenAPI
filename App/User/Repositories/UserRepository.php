<?php

namespace App\User\Repositories;

use App\User\DataMappers\UserDataMapper;
use App\User\Models\User;
use Core\Repository;

class UserRepository extends Repository
{
    protected $datamapper   = UserDataMapper::class;
    protected $model        = User::class;

    public function findByApiToken(string $token): UserRepository
    {
        return $this->findByColumn('api_token', $token);
    }
}
