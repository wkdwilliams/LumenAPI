<?php

namespace Core;

use Illuminate\Support\Str;

abstract class Entity
{

    /**
     * @var string
     */
    protected $id;

    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @param array $data
     * @return Entity
     */
    public function populate(array $data): Entity
    {
        foreach ($data as $key => $value)
        {
            $this->{Str::camel('set_' . $key)}($value);
        }

        return $this;
    }

}
