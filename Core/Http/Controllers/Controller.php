<?php

namespace Core\Http\Controllers;

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

    /**
     * Controller constructor.
     */
    public function __construct()
    {
        $this->repository = new $this->classes['repository'](
            new $this->classes['datamapper'](), new $this->classes['model']()
        );
        $this->resource = new $this->classes['resource']();
    }

    /**
     * @param int $id
     * @return false|string
     */
    public function get(int $id){
        $repos = $this->repository->findById($id);

        return $this->resource->output($repos);
    }

}
