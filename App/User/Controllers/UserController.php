<?php

namespace App\User\Controllers;

use App\User\DataMappers\UserDataMapper;
use App\User\Entities\UserEntity;
use App\User\Models\User;
use App\User\Repositories\UserRepository;
use App\User\Resources\UserResource;
use Core\Http\Controllers\Controller;

class UserController extends Controller
{

    protected array $classes = [
        'datamapper' => UserDataMapper::class,
        'repository' => UserRepository::class,
        'resource'   => UserResource::class,
        'entity'     => UserEntity::class,
        'model'      => User::class
    ];

}
