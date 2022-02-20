<?php

namespace App\User\Repositories;

use Core\Repository;

class UserRepository extends Repository
{
    public function findByApiToken(string $token): UserRepository
    {
        return $this->findByColumn('api_token', $token);
    }
}
