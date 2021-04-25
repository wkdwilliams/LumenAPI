<?php


namespace Core;


abstract class Resource
{
    /**
     * @param Entity $entity
     * @return array
     */
    abstract public function toArray(Entity $entity): array;

    /**
     * @param Entity $entity
     * @return false|string
     */
    public function output(Entity $entity)
    {
        return response()->json($this->toArray($entity));
    }
}