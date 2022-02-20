<?php

namespace App\Product\Controllers;
    
use App\Product\DataMappers\ProductDataMapper;
use App\Product\Models\Product;
use App\Product\Repositories\ProductRepository;
use App\Product\Resources\ProductCollection;
use App\Product\Resources\ProductResource;
use App\Product\Services\ProductService;
use App\User\DataMappers\UserDataMapper;
use App\User\Models\User;
use App\User\Repositories\UserRepository;
use Core\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class ProductController extends Controller
{
    
    protected array $classes = [
        'datamapper' => ProductDataMapper::class,
        'repository' => ProductRepository::class,
        'resource'   => ProductResource::class,
        'collection' => ProductCollection::class,
        'service'    => ProductService::class,
        'model'      => Product::class,
    ];

    public function getResources(): JsonResponse
    {
        $userEntity = (new UserRepository(new UserDataMapper(), new User()))
                        ->findByApiToken($this->request->api_token)
                        ->entity();

        $repos = $this->service->getProductsByUserId($userEntity->getId());

        return $this->response(
            new $this->classes['collection']($repos)
        );
    }
    
}
