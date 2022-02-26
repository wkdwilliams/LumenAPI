<?php

namespace App\User\Services;

use Core\EntityCollection;
use Core\Service;

class UserService extends Service
{
    public function getResources(): EntityCollection
    {
        return $this->repository
                    ->findAll()
                    ->orderBy('id', 'desc')
                    ->limit(5)
                    ->entityCollection();
    }
}