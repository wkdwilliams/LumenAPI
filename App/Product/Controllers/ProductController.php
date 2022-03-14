<?php

namespace App\Product\Controllers;
    
use App\Product\DataMappers\ProductDataMapper;
use App\Product\Models\Product;
use App\Product\Repositories\ProductRepository;
use App\Product\Resources\ProductCollection;
use App\Product\Resources\ProductResource;
use App\Product\Services\ProductService;
use Core\Controllers\Controller;
use Core\Rules\Ownership;

class ProductController extends Controller
{
    
    protected array $classes = [
        'datamapper' => ProductDataMapper::class,
        'repository' => ProductRepository::class,
        'resource'   => ProductResource::class,
        'collection' => ProductCollection::class,
        'service'    => ProductService::class,
        'model'      => Product::class
    ];

    protected array $createRules = [
        'user_id'       => 'required',
        'category_id'   => 'required',
        'name'          => 'required',
    ];
    
}
