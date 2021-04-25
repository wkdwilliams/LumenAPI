<?php

namespace Core\Http\Controllers;

use App\User\Repositories\UserRepository;
use Core\Entity;
use Core\Repository;
use Core\Resource;
use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    /**
     * @var array
     */
    protected array $classes;

    /**
     * @var Repository
     */
    protected Repository $repository;

    /**
     * @var Resource
     */
    protected Resource $resource;

    public function __construct()
    {
        $this->repository = new $this->classes['repository'](
            new $this->classes['datamapper'](), new $this->classes['model']()
        );
        $this->resource = new $this->classes['resource']();
    }

    public function get(int $id){
        $res = $this->repository->findById($id);

        return $this->resource->output($res);
    }

}
