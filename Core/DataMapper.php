<?php

namespace Core;

use Core\Entity;

abstract class DataMapper
{
    /**
     * @var Entity
     */
    protected $entity;

    public function __construct()
    {
        $this->entity = new $this->entity();
    }

    /**
     * Used for populating an entity with data retrived from the repository
     * @param array $data
     * @return Entity
     */
    public function getEntity(array $data): Entity
    {
        $this->entity = new $this->entity();
        return $this->entity->populate($this->fromRepository($data));
    }

    /**
     * Used when populating an entity with data sent by a client
     * @param array $data
     * @return Entity
     */
    public function toEntity(array $data): Entity
    {
        $this->entity = new $this->entity();
        return $this->entity->populate($this->toRepository($data));
    }

    public function getEntityCollection(array $data): EntityCollection
    {
        $collection = new EntityCollection();

        foreach ($data as $d)
        {
            $collection->push($this->getEntity($d));
        }

        return $collection;
    }

    /**
     * Used for mapping data from a repository
     * @param array $data
     * @return array
     */
    abstract protected function fromRepository(array $data): array;

    /**
     * Used for mapping data to a repository
     * @param array $data
     * @return array
     */
    abstract protected function toRepository(array $data): array;

    /**
     * Used for mapping an entity to processed
     * @param array $data
     * @return array
     */
    abstract public function fromApplication(Entity $data): array;

}
