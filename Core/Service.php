<?php

namespace Core;

use Core\DataMapper;
use Core\Entity;
use Core\Repository;
use Core\EntityCollection;

abstract class Service
{
    /**
     * @var Repository
     */
    private Repository $repository;

    function __construct(Repository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param string $id
     * 
     * @return Entity
     */
    public function getResourceById(string $id): Entity
    {
        return $this->repository->findById($id);
    }

    /**
     * @return EntityCollection
     */
    public function getResources(): EntityCollection
    {
        return $this->repository->findAll();
    }

    /**
     * @param array $data
     * 
     * @return mixed
     */
    public function createResource(array $data): mixed
    {
        return $this->repository->create($data);
    }

    /**
     * @param array $data
     * 
     * @return mixed
     */
    public function updateResource(array $data): mixed
    {
        return $this->repository->update($data);
    }

    /**
     * @param array $data
     * 
     * @return mixed
     */
    public function deleteResource(array $data): mixed
    {
        return $this->repository->delete($data);
    }
}