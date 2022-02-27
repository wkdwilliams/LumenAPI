<?php

namespace App\Category\Controllers;
    
use App\Category\DataMappers\CategoryDataMapper;
use App\Category\Models\Category;
use App\Category\Repositories\CategoryRepository;
use App\Category\Resources\CategoryCollection;
use App\Category\Resources\CategoryResource;
use App\Category\Services\CategoryService;
use Core\Http\Controllers\Controller;
    
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

    protected int $paginate = 0;
    
}
