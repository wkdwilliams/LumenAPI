<?php

namespace Core\Traits;

use Core\Exceptions\PermissionDeniedException;
use Illuminate\Http\JsonResponse;

trait CheckResourceBelongsToUser
{
    
    /**
     * Get resource by id
     * @param int $id
     * @return JsonResponse
     */
    public function getResource(int $id): JsonResponse
    {
        if(!$this->service->resourceBelongsToUser($this->authenticatedUser->id, $id))
            throw new PermissionDeniedException();
        
        return parent::getResource($id);
    }

    /**
     * Get all resources
     * @return JsonResponse
     */
    public function getResources(): JsonResponse
    {
        $repos = $this->service->getResourcesByUserId($this->authenticatedUser->id);

        return $this->response(
            new $this->classes['collection']($repos)
        );
    }

    /**
     * Update resource
     * @return JsonResponse
     */
    public function updateResource(): JsonResponse
    {
        if(!$this->service->resourceBelongsToUser($this->authenticatedUser->id, $this->request->id))
            throw new PermissionDeniedException();

        return parent::updateResource();
    }

    /**
     * @return JsonResponse
     */
    public function deleteResource(): JsonResponse
    {
        if(!$this->service->resourceBelongsToUser($this->authenticatedUser->id, $this->request->id))
            throw new PermissionDeniedException();

        return parent::deleteResource();
    }
}