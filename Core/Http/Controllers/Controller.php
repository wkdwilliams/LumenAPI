<?php

namespace Core\Http\Controllers;

use App\Message\Resources\MessageResource;
use App\User\Models\User;
use Core\Repository;
use Illuminate\Http\Resources\Json\JsonResource;
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
     * Controller constructor.
     */
    public function __construct()
    {
        $this->repository = new $this->classes['repository'](
            new $this->classes['datamapper'](), new $this->classes['model']()
        );
    }

    /**
     * @param int $id
     * @return false|string
     */
    public function get(int $id): JsonResource
    {
        $repos = $this->repository->findById($id);

        return new $this->classes['resource']($repos);
    }

    public function getAll()
    {
        $repos = $this->repository->findAll();

        return new $this->classes['collection']($repos);
    }

    public function post()
    {

    }

}
