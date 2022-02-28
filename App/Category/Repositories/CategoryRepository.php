<?php

namespace App\Category\Repositories;

use App\Category\DataMappers\CategoryDataMapper;
use App\Category\Models\Category;
use Core\Repository;
    
class CategoryRepository extends Repository
{
    protected $datamapper   = CategoryDataMapper::class;
    protected $model        = Category::class;
}