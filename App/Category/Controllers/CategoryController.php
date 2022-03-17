<?php

namespace App\Category\Controllers;
    
use App\Category\DataMappers\CategoryDataMapper;
use App\Category\Models\Category;
use App\Category\Repositories\CategoryRepository;
use App\Category\Resources\CategoryCollection;
use App\Category\Resources\CategoryResource;
use App\Category\Services\CategoryService;
use Core\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class CategoryController extends Controller
{
    
    protected array $classes = [
        'datamapper' => CategoryDataMapper::class,
        'repository' => CategoryRepository::class,
        'resource'   => CategoryResource::class,
        'collection' => CategoryCollection::class,
        'service'    => CategoryService::class,
        'model'      => Category::class,
    ];

    public function getResourceByName(string $name): JsonResponse
    {
        $repos = $this->service->getResourceByName($name);

        return $this->response(
            new $this->classes['resource']($repos)
        );
    }
    
}
