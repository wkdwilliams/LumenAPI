<?php

namespace App\User\Controllers;

use App\User\DataMappers\UserDataMapper;
use App\User\Models\User;
use App\User\Repositories\UserRepository;
use App\User\Resources\UserCollection;
use App\User\Resources\UserResource;
use App\User\Services\UserService;
use Core\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{

    protected array $classes = [
        'datamapper' => UserDataMapper::class,
        'repository' => UserRepository::class,
        'resource'   => UserResource::class,
        'collection' => UserCollection::class,
        'service'    => UserService::class,
        'model'      => User::class,
    ];

    public function updateResource(): JsonResponse
    {
        // Check we're not trying to update the api_token
        if (isset($this->request->api_token))
            $this->request->request->remove('api_token');

        return parent::updateResource();
    }

}
