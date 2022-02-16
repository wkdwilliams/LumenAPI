<?php

namespace Core\Http\Controllers;

use Core\Service;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    /**
     * @var array
     */
    protected array $classes;

    /**
     * @var Service
     */
    protected Service $service;

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
        $this->service = new $this->classes['service'](
            new $this->classes['repository'](
                new $this->classes['datamapper'](), new $this->classes['model']()
            )
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
        $repos = $this->service->getResourceById($id);

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
        $repos = $this->service->getResources();

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

        $repos = $this->service->createResource($data);

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

        $repos = $this->service->updateResource($data);

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

        $repos = $this->service->deleteResource($data);

        return $this->response(
            new $this->classes['resource']($repos)
        );
    }

}
