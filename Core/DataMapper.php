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
     * @param array $data
     * @return Entity
     */
    public function getEntity(array $data): Entity
    {
        return $this->entity->populate($this->fromRepository($data));
    }

    /**
     * @param array $data
     * @return array
     */
    abstract protected function fromRepository(array $data): array;

    /**
     * @param array $data
     * @return array
     */
    abstract protected function fromApplication(array $data): array;

}
