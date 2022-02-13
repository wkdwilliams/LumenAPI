<?php

namespace Core\Http\Controllers;

use Core\Repository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
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
     * @var Request
     */
    protected $request;

    /**
     * Controller constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->repository = new $this->classes['repository'](
            new $this->classes['datamapper'](), new $this->classes['model']()
        );

        $this->request = $request;
    }

    /**
     * Get resource by id
     * @param int $id
     * @return false|string
     */
    public function getResource(int $id): Response
    {
        $repos = $this->repository->findById($id);

        return Response(
            new $this->classes['resource']($repos)
        );
    }

    /**
     * Get all resources
     * @return Response
     */
    public function getResources(): Response
    {
        $repos = $this->repository->findAll();

        return Response(
            new $this->classes['collection']($repos)
        );
    }

    /**
     * Create resource
     * @return Response
     */
    public function createResource(): Response
    {
        $data = $this->request->all();

        $repos = $this->repository->create($data);

        return Response(
            new $this->classes['resource']($repos)
        );
    }

    /**
     * Update resource
     * @return Response
     */
    public function updateResource(): Response
    {
        $data = $this->request->all();

        $repos = $this->repository->update($data);

        return Response(
            new $this->classes['resource']($repos)
        );
    }

    public function deleteResource()
    {
        $data = $this->request->all();

        $repos = $this->repository->delete($data);

        return Response(
            new $this->classes['resource']($repos)
        );
    }

}
