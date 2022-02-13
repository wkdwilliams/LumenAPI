<?php

namespace Core;

use Illuminate\Support\Collection;

class EntityCollection
{
    /**
     * @var array
     */
    private $entities;

    public function __construct(array $entities = [])
    {
        $this->entities = $entities;
    }

    public function push(Entity $entity): EntityCollection
    {
        $this->entities[] = $entity;

        return $this;
    }

    public function empty(): EntityCollection
    {
        $this->entities = [];

        return $this;
    }

    public function getEntities(): array
    {
        return $this->entities;
    }

    public function toLaravelCollection(): Collection
    {
        return new Collection($this->entities);
    }


}
