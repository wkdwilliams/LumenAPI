
# LumenAPI
An API that heavily relies on object-oriented design. This API implements convenient data mapping of data obtained from repositories, to entities that represents the data, then lastly to a JSON resource.

Simple CRUD implementation eases the process of implementing your own API.

# Documentation
## Make a new resource
To conveniently create a new resource within the App directory, run this command:

    php artisan make:resource category
Then add the CRUD routes pointing to the newly created controller like so;

```php
$router->get('/category/{id}',  '\App\Category\Controllers\CategoryController@getResource');
$router->get('/category',       '\App\Category\Controllers\CategoryController@getResources');
$router->post('/category',      '\App\Category\Controllers\CategoryController@createResource');
$router->put('/category',       '\App\Category\Controllers\CategoryController@updateResource');
$router->delete('/category',    '\App\Category\Controllers\CategoryController@deleteResource');
```

Take note of the product datamapper, entity, collection and resource for a demonstration on how to set it up further.
## Gaurded update fields
To prevent certain fields from being updated when using the update method, you may override the default behaviour with this:

```php
protected array $guardedUpdateFields  = [
	'api_token'
];
```

This will prevent users from sending POST property `api_token` in an attempt to update a field they shouldn't.

## Gaurded create fields
To prevent certain fields from being updated when using the update method, you may override the default behaviour with this:

```php
protected array $guardedCreateFields  = [
	'api_token'
];
```

This will prevent users from sending POST property `api_token` in an attempt to set the field when creating it.

## Pagination
By default, pagination is disabled. When extending `Core\Controller.php`, you may override this inside your controller class with:

```php
protected int $paginate = 5;
```

This will return 5 results per page. Navigating to the endpoint `http://localhost/api/user?page=2` should access our records on page 2.

## Repository
The repository is what is used to obtain records from the model. The repository works similarly to the eloquent model.

### Obtaining data

```php
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
```
The above code will find all records from `users`, sort it by id in descending order, and limit the result by 5. If you expecting multiple results, you must return `entityCollection()`. If you're expecting only one result; then you can return `entity()`

```php
<?php

namespace App\User\Services;

use Core\EntityCollection;
use Core\Service;

class UserService extends Service
{
    public function getResourceById(): Entity
    {
        return $this->repository
                    ->findById(1)
                    ->entity()
    }
}
```

The above code will retrieve a record with the id of 1 and return an entity.

The repository does not inherit all the query building methods, and you may want to build a specific query without creating new methods in the repository. To get around this, you can access the query builder directly within a callback like so;
```php
<?php

namespace App\User\Services;

use Core\EntityCollection;
use Core\Service;

class UserService extends Service
{
    public function getResources(): EntityCollection
    {
        return $this->repository->findAll()->queryBuilder(function($model){
            return $model->groupBy('status');
        })->entityCollection();
    }
}
```

The above code will find all records, and group it by the `status` column.

### Caching
The repository will cache results if `APP_DEBUG` is set to false in the `.env` file

## Datamapper

To complete...