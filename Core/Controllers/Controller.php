<?php

namespace Core\Controllers;

use Core\Exceptions\InvalidIdException;
use Core\Model;
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
    protected Request $request;

    /**
     * The fields that we don't want users to update
     * @var array
     */
    protected array $guardedUpdateFields = [];

    /**
     * The fields that we don't want users to create
     * @var array
     */
    protected array $guardedCreateFields = [];

    /**
     * The validation rules we want when updating a resource
     * @var array
     */
    protected array $updateRules = [];

    /**
     * The validation rules we want when creating a resource
     * @var array
     */
    protected array $createRules = [];

    /**
     * @var array
     */
    protected array $getResourceRules = [];

    /**
     * @var array
     */
    protected array $getResourcesRules = [];

    /**
     * The amount of pagination we want to use
     * when getting multiple recourds
     * @var int
     */
    protected int $paginate = 0;

    /**
     * This gives us quick access to the authenticated user
     * @var Model|null
     */
    protected ?Model $authenticatedUser;

    /**
     * Controller constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->authenticatedUser = auth()->user();
        $this->request           = $request;

        if($this->request->id !== null)
            if(!is_numeric($this->request->id))
                throw new InvalidIdException();

        $this->service = new $this->classes['service'](
            new $this->classes['repository'](
                $this->paginate,
                $this->request->get('page') ?? 1
            )
        );
    }

    /**
     * Return response of our resource
     * @param JsonResource $resource
     * 
     * @return JsonResponse
     */
    protected function response(JsonResource $resource): JsonResponse
    {
        return response()->json([
            'status' => 200,
            'data'   => $resource
        ], 200);
    }

    /**
     * Get resource by id
     * @param int $id
     * @return JsonResponse
     */
    public function getResource(int $id): JsonResponse
    {
        $this->validate($this->request, $this->getResourceRules);

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
        $this->validate($this->request, $this->getResourcesRules);

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
        foreach ($this->guardedCreateFields as $field) {
            $this->request->request->remove($field);
        }

        $this->validate($this->request, $this->createRules);

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
        foreach ($this->guardedUpdateFields as $field) {
            $this->request->request->remove($field);
        }

        $this->validate($this->request, $this->updateRules);

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
