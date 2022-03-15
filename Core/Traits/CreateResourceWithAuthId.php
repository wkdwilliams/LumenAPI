<?php

namespace Core\Traits;

use Illuminate\Http\JsonResponse;

trait CreateResourceWithAuthId
{

    /**
     * Create resource
     * @return JsonResponse
     */
    public function createResource(): JsonResponse
    {
        $this->request->request->add([
            'user_id' => $this->authenticatedUser->id
        ]);

        return parent::createResource();
    }

}