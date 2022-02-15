<?php

namespace Core\Http\Controllers;

use Core\Repository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
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

    protected function response(JsonResource $resource)
    {
        return response()->json(['data' => $resource]);
    }

    /**
     * Get resource by id
     * @param int $id
     * @return JsonResponse
     */
    public function getResource(int $id): JsonResponse
    {
        // $user = new $this->classes['model']();
        // $user = $user->where(['id' => $id])->first()->toArray();
        // dd($user);
        $repos = $this->repository->findById($id);

        return $this->response(
            new $this->classes['resource']($repos)
        );
    }

    /**
     * Get all resources
     * @return JsonResponse
     */
    public function getResources(): JsonResponse
    {
        $repos = $this->repository->findAll();

        return $this->response(
            new $this->classes['collection']($repos)
        );
    }

    /**
     * Create resource
     * @return JsonResponse
     */
    public function createResource(): JsonResponse
    {
        $data = $this->request->all();

        $repos = $this->repository->create($data);

        return $this->response(
            new $this->classes['resource']($repos)
        );
    }

    /**
     * Update resource
     * @return JsonResponse
     */
    public function updateResource(): JsonResponse
    {
        $data = $this->request->all();

        $repos = $this->repository->update($data);

        return $this->response(
            new $this->classes['resource']($repos)
        );
    }

    /**
     * @return JsonResponse
     */
    public function deleteResource(): JsonResponse
    {
        $data = $this->request->all();

        $repos = $this->repository->delete($data);

        return $this->response(
            new $this->classes['resource']($repos)
        );
    }

}
